<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Library\Services\Contracts\SchoolInterface;
use App\Library\Services\Contracts\RegionsInterface;
use App\Library\Services\Contracts\DivisionsInterface;
use App\Library\Services\Contracts\CategoryInterface;
use App\Library\Services\Contracts\SchoolTypeInterface;
use App\Library\Services\Contracts\SchoolYearInterface;
use App\Library\Services\Contracts\ProjectsInterface;
use App\Library\Services\Contracts\UpdatesInterface;
use App\Library\Services\Contracts\CommentInterface;

class Schools extends Controller
{
    
    private $schools;
    private $regions;
    private $divisions;
	private $category;
	private $schoolType;
	private $schoolYear;
	private $projects;
	private $updates;
	private $comments;

    public function __construct(
    	SchoolInterface $schools,
    	RegionsInterface $regions,
    	DivisionsInterface $divisions,
    	CategoryInterface $category, 
    	SchoolTypeInterface $schoolType,
    	SchoolYearInterface $schoolYear,
    	ProjectsInterface $projects,
    	UpdatesInterface $updates,
    	CommentInterface $comments
    ) {

    	$this->schools = $schools;
    	$this->regions = $regions;
    	$this->divisions = $divisions;
    	$this->category = $category;
    	$this->schoolType = $schoolType;
    	$this->schoolYear = $schoolYear;
    	$this->projects = $projects;
    	$this->updates = $updates;
    	$this->comments = $comments;

    	$this->middleware('auth:schools');
    }

	public function index() 
	{

		$stakeholdersArr = [];
		$onProcessArr = [];
		$totalContribution = 0;

		foreach($this->schools->getStakeholdersProject(Auth::user()->id, new Request) as $stakeholders) {
			if($stakeholders->approved == 1) {
				array_push($stakeholdersArr, $stakeholders);
				$totalContribution += $stakeholders->contributedAmount;
			}else {
				array_push($onProcessArr, $stakeholders);
			}
		}


		$data = array(
			'projects' => $this->projects->getProjects(Auth::user()->id, new Request),
			'stakeholders' => $stakeholdersArr,
			'contributions' => $totalContribution,
			'onProcess' => $onProcessArr
		);

		return view('account.schools.dashboard.index', $data);
	}

	public function profile() 
	{
		$data = [
			'profile' => $this->schools->getProfile(Auth::user()->id)[0],
			'regions' => $this->regions->getRegion(),
			'schoolType' => $this->schoolType->getSchoolType()
		];

		return view('account.schools.profile.index', $data);
	}

	public function update(Request $req) {
		$this->schools->update($req);
	}

	public function projects(Request $req) 
	{

		$data = array(
			'categories' => $this->category->getCategory(),
			'schoolYear' => $this->schoolYear->getSchoolYear()
		);

		return view('account.schools.projects.index', $data);
	}

	public function projectsJSON(Request $req) 
	{
		
		return response()->json($this->projects->getProjects(Auth::user()->id, $req));
	}

	public function projectsByImplementationDate(Request $req) 
	{

		return response()->json($this->projects->getProjectsByImplementationDate(Auth::user()->id, $req));
	}

	public function newProject(Request $req) 
	{

		$req->validate([
			'needs' => 'required|numeric'
		]);

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

	public function stakeholders() 
	{
		return view('account.schools.stakeholders.index');	
	}

	public function stakeholdersJSON(Request $req)
	{
		return response()->json($this->schools->getStakeholdersProject(Auth::user()->id, $req));
	}

	public function publishControl(Request $req) {
		return $this->schools->publishControl($req);
	}

	public function delete(Request $req) 
	{
		$this->projects->delete($req);
	}

	public function logout() 
	{
		Auth::guard('schools')->logout();
		return redirect('/home');
	}

}
