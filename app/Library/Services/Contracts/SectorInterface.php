<?php

namespace App\Library\Services\Contracts;
  
Interface SectorInterface {
    
    public function getSector();

    public function getSubSector($sectorId);
}