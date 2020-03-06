<?php
namespace App\Library\Services;
  
use App\Library\Services\Contracts\CategoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class Category implements CategoryInterface
{

    public function getCategory() {
      
      return DB::select('SELECT * FROM category WHERE is_deleted = ?',[0]);
    }

    public function getSubCategory($categoryId) {	
    	
    	return DB::select('SELECT * FROM sub_category WHERE is_deleted = ? AND category = ?',[0, $categoryId]);
    }

    public function getSubCategoryById($subCategoryId) {	
    	
    	return DB::select('SELECT * FROM sub_category WHERE is_deleted = ? AND id = ?',[0, $subCategoryId]);
    }    
}