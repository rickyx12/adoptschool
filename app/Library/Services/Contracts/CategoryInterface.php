<?php

namespace App\Library\Services\Contracts;
  
Interface CategoryInterface
{

	public function getCategory();

	public function getSubCategory($categoryId);

	public function getSubCategoryById($subCategoryId);
}