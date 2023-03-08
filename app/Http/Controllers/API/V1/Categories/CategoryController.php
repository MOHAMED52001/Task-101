<?php

namespace App\Http\Controllers\API\V1\Categories;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\API\V1\Traits\APIResponse;

class CategoryController extends Controller
{
    use APIResponse;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return $categories->count() > 0 ?
            $this->apiResponse(200, "success", null, $categories) :
            $this->apiResponse(200, "success", "There Is No Records In Database", "There Is No Records In Database");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:255', 'string'],
        ]);

        $department = Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name . '-' . time()),
        ]);
        return  $this->apiResponse(201, "success", null, $department);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Category $category)
    {
        return  $this->apiResponse(200, "success", null, $category);
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => [
                'string',
                'max:255',
            ]
        ]);

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name . '-' . time()),
        ]);

        return  $this->apiResponse(202, "success", null, $category);
    }

    public function destroy(Request $request, Category $category)
    {
        $category->delete();
        return  $this->apiResponse(202, "Deleted Successfully");
    }
}
