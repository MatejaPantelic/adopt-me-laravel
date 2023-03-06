<?php

namespace App\Http\Repositories;
use App\Http\Interfaces\CategoryInterface;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;

class CategoryRepository implements CategoryInterface {

    protected $categoryModel;

    public function __construct(Category $category)
    {
        $this->categoryModel = $category;
    }

    public function getCategories()
    {
        return Category::select('id','name','description')->get();
    }
    public function createCategory(CategoryRequest $request)
    {
        $category=new Category();
        $category->name=$request->name;
        $category->description=$request->description;
        $category->save();
    }
    public function deleteCategory($category_id)
    {
        return Category::where('id','=',$category_id)->delete();
    }

}
