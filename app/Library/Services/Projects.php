<?php
namespace App\Library\Services;
  
use App\Library\Services\Contracts\ProjectsInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class Projects implements ProjectsInterface
{

    public function add($schoolId, $categoryId, Request $req) 
    {
      
    	$req->validate([
    		'needs' => 'required|numeric',
    		'qty' => 'required|numeric',
    		'amount' => 'required|numeric',
    		'studentsBeneficiary' => 'required|numeric',
    		'personnelsBeneficiary' => 'required|numeric',
            'accountablePerson' => 'required',
            'contactNo' => 'required:numeric',
    		'implementationDate' => 'required',
    		'schoolYear' => 'required',
    		'description' => 'required'
    	]);    	

    	$needs = $req->input('needs');
    	$qty = $req->input('qty');
    	$amount = $req->input('amount');
    	$studentsBeneficiary = $req->input('studentsBeneficiary');
    	$personnelsBeneficiary = $req->input('personnelsBeneficiary');
    	$implementationDate = $req->input('implementationDate');
        $accountablePerson = $req->input('accountablePerson');
        $contactNo = $req->input('contactNo');
    	$schoolYear = $req->input('schoolYear');
    	$description = $req->input('description');

    	$data = [
    		$schoolId,
    		$categoryId,
    		$needs,
    		$qty,
    		$amount,
    		$studentsBeneficiary,
    		$personnelsBeneficiary,
    		$implementationDate,
            $accountablePerson,
            $contactNo,
    		$schoolYear,
    		$description,
    		date('Y-m-d')
    	];

      	DB::insert('INSERT INTO projects(school, category, sub_category, qty, amount, students_beneficiary, personnels_beneficiary, implementation_date, accountable_person, contact_no, school_year, description, date_added) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', $data);
    }

    public function getProjects($schoolId) 
    {

    	return DB::select('
		    		SELECT  p.id,
                            c.name as category, 
                            sc.name as sub_category, 
                            p.qty, 
                            p.amount, 
                            p.students_beneficiary, 
                            p.personnels_beneficiary, 
                            p.implementation_date,
                            p.accountable_person,
                            p.contact_no, 
                            p.description, 
                            sy.school_year as school_year
		    		FROM projects p
		    		JOIN category c
		    		ON p.category = c.id
		    		JOIN sub_category sc
		    		ON p.sub_category = sc.id
		    		JOIN school_year sy
		    		ON p.school_year = sy.id
		    		WHERE p.school = :schoolId
		    		ORDER BY implementation_date ASC', 
		    		['schoolId' => $schoolId]
		    	);
    }

    public function showAvailableProjects($schoolYearId) 
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
                            sy.school_year as school_year
                    FROM projects p
                    JOIN school_users su
                    ON p.school = su.id
                    JOIN category c
                    ON p.category = c.id
                    JOIN sub_category sc
                    ON p.sub_category = sc.id
                    JOIN school_year sy
                    ON p.school_year = :schoolYearId
                    ORDER BY p.implementation_date ASC',
                    ['schoolYearId' => $schoolYearId]
                );
    }

    public function showFilteredProjects($schoolYearId, Request $req) 
    {

        $bindingArr = [];

        $fundSort = $req->input('fundSort');
        $categorySort = $req->input('categorySort');
        $categorySort = (array)$categorySort;
        $bindingsString = implode(',', array_fill(0, count($categorySort), '?'));

        foreach($categorySort as $category) {
            array_push($bindingArr, $category);
        }

        array_unshift($bindingArr, $schoolYearId);

        $sql ='';

        if(count($categorySort) > 0) 
        {
            if($fundSort === 'low_high') {

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
                            sy.school_year as school_year
                        FROM projects p
                        JOIN school_users su
                        ON p.school = su.id
                        JOIN category c
                        ON p.category = c.id
                        JOIN sub_category sc
                        ON p.sub_category = sc.id
                        JOIN school_year sy
                        ON p.school_year = ?
                        WHERE p.category IN ( {$bindingsString} )
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
                            sy.school_year as school_year
                        FROM projects p
                        JOIN school_users su
                        ON p.school = su.id
                        JOIN category c
                        ON p.category = c.id
                        JOIN sub_category sc
                        ON p.sub_category = sc.id
                        JOIN school_year sy
                        ON p.school_year = ?
                        WHERE p.category IN ( {$bindingsString} )
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
                            sy.school_year as school_year
                    FROM projects p
                    JOIN school_users su
                    ON p.school = su.id
                    JOIN category c
                    ON p.category = c.id
                    JOIN sub_category sc
                    ON p.sub_category = sc.id
                    JOIN school_year sy
                    ON p.school_year = ?
                    WHERE p.category IN ( {$bindingsString} )
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
                            sy.school_year as school_year
                        FROM projects p
                        JOIN school_users su
                        ON p.school = su.id
                        JOIN category c
                        ON p.category = c.id
                        JOIN sub_category sc
                        ON p.sub_category = sc.id
                        JOIN school_year sy
                        ON p.school_year = :schoolYearId
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
                            sy.school_year as school_year
                        FROM projects p
                        JOIN school_users su
                        ON p.school = su.id
                        JOIN category c
                        ON p.category = c.id
                        JOIN sub_category sc
                        ON p.sub_category = sc.id
                        JOIN school_year sy
                        ON p.school_year = :schoolYearId
                        ORDER BY amount DESC
                        ";
            }
        }

        return DB::select($sql, ['schoolYearId' => $schoolYearId]);
    }

}