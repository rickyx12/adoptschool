<?php
namespace App\Library\Services;
  
use App\Library\Services\Contracts\SchoolTypeInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SchoolType implements SchoolTypeInterface {

    public function getSchoolType() {

        return DB::select('SELECT * FROM school_type WHERE is_deleted = ? ORDER BY id DESC',[0]);
    }

}