<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Library\Services\Contracts\CommentInterface;

class Comments extends Controller
{
    
	private $comments;

	public function __construct(CommentInterface $comments) {
		$this->comments = $comments;
	}

	public function getComments($projectId) {
		return response()->json($this->comments->getComments($projectId));
	}

	public function getAllComments($projectId) {
		return response()->json($this->comments->getAllComments($projectId));
	}
}
