<?php

namespace App\Library\Services\Contracts;

use Illuminate\Http\Request;
  
Interface AdminInterface
{

	public function register(Request $req);
}