<?php

namespace App\Library\Services\Contracts;
  
use Illuminate\Http\Request;

Interface ProjectsInterface
{

    public function add($schoolId, $categoryId, Request $req);

    public function getProjects($schoolId);

    public function showAvailableProjects($schoolYearId);

    public function showFilteredProjects($schoolYearId, Request $req);
}