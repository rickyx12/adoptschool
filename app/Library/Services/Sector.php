<?php
namespace App\Library\Services;
  
use App\Library\Services\Contracts\SectorInterface;
use Illuminate\Support\Facades\DB;

class Sector implements SectorInterface {

    public function getSector() {
      
      return DB::select('SELECT * FROM sector WHERE is_deleted = ?',[0]);
    }

    public function getSubSector($sectorId) {	
    	
    	return DB::select('SELECT * FROM sub_sector WHERE is_deleted = ? AND sector = ?',[0, $sectorId]);
    }

}