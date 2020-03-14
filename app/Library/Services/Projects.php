<?php
namespace App\Library\Services;
  
use App\Library\Services\Contracts\ProjectsInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;

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
                            su.name as school,
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
                            p.status,
                            p.publish, 
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
		    		WHERE p.school = :schoolId
		    		ORDER BY implementation_date ASC', 
		    		['schoolId' => $schoolId]
		    	);
    }


    public function showFilteredSchoolProjects($schoolId, Request $req) 
    {

        $bindingArr = [];

        $fundSort = $req->input('fundSort');
        $categorySort = $req->input('categorySort');
        $categorySort = (array)$categorySort;
        $bindingsString = implode(',', array_fill(0, count($categorySort), '?'));

        foreach($categorySort as $category) {
            array_push($bindingArr, $category);
        }

        array_unshift($bindingArr, $schoolId);

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
                            p.publish, 
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
                        WHERE su.id = ?
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
                            p.publish, 
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
                        WHERE su.id = ?
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
                            p.publish, 
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
                            p.publish, 
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
                        WHERE su.id = :schoolId
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
                            p.publish,
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
                        WHERE su.id = :schoolId
                        ORDER BY amount DESC
                        ";
            }
        }

        return DB::select($sql, ['schoolId' => $schoolId]);
    }


    public function showAvailableProjects($schoolYearId, Request $req) 
    {

        $projects = DB::select('
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
	                    LEFT JOIN project_stakeholders ps
	                    ON p.id = ps.project
	                    WHERE ps.project IS NULL
	                    AND p.publish = 1
	                    ORDER BY p.implementation_date ASC',
	                    ['schoolYearId' => $schoolYearId]
	                );

        return $this->arrayPaginator($projects, $req);
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
                        LEFT JOIN project_stakeholders ps
                        ON p.id = ps.project
                        WHERE p.category IN ( {$bindingsString} )
                        AND ps.project IS NULL
                        AND p.publish = 1
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
                        LEFT JOIN project_stakeholders ps
                        ON p.id = ps.project
                        WHERE p.category IN ( {$bindingsString} )
                        AND ps.project IS NULL
                        AND p.publish = 1
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
                    LEFT JOIN project_stakeholders ps
                    ON p.id = ps.project
                    WHERE p.category IN ( {$bindingsString} )
                    AND ps.project IS NULL
                    AND p.publish = 1
                    ORDER BY p.implementation_date DESC
                    ";
            }

            $filteredProjects = DB::select($sql, $bindingArr);
            return $this->arrayPaginator($filteredProjects, $req);
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
                    LEFT JOIN project_stakeholders ps
                    ON p.id = ps.project
                    WHERE ps.project IS NULL
                    AND p.publish = 1
                    ORDER BY p.amount ASC";
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
                        LEFT JOIN project_stakeholders ps
                        ON p.id = ps.project
                        WHERE ps.project IS NULL
                        AND p.publish = 1
                        ORDER BY p.amount DESC
                        ";
            }
        }

        $filteredProjects = DB::select($sql, ['schoolYearId' => $schoolYearId]);
        return $this->arrayPaginator($filteredProjects, $req);
    }


    public function showAvailableProjectsGuest($schoolYearId, Request $req) 
    {

        $projects = DB::select('
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
		                    WHERE p.publish = 1
		                    ORDER BY p.implementation_date ASC',
		                    ['schoolYearId' => $schoolYearId]
		                );

        return $this->arrayPaginator($projects, $req);
    }


    public function showFilteredProjectsGuest($schoolYearId, Request $req) 
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
                        AND p.publish = 1
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
                        AND p.publish = 1
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
                    AND p.publish = 1
                    ORDER BY p.implementation_date DESC
                    ";
            }

            $filteredProjects = DB::select($sql, $bindingArr);
            return $this->arrayPaginator($filteredProjects, $req);
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
                        WHERE p.publish = 1
                        ORDER BY amount ASC
                        ";
            }else if($fundSort === 'high_low') 
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
                        WHERE p.publish = 1
                        ORDER BY amount DESC
                        ";
            }else
            {
            	abort(404);
            }
        }


       
		$filteredProjects = DB::select($sql, ['schoolYearId' => $schoolYearId]);
		return $this->arrayPaginator($filteredProjects, $req);
     
    }


    public function addStakeholder(Request $req) 
    {
      
        $req->validate([
            'projectId' => 'required|numeric',
            'contactNo' => 'required'
        ]);     

        $projectId = $req->input('projectId');
        $stakeholder = Auth::user()->id;
        $contactNo = $req->input('contactNo');
        $message = $req->input('message');

        $data = [
            $projectId,
            $stakeholder,
            $contactNo,
            $message,
            date('Y-m-d')
        ];

        DB::insert('INSERT INTO project_stakeholders(project, stakeholder, contact_no, message, date_application) VALUES (?, ?, ?, ?, ?)', $data);
    }

    public function isStakeholder($stakeholderId, $projectId) {

        $data = array(
            'stakeholderId' => $stakeholderId,
            'projectId' => $projectId
        );

        return DB::raw('SELECT id FROM project_stakeholders WHERE stakeholder = :stakeholderId AND project = :projectId ', $data);
    }

    public function getProjectStakeholders($projectId) {

        $data = array(
            'projectId' => $projectId
        );

        return DB::select('SELECT su.name
                            FROM project_stakeholders ps
                            JOIN stakeholder_users su
                            ON ps.stakeholder = su.id
                            WHERE ps.project = :projectId 
                            AND ps.approved = 1', 
                            $data
                        );
    }

    public function getPendingRequestProject() 
    {

        return DB::select('
                    SELECT p.id,
                            ps.id as requestId, 
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
                    WHERE ps.approved = 0
                    ORDER BY ps.date_application ASC'
                );
    }

    public function getSingleProject($projectId) 
    {

        $data = array(
            'projectId' => $projectId
        );

        return DB::select('
                    SELECT p.id,
                            ps.id as requestId, 
                            su.name as school, 
                            c.name as category, 
                            sc.name as sub_category,
                            ps.stakeholder,
                            ps.contact_no as stakeholder_contact,
                            ps.approved,
                            ps.message,
                            ps.date_application,
                            ps.quantity_donation, 
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
                    WHERE p.id = :projectId
                    ORDER BY ps.date_application ASC',
                    $data
                );
    }


	private function arrayPaginator($array, $request)
	{

		if(is_numeric($request->get('page'))) {

		    $page = $request->get('page');
		    $perPage = 2;
		    $offset = ($page * $perPage) - $perPage;

		    return new LengthAwarePaginator(array_slice($array, $offset, $perPage, true), count($array), $perPage, $page,
		        ['path' => $request->url(), 'query' => $request->query()]);
		}else {
			abort(404);
		}

	}

}