<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Library\Services\Contracts\CategoryInterface;
use App\Library\Services\Contracts\SchoolYearInterface;
use App\Library\Services\Contracts\ProjectsInterface;
use App\Library\Services\Contracts\UpdatesInterface;
use App\Library\Services\Contracts\CommentInterface;

class Schools extends Controller
{
    
	private $category;
	private $schoolYear;
	private $projects;
	private $updates;
	private $comments;

    public function __construct(
    	CategoryInterface $category, 
    	SchoolYearInterface $schoolYear,
    	ProjectsInterface $projects,
    	UpdatesInterface $updates,
    	CommentInterface $comments
    ) {

    	$this->category = $category;
    	$this->schoolYear = $schoolYear;
    	$this->projects = $projects;
    	$this->updates = $updates;
    	$this->comments = $comments;

    	$this->middleware('auth:schools');
    }

	public function index() 
	{

		return view('account.schools.dashboard.index');
	}

	public function projects() 
	{

		$data = array(
			'categories' => $this->category->getCategory(),
			'schoolYear' => $this->schoolYear->getSchoolYear(),
			'projects' => $this->projects->getProjects(Auth::user()->id)
		);

		return view('account.schools.projects.index', $data);
	}

	public function newProject(Request $req) 
	{

		$schoolId = Auth::user()->id;
		$categoryNeeds = $this->category->getSubCategoryById($req->input('needs'))[0]->category;

		$this->projects->add($schoolId, $categoryNeeds, $req);
	}

	public function addProjectUpdate(Request $req) 
	{
		return $this->updates->addProjectUpdate($req);
	}

	public function addComment(Request $req) {
		$this->comments->add($req);
	}

	public function getComments($projectId) {
		return response()->json($this->comments->getComments($projectId));
	}

	public function getSingleComments($commentId, $userType) {
		return response()->json($this->comments->getSingleComments($commentId, $userType));
	}

	public function logout() 
	{
		Auth::guard('schools')->logout();
		return redirect('/home');
	}

}
