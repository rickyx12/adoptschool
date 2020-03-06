<?php
namespace App\Library\Services;
  
use App\Library\Services\Contracts\UpdatesInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class Updates implements UpdatesInterface
{

    public function addProjectUpdate(Request $req) 
    {
      
        $req->validate([
            'projectId' => 'required',
            'projectUpdate' => 'required',
            'updateDate' => 'required'
        ]);            

        $projectId = $req->input('projectId');
        $projectUpdate = $req->input('projectUpdate');
        $dateUpdate = $req->input('updateDate');

        $data = [$projectId, $projectUpdate, $dateUpdate];

        DB::insert('INSERT INTO project_updates(project, update_message, date_update) VALUES (?, ?, ?)', $data);
    }

    public function getProjectUpdates($projectId)
    {
            
        $data = array(
            'projectId' => $projectId
        );

        return DB::select('SELECT * FROM project_updates WHERE project = :projectId', $data);
    }
}