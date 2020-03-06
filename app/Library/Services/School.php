<?php
namespace App\Library\Services;
  
use App\Library\Services\Contracts\SchoolInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class School implements SchoolInterface {

    public function register(Request $req) {

    	$req->validate([
    		'schoolName' => 'required|max:255',
    		'region' => 'required',
    		'division' => 'required',
            'schoolType' => 'required',
            'accountablePerson' => 'required',
            'position' => 'required',
            'contactNo' => 'required',
            'address' => 'required',
    		'emailAdd' => 'required',
    		'tempPassword' => 'required',
    		'captcha' => 'required|captcha'
    	]);


        $schoolName = $req->input('schoolName');
        $region = $req->input('region');
        $division = $req->input('division');
        $schoolType = $req->input('schoolType');
        $accountablePerson = $req->input('accountablePerson');
        $position = $req->input('position');
    	$contactNo = $req->input('contactNo');
        $address = $req->input('address');
    	$emailAdd = $req->input('emailAdd');
    	$tempPassword = Hash::make($req->input('tempPassword'));
    	$captcha = $req->input('captcha');

    	$data = [
            $emailAdd, 
            $tempPassword,            
            $schoolName, 
            $region, 
            $division,
            $schoolType, 
            $accountablePerson,
            $position, 
            $contactNo,
            $address,
            date('Y-m-d')
        ];

    	DB::insert('INSERT INTO school_users(email, password, name, region, division, school_type, accountable_person, position, contact_no, address, date_register) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', $data);  	
    }

    public function type() {

        return DB::select('SELECT * FROM school_type WHERE is_deleted = ?',[0]);
    }

}