<?php
namespace App\Library\Services;
  
use App\Library\Services\Contracts\StakeholdersInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class Stakeholders implements StakeholdersInterface {

    public function register(Request $req) {

    	$req->validate([
    		'companyName' => 'required|max:255',
    		'sector' => 'required',
    		'contactNo' => 'required',
    		'emailAdd' => 'required',
    		'tempPassword' => 'required',
    		'captcha' => 'required|captcha'
    	]);

    	$companyName = $req->input('companyName');
    	
    	$sector = $req->input('sector');
    	$sector1 = explode("-",$sector);

    	$contactNo = $req->input('contactNo');
    	$emailAdd = $req->input('emailAdd');
    	$tempPassword = Hash::make($req->input('tempPassword'));
    	$captcha = $req->input('captcha');

    	$data = [$emailAdd, $tempPassword, $companyName, $sector1[0], $sector1[1], date('Y-m-d')];

    	DB::insert('INSERT INTO stakeholder_users(email, password, name, sector, subsector, date_register) VALUES (?, ?, ?, ?, ?, ?)', $data);  	
    }

}