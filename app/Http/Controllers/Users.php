<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Library\Services\Contracts\UsersInterface;
use App\Library\Services\Contracts\RegionsInterface;
use App\Library\Services\Contracts\DivisionsInterface;
use App\Library\Services\Contracts\SectorInterface;
use App\Library\Services\Contracts\StakeholdersInterface;
use App\Library\Services\Contracts\SchoolInterface;
use Illuminate\Support\Facades\Auth;

class Users extends Controller
{

	private $stakeholders;
	private $school;
	private $regions;
	private $divisions;
	private $sector;

	public function __construct(
		StakeholdersInterface $stakeholders,
		SchoolInterface $school, 
		RegionsInterface $regions, 
		DivisionsInterface $divisions,
		SectorInterface $sector
	) {
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

    public function stakeholderRegister(Request $req) {

    	$this->stakeholders->register($req);
    }

    public function schoolRegister(Request $req) {

    	$this->school->register($req);
    }

    public function login() {

    	return view('users.login');
    }

    public function stakeholdersAuth(Request $request) {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('stakeholders')->attempt($credentials)) {
            // Authentication passed...
            return redirect()->intended('account/stakeholders');
        }
    }

    public function schoolsAuth(Request $request) {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('schools')->attempt($credentials)) {
            // Authentication passed...
            return redirect()->intended('account/schools');
        }
    }    

}
