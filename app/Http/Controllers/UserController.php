<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use App\Mail\MessageAdmin;

class UserController extends Controller
{

	public function __construct()
	{
		$this->middleware('admin');
	}

   public function index()
   {
   		$users = User::latest()->get();

   		return view('admin.admin', [

   			'users' => $users

   		]);
   }

   public function store(Request $request)
   {
         request()->validate([

            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required'

         ]);

   		User::create([

   			'name' => $request->name,
   			'email' => $request->email,
   			'password' => encrypt($request->password),

   		]);

   		Mail::to($request['email'])->send(new MessageAdmin($request));

         return redirect()->route('users.create', $request);
   }

   public function destroy(User $user)
   {
   		$user->delete();

   		return back();
   }

   public function edit(User $user)
   {

   		return view('admin.editUsers', [

   			'user' => $user

   		]);

   }

   public function update(User $user)
   {
         request()->validate([
               'name' => 'required',
               'email' => 'required|email',
         ]);

   		$user->update([

   			'name' => request('name'),
   			'email' => request('email'),
   			// 'user_type' => request('user_type'),

   		]);

   		return redirect()->route('users.index', $user);
   }

   public function activate(User $user)
   {

   		if ($user['active'] == 1) {

   			$user->update([

   			'active' => 0

   		]);
   		}else{

   			$user->update([

   			'active' => 1,

   		]);
   		};

   		return redirect()->route('users.index', $user);
   }
}
