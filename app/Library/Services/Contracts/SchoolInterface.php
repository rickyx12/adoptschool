<?php

namespace App\Library\Services\Contracts;
  
use Illuminate\Http\Request;

Interface SchoolInterface
{

    public function register(Request $req);

    public function type();
}