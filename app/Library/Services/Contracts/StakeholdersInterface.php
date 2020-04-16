<?php

namespace App\Library\Services\Contracts;
  
use Illuminate\Http\Request;

Interface StakeholdersInterface
{

    public function register(Request $req);

    public function getProjectContributions($stakeholderId, Request $req);

    public function cancelContribution(Request $req);

    public function getInformation($stakeholderId);

    public function update(Request $req);
}