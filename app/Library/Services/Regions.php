<?php
namespace App\Library\Services;
  
use App\Library\Services\Contracts\RegionsInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class Regions implements RegionsInterface {

    public function getRegion() {

        return DB::select('SELECT * FROM region WHERE is_deleted = ?',[0]);
    }

}