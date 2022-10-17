<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    function list() {
        $categories = Category::when(request('keys'), function ($query) {
            $query->where('name', 'like', '%' . request('keys') . '%')->paginate(4);
        })
            ->orderBy('id', 'desc')->paginate(4);

        $categories->appends(request()->all());
        return view('admin.category.list', compact('categories'));
    }

    // go category page
    public function add()
    {
        return view('admin.category.create_category');
    }

    // create categoy
    public function create(Request $request)
    {
        $validator = $this->categoryValidCheck($request);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        };

        $data = $this->categoryData($request);
        Category::create($data);
        return redirect()->route('category#list')->with(['message' => 'Category Insert Success! ']);
    }

    // delete category
    public function delete($id)
    {
        Category::where('id', $id)->delete();
        return back()->with(['message' => 'Category  Delete Success!']);
    }

    // edit category
    public function edit($id)
    {

        $categories = Category::where('id', $id)->first();
        return view('admin.category.edit_category', compact('categories'));
    }

    //update category
    public function update(Request $request)
    {
        $validator = $this->categoryValidCheck($request);
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        };

        $data = [
            'name' => $request->categoryName,
            'updated_at' => Carbon::now(),
        ];

        Category::where('id', $request->categoryID)->update($data);
        return redirect()->route('category#list')->with(['message' => 'Update Data Success.....']);
    }
    //validator
    private function categoryValidCheck($request)
    {
        return Validator::make($request->all(), [
            'categoryName' => 'required|min:4|unique:categories,name,' . $request->categoryID,
        ], [
            'categoryName.required' => 'Opp! category field is empty',
        ]);
    }

    // data for insert
    private function categoryData($request)
    {
        return [
            'name' => $request->categoryName,
        ];
    }
}
