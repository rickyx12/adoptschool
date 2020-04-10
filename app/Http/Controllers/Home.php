<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\UrlGenerator;
use App\Library\Services\Contracts\CategoryInterface;
use App\Library\Services\Contracts\ProjectsInterface;
use App\Library\Services\Contracts\SchoolYearInterface;

class Home extends Controller
{
    
	private $category;
	private $projects;
	private $schoolYear;

	public function __construct(
		CategoryInterface $category, 
		ProjectsInterface $projects,
		SchoolYearInterface $schoolYear
	) {
	
		$this->category = $category;
		$this->projects = $projects;
		$this->schoolYear = $schoolYear;
	}

	public function index() 
	{

		$data = array(
			'categories' => $this->category->getCategory()
		);

		return view('home.index', $data);
	}

	public function projects(Request $req) 
	{

		$data = array(
			'categories' => $this->category->getCategory(),
			'projects' => $this->projects->showAvailableProjectsGuest($this->schoolYear->getSchoolYear()[0]->id, $req)
		);

		return view('users.projects', $data);
	}

	public function projectsJSON(Request $req) 
	{

		return response()->json($this->projects->showAvailableProjectsGuest($this->schoolYear->getSchoolYear()[0]->id, $req));
	}

	public function showFilteredProjects(Request $req) 
	{
		return response()->json($this->projects->showFilteredProjectsGuest($this->schoolYear->getSchoolYear()[0]->id, $req));
	}		

	public function getProject($projectId) 
	{

		$project = $this->projects->getSingleProject($projectId);

		$data = array(
			'project' => $project
		);

		if($project) {
			return view('home.project', $data);
		}else {
			abort(404);
		}
	}

	public function getTotalApprovedQty($projectId) 
	{
		$data = $this->projects->getTotalApprovedQty($projectId);
		return response()->json($data);
	}

}
