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
            $userId, $userType, $projectId, $comment, ''
        ];

        DB::insert('INSERT INTO comments(user, user_type, project, comment, seen) VALUES (?, ?, ?, ?, ?)', $data);
    }

    public function getComments($projectId) {

        $outputArr = array();

        $data = array(
            'projectId' => $projectId
        );

        $comments = DB::select('SELECT * FROM comments WHERE project = :projectId',$data);

        foreach($comments as $comment) {

            if($comment->user_type === 'stakeholders') 
            {
                 $comment = DB::select('
                                SELECT 
                                    c.comment, stakeholders.name
                                FROM comments c
                                JOIN stakeholder_users stakeholders
                                ON stakeholders.id = c.user 
                                WHERE c.id = :commentId', 
                                ['commentId' => $comment->id]
                            );

                 array_push($outputArr, $comment[0]);
            } 
            else
            { 
                $comment = DB::select('
                                SELECT 
                                    c.comment, school.name 
                                FROM comments c
                                JOIN school_users school
                                ON school.id = c.user 
                                WHERE c.id = :commentId',
                                ['commentId' => $comment->id]
                            );         
                array_push($outputArr, $comment[0]);
            }  
        }

        return $outputArr;
    }
}