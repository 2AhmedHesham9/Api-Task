<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCategoryrRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Traits\GeneralTrait;
class CatigoriesController extends Controller
{
    use GeneralTrait;
    public function index() {
        $categoris = Category::get();
        if(!$categoris)
         return $this->returnError(404,"No Data");

         return $this->returnData('categoris',$categoris,"This is your data.");
        // return response()->json($categoris);
    }

    public function store(StoreCategoryrRequest $request) {

        Category::create(['category' => $request->category]);


    }
    public function delete(Category $id) {

        $id->delete();

    }

    public function update(Request $request) {

        $category=Category::where('id',$request->id)->first();
        if(!$category)
           return $this->returnError(404,"id not found");

        $category->update(
            [
                'category'=>$request->category,
            ]
        );

        return response()->json($category);

    }
}
