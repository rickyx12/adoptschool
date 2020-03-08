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

	public function index() {

		$data = array(
			'categories' => $this->category->getCategory()
		);

		return view('home.index', $data);
	}

	public function projects() {

		$data = array(
			'categories' => $this->category->getCategory(),
			'projects' => $this->projects->showAvailableProjectsGuest($this->schoolYear->getSchoolYear()[0]->id)
		);

		return view('users.projects', $data);
	}

	public function showFilteredProjects(Request $req) {

		$data = array(
			'categories' => $this->category->getCategory(),
			'projects' => $this->projects->showFilteredProjectsGuest($this->schoolYear->getSchoolYear()[0]->id, $req)
		);

		return view('account.stakeholders.projects.index', $data);
	}		

}
