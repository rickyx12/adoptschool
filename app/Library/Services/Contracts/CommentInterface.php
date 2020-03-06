<?php

namespace App\Library\Services\Contracts;
  
use Illuminate\Http\Request;
  
Interface CommentInterface
{

	public function add(Request $req);

	public function getComments($projectId);
}