<?php

namespace App\Http\Interfaces;

use App\Http\Requests\CategoryRequest;

interface CategoryInterface {

    public function getCategories();
    public function createCategory(CategoryRequest $request);
    public function deleteCategory($category_id);
}
