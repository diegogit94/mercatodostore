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
   		User::create([

   			'name' => $request->name,
   			'email' => $request->email,
   			'password' => $request->password,

   		]);

   		return back();
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
   		$user->update([

   			'name' => request('name'),
   			'email' => request('email'),
   			// 'user_type' => request('user_type'),

   		]);

   		return redirect()->route('users.show', $user);
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

   		return redirect()->route('users.show', $user);

   		
   }

   public function adminCreateUser(Request $request)
   {
   		User::create([

   			'name' => $request->name,
   			'email' => $request->email,
   			'password' => encrypt($request->password),

   		]);

   		Mail::to($request['email'])->send(new MessageAdmin($request));

   		return redirect()->route('admin.create.user', $request);


   }

}