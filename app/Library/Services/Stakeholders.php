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


    public function getProjectContributions($stakeholderId, Request $req) 
    {

       if($req->has('offset') && $req->has('rowCount')) 
       {
            $offset = $req->input('offset');
            $rowCount = $req->input('rowCount');
       }else
       {
            $offset = 0;
            $offset = 3;
       }

        return DB::select('
                    SELECT ps.id as contributionId,
                        ps.project,
                        ps.monetary_value_donation,
                        ps.quantity_donation,
                        ps.reference_document,
                        ps.transaction_date,
                        ps.date_application,
                        ps.approved,
                        p.id as projectId,
                        p.qty,
                        admin.complete_name as approved_by,
                        su.name as school,
                        sc.name as sub_category
                    FROM project_stakeholders ps
                    JOIN projects p
                    ON ps.project = p.id
                    JOIN school_users su
                    ON p.school = su.id
                    JOIN sub_category sc
                    ON p.sub_category = sc.id
                    LEFT JOIN admin_users admin
                    ON ps.assisting_admin = admin.id
                    WHERE ps.stakeholder = :stakeholderId
                    ORDER BY ps.date_application DESC
                    LIMIT :offset, :rowCount',
                    [
                        'stakeholderId' => $stakeholderId,
                        'offset' => $offset,
                        'rowCount' => $rowCount
                    ]
                );
    }


    public function cancelContribution(Request $req)
    {

        $req->validate([
            'contributionId' => 'required'
        ]);

        $data = array(
            'contributionId' => $req->input('contributionId')
        );

        return DB::delete('DELETE FROM project_stakeholders WHERE id = :contributionId', $data);
    }

    public function getInformation($stakeholderId) 
    {

        return DB::select('
                    SELECT su.id stakeholderId, su.email, su.name, s.id as sectorId, s.sector, ss.id as subsectorId, ss.name as subsector, su.date_register  
                    FROM stakeholder_users su
                    JOIN sector s 
                    ON su.sector = s.id
                    JOIN sub_sector ss
                    ON su.subsector = ss.id
                    WHERE su.id = :stakeholderId',
                    ['stakeholderId' => $stakeholderId]
                );
    }

    public function update(Request $req)
    {   

        $req->validate([
            'name' => 'required|max:255',
            'sector' => 'required',
            'subSector' => 'required',
            'stakeholderId' => 'required'
        ]);

        $data = array(
            'name' => $req->input('name'),
            'sector' => $req->input('sector'),
            'subSector' => $req->input('subSector'),
            'id' => $req->input('stakeholderId')
        );

        return DB::update('UPDATE stakeholder_users SET name = :name, sector = :sector, subsector = :subSector WHERE id = :id', $data);        
    }

}