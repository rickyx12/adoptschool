<?php

namespace App\Library\Services\Contracts;
  
use Illuminate\Http\Request;

Interface ProjectsInterface
{

    public function add($schoolId, $categoryId, Request $req);

    public function getProjects($schoolId);

    public function showFilteredSchoolProjects($schoolId, Request $req); 

    public function showAvailableProjects($schoolYearId);

    public function showFilteredProjects($schoolYearId, Request $req);

	public function showAvailableProjectsGuest($schoolYearId);

	public function showFilteredProjectsGuest($schoolYearId, Request $req);

    public function addStakeholder(Request $req);

    public function getPendingRequestProject();
}