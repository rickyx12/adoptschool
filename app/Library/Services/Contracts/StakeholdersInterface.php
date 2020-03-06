<?php

namespace App\Library\Services\Contracts;
  
use Illuminate\Http\Request;

Interface StakeholdersInterface
{

    public function register(Request $req);
}