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


    public function getStakeholdersProject($schoolId) 
    {

        return DB::select('
                    SELECT p.id, 
                            su.name as school, 
                            c.name as category, 
                            sc.name as sub_category,
                            ps.stakeholder,
                            ps.contact_no as stakeholder_contact,
                            ps.approved,
                            ps.message,
                            ps.date_application, 
                            p.qty, p.amount, 
                            p.students_beneficiary, 
                            p.personnels_beneficiary, 
                            p.implementation_date,
                            p.accountable_person,
                            p.contact_no, 
                            p.description, 
                            sy.school_year as school_year
                    FROM projects p
                    JOIN school_users su
                    ON p.school = su.id
                    JOIN category c
                    ON p.category = c.id
                    JOIN sub_category sc
                    ON p.sub_category = sc.id
                    JOIN school_year sy
                    ON p.school_year = sy.id
                    JOIN project_stakeholders ps
                    ON p.id = ps.project
                    WHERE p.school = :schoolId
                    ORDER BY p.implementation_date ASC',
                    ['schoolId' => $schoolId]
                );
    }


    public function publishControl(Request $req) 
    {

        $projectId = $req->input('projectId');
        $action = $req->input('action');

        $data = array(
            'projectId' => $projectId
        );

        if($action == "unpublish") 
        {
            return DB::update('UPDATE projects SET publish = 0 WHERE id = :projectId', $data);
        }else 
        {
            return DB::update('UPDATE projects SET publish = 1 WHERE id = :projectId', $data);
        }

    }

}