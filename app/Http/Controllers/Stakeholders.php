<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Library\Services\Contracts\StakeholdersInterface;
use App\Library\Services\Contracts\ProjectsInterface;
use App\Library\Services\Contracts\SchoolYearInterface;
use App\Library\Services\Contracts\CategoryInterface;
use App\Library\Services\Contracts\CommentInterface;

class Stakeholders extends Controller
{

	private $stakeholders;
	private $projects;
	private $schoolYear;
	private $category;
	private $comment;

	public function __construct(
		StakeholdersInterface $stakeholders,
		ProjectsInterface $projects, 
		SchoolYearInterface $schoolYear,
		CategoryInterface $category,
		CommentInterface $comment
	) {

		$this->stakeholders = $stakeholders;
		$this->projects = $projects;
		$this->schoolYear = $schoolYear;
		$this->category = $category;
		$this->comment = $comment;

		$this->middleware('auth:stakeholders');
	}
    
	public function index() 
	{
		return view('account.stakeholders.dashboard.index');
	}

	public function projects() 
	{

		$data = array(
			'categories' => $this->category->getCategory(),
			'projects' => $this->projects->showAvailableProjects($this->schoolYear->getSchoolYear()[0]->id)
		);

		return view('account.stakeholders.projects.index', $data);
	}

	public function showFilteredProjects(Request $req) 
	{

		$data = array(
			'categories' => $this->category->getCategory(),
			'projects' => $this->projects->showFilteredProjects($this->schoolYear->getSchoolYear()[0]->id, $req)
		);

		return view('account.stakeholders.projects.index', $data);
	}

	public function addComment(Request $req) 
	{
		$this->comment->add($req);
	}

	public function getComments($projectId) 
	{
		return response()->json($this->comment->getComments($projectId));
	}

	public function addStakeholder(Request $req) 
	{
		$this->projects->addStakeholder($req);
	}

	public function getProjectContributions() 
	{

		$data = array(
			'categories' => $this->category->getCategory(),
			'projects' => $this->stakeholders->getProjectContributions(Auth::user()->id)
		);

		return view('account.stakeholders.contributions.index', $data);
	}

	public function logout() {
		Auth::guard('stakeholders')->logout();
		return redirect('/home');
	}

}
