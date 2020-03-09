<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Library\Services\Contracts\AdminInterface;
use App\Library\Services\Contracts\UsersInterface;
use App\Library\Services\Contracts\RegionsInterface;
use App\Library\Services\Contracts\DivisionsInterface;
use App\Library\Services\Contracts\SectorInterface;
use App\Library\Services\Contracts\StakeholdersInterface;
use App\Library\Services\Contracts\SchoolInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class Users extends Controller
{

    private $admin;
	private $stakeholders;
	private $school;
	private $regions;
	private $divisions;
	private $sector;

	public function __construct(
        AdminInterface $admin,
		StakeholdersInterface $stakeholders,
		SchoolInterface $school, 
		RegionsInterface $regions, 
		DivisionsInterface $divisions,
		SectorInterface $sector
	) {
        $this->admin = $admin;
		$this->stakeholders = $stakeholders;
		$this->school = $school;
		$this->regions = $regions;
		$this->divisions = $divisions;
		$this->sector = $sector;
	}

	public function getSector() {
		
		return response()->json($this->sector->getSector());
	}

	public function getSubSector($sectorId) {

		return response()->json($this->sector->getSubSector($sectorId));
	}

	public function getDivision($regionId) {

		return response()->json($this->divisions->getDivisions($regionId));
	}

    public function stakeholder() {

    	return view('users.stakeholders-registration');
    }

    public function school() {

    	$data = array(
    		'regions' => $this->regions->getRegion(),
    		'types' => $this->school->type()
    	);

    	return view('users.school-registration',$data);
    }

    public function admin() {

        if(Config::get('admin.registration')) {
            return view('users.admin-registration');
        }else {
            return abort(404);
        }
    }

    public function stakeholderRegister(Request $req) {

    	$this->stakeholders->register($req);
    }

    public function schoolRegister(Request $req) {

    	$this->school->register($req);
    }

    public function adminRegister(Request $req) {

        $this->admin->register($req);
    }

    public function login() {

    	return view('users.login');
    }

    public function adminLogin() {

        if(Config::get('admin.login')) {
            return view('users.admin-login');
        }else {
            return abort(404);
        }
    }

    public function stakeholdersAuth(Request $request) {
        
        $credentials = $request->only('email', 'password');

        if (Auth::guard('stakeholders')->attempt($credentials)) {
            
            return redirect()->intended('account/stakeholders');
        }else {
            return redirect('/login')->with('error', 'Credentials Incorrect.');
        }
    }

    public function schoolsAuth(Request $request) {
        
        $credentials = $request->only('email', 'password');

        if (Auth::guard('schools')->attempt($credentials)) {

            return redirect()->intended('account/schools');
        }else {
            return redirect('/login')->with('error', 'Credentials Incorrect.');
        }
    }

    public function adminAuth(Request $request) {
        
        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {

            return redirect()->intended('account/admin');
        }else {
            return redirect('admin/login')->with('error', 'Credentials Incorrect.');
        }
    }        

}
