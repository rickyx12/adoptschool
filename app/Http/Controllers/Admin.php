<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Library\Services\Contracts\ProjectsInterface;
use App\Library\Services\Contracts\AdminInterface;

class Admin extends Controller
{

	private $admin;
	private $projects;

	public function __construct(AdminInterface $admin, ProjectsInterface $projects)
	{
		$this->admin = $admin;
		$this->projects = $projects;

		$this->middleware('auth:admin');
	}

    public function index()
    {
    	return view('account.admin.dashboard.index');
    }

    public function request() 
    {
    	$data = array(
    		'projects' => $this->projects->getPendingRequestProject()
    	);

    	return view('account.admin.request.index', $data);
    }

    public function approved(Request $req) 
    {
    	$this->admin->approved($req);
    }

	public function logout() {
		Auth::guard('admin')->logout();
		return redirect('/home');
	}    
}
