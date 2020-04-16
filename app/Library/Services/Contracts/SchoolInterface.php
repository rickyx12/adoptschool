<?php

namespace App\Library\Services\Contracts;
  
use Illuminate\Http\Request;

Interface SchoolInterface
{

    public function register(Request $req);

    public function update(Request $req);

    public function type();

    public function getStakeholdersProject($schoolId, Request $req);

    public function getProfile($schoolId);
}