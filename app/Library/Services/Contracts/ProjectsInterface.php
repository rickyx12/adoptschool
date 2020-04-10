<?php

namespace App\Library\Services\Contracts;
  
use Illuminate\Http\Request;

Interface ProjectsInterface
{

    public function add($schoolId, $categoryId, Request $req);

    public function getProjects($schoolId, Request $req);

    public function getProjectsByImplementationDate($schoolId, Request $req); 

    public function showAvailableProjects($schoolYearId, $stakeholderId, Request $req);

    public function showFilteredProjects($schoolYearId, Request $req);

	public function showAvailableProjectsGuest($schoolYearId, Request $req);

	public function showFilteredProjectsGuest($schoolYearId, Request $req);

    public function addStakeholder(Request $req);

    public function isStakeholder($stakeholderId, $projectId); 

    public function getProjectStakeholders($projectId);

    public function getPendingRequestProject();

    public function getSingleProject($projectId);

    public function delete(Request $req);

    public function getTotalApprovedQty($projectId);
}