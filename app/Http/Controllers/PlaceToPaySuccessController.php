<?php

namespace App\Http\Controllers;

use App\Library\PlaceToPayConnection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PlaceToPaySuccessController extends Controller
{
    public function index()
    {
        $auth = new PlaceToPayConnection();

        $info = $auth->getRequestInformation();

        return $info;

//        return view('placeToPaySuccess')->with('info', $info);
    }
}
