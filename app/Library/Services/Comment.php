<?php
namespace App\Library\Services;
  
use App\Library\Services\Contracts\CommentInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Comment implements CommentInterface
{

    public function add(Request $req) 
    {
      
        $req->validate([
            'projectId' => 'required',
            'comment' => 'required'
        ]);     

        $userType = null;

        if(Auth::guard('stakeholders')->check())  {
            $userType = 'stakeholders';
        }else {
            $userType = 'schools';
        }    

        $userId = Auth::user()->id;
        $projectId = $req->input('projectId');
        $comment = $req->input('comment');

        $data = [
            $userId, $userType, $projectId, $comment
        ];

        DB::insert('INSERT INTO comments(user, user_type, project, comment) VALUES (?, ?, ?, ?)', $data);
    }

    public function getComments($projectId) {

        $data = array(
            'projectId' => $projectId
        );

        $comments = DB::select('SELECT c.user_type FROM comments c WHERE c.project = :projectId',$data);

        foreach($comments as $comment) 
        {
            if($comment->user_type == 'stakeholders') 
            {
                 return DB::select('
                        SELECT 
                            c.comment, stakeholders.name 
                        FROM comments c
                        JOIN stakeholder_users stakeholders
                        ON stakeholders.id = c.user 
                        WHERE c.project = :projectId',$data);
            }else 
            {
                return DB::select('
                        SELECT 
                            c.comment, school.name 
                        FROM comments c
                        JOIN school_users school
                        ON school.id = c.user 
                        WHERE c.project = :projectId',$data);         
            }
        }

    }

}