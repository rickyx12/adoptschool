<?php
namespace App\Library\Services;
  
use App\Library\Services\Contracts\SchoolYearInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SchoolYear implements SchoolYearInterface {

    public function getSchoolYear() {

        return DB::select('SELECT * FROM school_year WHERE is_deleted = ? ORDER BY id DESC',[0]);
    }

}