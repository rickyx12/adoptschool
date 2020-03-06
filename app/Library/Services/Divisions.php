<?php
namespace App\Library\Services;
  
use App\Library\Services\Contracts\DivisionsInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class Divisions implements DivisionsInterface {

    public function getDivisions($regionId) {

        return DB::select('SELECT * FROM school_division WHERE region = ? AND is_deleted = ?',[$regionId, 0]);
    }

}