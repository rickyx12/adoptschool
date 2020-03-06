<?php

namespace App\Library\Services\Contracts;
  
use Illuminate\Http\Request;
  
Interface UpdatesInterface
{

	public function addProjectUpdate(Request $req);

	public function getProjectUpdates($projectId);
}