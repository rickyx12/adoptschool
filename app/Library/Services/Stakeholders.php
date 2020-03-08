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


    public function getProjectContributions($stakeholderId) 
    {

        return DB::select('
                    SELECT p.id, 
                            su.name as school, 
                            c.name as category, 
                            sc.name as sub_category, 
                            p.qty, p.amount, 
                            p.students_beneficiary, 
                            p.personnels_beneficiary, 
                            p.implementation_date,
                            p.accountable_person,
                            p.contact_no, 
                            p.description, 
                            sy.school_year as school_year,
                            ps.approved
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
                    WHERE ps.stakeholder = :stakeholderId
                    ORDER BY ps.date_application ASC',
                    ['stakeholderId' => $stakeholderId]
                );
    }



    public function getFilteredProjectContributions($stakeholderId, Request $req) 
    {

        $bindingArr = [];

        $fundSort = $req->input('fundSort');
        $categorySort = $req->input('categorySort');
        $categorySort = (array)$categorySort;
        $bindingsString = implode(',', array_fill(0, count($categorySort), '?'));

        foreach($categorySort as $category) {
            array_push($bindingArr, $category);
        }

        array_unshift($bindingArr, $stakeholderId);

        $sql ='';

        if(count($categorySort) > 0) 
        {
            if($fundSort === 'low_high') 
            {

                $sql = "
                        SELECT p.id, 
                            su.name as school, 
                            c.name as category, 
                            sc.name as sub_category, 
                            p.qty, p.amount, 
                            p.students_beneficiary, 
                            p.personnels_beneficiary, 
                            p.implementation_date,
                            p.accountable_person,
                            p.contact_no, 
                            p.description, 
                            sy.school_year as school_year,
                            ps.approved
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
                        WHERE ps.stakeholder = ?
                        AND  p.category IN ( {$bindingsString} )
                        ORDER BY p.amount ASC
                        ";
            }
            else if($fundSort === 'high_low') {

                $sql = "
                        SELECT p.id, 
                            su.name as school, 
                            c.name as category, 
                            sc.name as sub_category, 
                            p.qty, p.amount, 
                            p.students_beneficiary, 
                            p.personnels_beneficiary, 
                            p.implementation_date,
                            p.accountable_person,
                            p.contact_no, 
                            p.description, 
                            sy.school_year as school_year,
                            ps.approved
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
                        WHERE ps.stakeholder = ?
                        AND p.category IN ( {$bindingsString} )
                        ORDER BY p.amount DESC
                        ";
            }
            else 
            {
                $sql = "
                    SELECT p.id, 
                            su.name as school, 
                            c.name as category, 
                            sc.name as sub_category, 
                            p.qty, p.amount, 
                            p.students_beneficiary, 
                            p.personnels_beneficiary, 
                            p.implementation_date,
                            p.accountable_person,
                            p.contact_no, 
                            p.description, 
                            sy.school_year as school_year,
                            ps.approved
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
                    WHERE ps.stakeholder = ?
                    AND p.category IN ( {$bindingsString} )
                    ORDER BY p.implementation_date DESC
                    ";
            }

            return DB::select($sql, $bindingArr);
            
        }else 
        {
            if($fundSort === 'low_high') 
            {
                $sql = "
                        SELECT p.id, 
                            su.name as school, 
                            c.name as category, 
                            sc.name as sub_category, 
                            p.qty, p.amount, 
                            p.students_beneficiary, 
                            p.personnels_beneficiary, 
                            p.implementation_date,
                            p.accountable_person,
                            p.contact_no, 
                            p.description, 
                            sy.school_year as school_year,
                            ps.approved
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
                        WHERE ps.stakeholder = :stakeholderId
                        ORDER BY amount ASC
                        ";
            }


            if($fundSort === 'high_low') 
            {
                $sql = "
                        SELECT p.id, 
                            su.name as school, 
                            c.name as category, 
                            sc.name as sub_category, 
                            p.qty, p.amount, 
                            p.students_beneficiary, 
                            p.personnels_beneficiary, 
                            p.implementation_date,
                            p.accountable_person,
                            p.contact_no, 
                            p.description, 
                            sy.school_year as school_year,
                            ps.approved
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
                        WHERE su.id = :stakeholderId
                        ORDER BY amount DESC
                        ";
            }
        }

        return DB::select($sql, ['stakeholderId' => $stakeholderId]);
    }


}