<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Admin extends Controller
{
    public function index()
    {
    	return view('account.admin.dashboard.index');
    }

    public function request() 
    {
    	return view('account.admin.request.index');
    }

	public function logout() {
		Auth::guard('admin')->logout();
		return redirect('/home');
	}    
}
