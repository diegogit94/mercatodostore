<?php

namespace App\Console\Commands;

use App\Events\StatusUpdatedEvent;
use App\Library\PlaceToPayConnection;
use App\Order;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CheckPendingOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check on the orders table the pending transactions and consult to p2p the status';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $pendingOrders = Order::where('status', 'PENDING')->get();

        $pendingOrders->map(function ($order) {

            $connection = new PlaceToPayConnection();
            $connection->authentication();

            $response = $connection->getRequestInformation($order['request_id']);

            if ($response['status']['status'] !== $order['status'])
            {
                event(new StatusUpdatedEvent($response));

                DB::table('orders')
                    ->where('request_id', $order['request_id'])
                    ->update(['transaction_information' => $response, 'status' => $response['status']['status']]);

            }
        });
    }
}
