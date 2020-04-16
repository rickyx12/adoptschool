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

    public function update(Request $req) {

        $req->validate([
            'schoolId' => 'required',
            'name' => 'required',
            'region' => 'required',
            'division' => 'required',
            'schoolType' => 'required',
            'accountablePerson' => 'required',
            'position' => 'required',
            'contactNo' => 'required'
        ]);

        $schoolId = $req->input('schoolId');
        $name = $req->input('name');
        $region = $req->input('region');
        $division = $req->input('division');
        $schoolType = $req->input('schoolType');
        $accountablePerson = $req->input('accountablePerson');
        $position = $req->input('position');
        $contactNo = $req->input('contactNo');

        $data = [
            'schoolId' => $schoolId,
            'name' => $name,
            'region' => $region,
            'division' => $division,
            'schoolType' => $schoolType,
            'accountablePerson' => $accountablePerson,
            'position' => $position,
            'contactNo' => $contactNo
        ];

        return DB::update('UPDATE school_users SET name = :name, region = :region, division = :division, school_type = :schoolType, accountable_person = :accountablePerson, position = :position, contact_no = :contactNo WHERE id = :schoolId', $data);
    }

    public function type() {

        return DB::select('SELECT * FROM school_type WHERE is_deleted = ?',[0]);
    }


    public function getStakeholdersProject($schoolId, Request $req) 
    {

        if($req->has('offset') && $req->has('rowCount')) 
        {
            $offset = $req->input('offset');
            $rowCount = $req->input('rowCount');

            $stakeholder = DB::select('
                                SELECT p.id as projectId, 
                                        su.name as school, 
                                        c.name as category, 
                                        sc.name as sub_category,
                                        ps.stakeholder,
                                        ps.monetary_value_donation as contributedAmount,
                                        ps.quantity_donation as contributedQTY,
                                        ps.contact_no as stakeholder_contact,
                                        ps.approved,
                                        ps.message,
                                        ps.date_application,
                                        ps.transaction_date,
                                        stakeholder_users.name as stakeholderName,
                                        au.complete_name as staff,
                                        p.qty as neededQTY, 
                                        p.amount, 
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
                                JOIN stakeholder_users
                                ON ps.stakeholder = stakeholder_users.id
                                LEFT JOIN admin_users au
                                ON ps.assisting_admin = au.id
                                WHERE p.school = :schoolId
                                ORDER BY ps.date_application DESC
                                LIMIT :offset, :rowCount
                                ',
                                [
                                    'schoolId' => $schoolId,
                                    'offset' => $offset,
                                    'rowCount' => $rowCount
                                ]
                            );

        }else 
        {
            $stakeholder = DB::select('
                                SELECT p.id as projectId, 
                                        su.name as school, 
                                        c.name as category, 
                                        sc.name as sub_category,
                                        ps.stakeholder,
                                        ps.monetary_value_donation as contributedAmount,
                                        ps.quantity_donation as contributedQTY,
                                        ps.contact_no as stakeholder_contact,
                                        ps.approved,
                                        ps.message,
                                        ps.date_application,
                                        ps.transaction_date,
                                        stakeholder_users.name as stakeholderName,
                                        au.complete_name as staff,
                                        p.qty as neededQTY, 
                                        p.amount, 
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
                                JOIN stakeholder_users
                                ON ps.stakeholder = stakeholder_users.id
                                LEFT JOIN admin_users au
                                ON ps.assisting_admin = au.id
                                WHERE p.school = :schoolId
                                ORDER BY ps.date_application DESC',
                                ['schoolId' => $schoolId]
                            );
        }

        return $stakeholder;
    }


    public function getProfile($schoolId) 
    {

        return DB::select('SELECT
                            su.id as schoolId, 
                            su.name, 
                            su.region as regionId, 
                            su.division as divisionId, 
                            su.school_type as schoolTypeId, 
                            su.address, 
                            su.accountable_person,
                            su.position,
                            su.contact_no,
                            su.date_register,
                            r.name as region,
                            sd.name as division,
                            st.type as schoolType 
                        FROM school_users su
                        JOIN region r 
                        ON su.region = r.id
                        JOIN school_division sd
                        ON su.division = sd.id
                        JOIN school_type st
                        ON su.school_type = st.id
                        WHERE su.id = :schoolId',
                        ['schoolId' => $schoolId]
                );        
    }

}