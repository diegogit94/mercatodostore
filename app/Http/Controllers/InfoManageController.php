<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InfoManageController extends Controller
{
    public function index()
    {
        return view('admin.manageAdminInfo');
    }
}
