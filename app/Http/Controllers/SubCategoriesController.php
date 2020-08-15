<?php

namespace App\Http\Controllers;

use App\SubCategories;
use App\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Posts;

class SubCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subCategories = DB::table('sub_categories')
                        ->select('sub_categories.*', 'categories.title as catTitle')
                        ->leftjoin('categories', 'sub_categories.category_id', '=', 'categories.id')
                        ->orderBy('categories.id', 'ASC')->get();

        $categories = Categories::all()->where('type', 'LISTING SUB');
        $tab = "subcategory";
        return view('admin.admin-components.subcategory', compact('tab', 'categories', 'subCategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|unique:sub_categories|max:20|min:3',
        ]);

        // SubCategories::create($request->all());
        DB::insert('insert into sub_categories(category_id, title, created_at) values(?, ?, ?)', [$request->get('category_id'), $request->get('title'), now()]);
        $category = Categories::find($request->get('category_id'));
        $categoryTitle = $category->title;
        $subCategoryTitle = $request->get('title');
        return redirect()->route('subcategory.index')->with(['message' => $subCategoryTitle.' Has Been Succesfull Added To Category '.$categoryTitle]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SubCategories  $subCategories
     * @return \Illuminate\Http\Response
     */
    public function show(SubCategories $subCategories)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SubCategories  $subCategories
     * @return \Illuminate\Http\Response
     */
    public function edit(SubCategories $subCategories)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SubCategories  $subCategories
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SubCategories $subCategories)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SubCategories  $subCategories
     * @return \Illuminate\Http\Response
     */
    public function destroy(SubCategories $subCategories)
    {
        //
    }

    public function updateSubCategory(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'category_id' => 'required',
            'title' => 'required|min:3|max:20',
        ]);

        $subCategory = SubCategories::where([
            ['id', '!=', $request->get('id')],
            ['category_id', '!=', $request->get('category_id')],
            ['title', '=', $request->get('title')],
        ]);

        if($subCategory->count() == 0) {
            $subCategoriesById = SubCategories::find($request->get('id'));
            $subCategoryTitle = $subCategoriesById->title;
            $categoryId = $subCategoriesById->category_id;
            $categoryType = Categories::find($categoryId)->title;
            $newCategoryType = Categories::find($request->get('category_id'))->title;
            $subCategoriesById->category_id = $request->get('category_id');
            $subCategoriesById->title = $request->get('title');
            $subCategoriesById->save();
            $message = "SubCategory Title Has Been Updated With No Changes!";
            if($subCategoryTitle != $request->get('title') && $categoryId != $request->get('category_id')) {
                $message = "Title ".$subCategoryTitle." has been updated into ".$request->get('title')." and type ".$categoryType." change into ".$newCategoryType;
            } else if($subCategoryTitle != $request->get('title') && $categoryId == $request->get('category_id')) {
                $message = "Title ".$subCategoryTitle." has been updated into ".$request->get('title');
            } else if($subCategoryTitle == $request->get('title') && $categoryId != $request->get('category_id')) {
                $message = "Category Type Has Been Updated Into ".$newCategoryType;
            }
            return redirect()->route('subcategory.index')->with(['message' => $message]);
        } else {
            return redirect()->route('subcategory.index')->with(['message' => 'SubCategory Failed To Change']);
        }
    }

    public function deleteSubCategory(Request $request)
    {
        $totalPostUsed = Posts::where('subcategory_id', '=', $request->get('id'))->count();
        if($totalPostUsed == 0) {
            $checkCategoryExist = SubCategories::find($request->get('id'));
            $subcategoryTitle = $checkCategoryExist->title;

            if($checkCategoryExist->count() != 0) {
              $checkCategoryExist->delete();
              return redirect()->route('subcategory.index')->with(['message' => 'Sub-Category '.$subcategoryTitle.' has been Successfully Deleted!']);
            } else {
              return redirect()->route('subcategory.index')->with(['messageFail' => 'Category Failed To Delete!']);
            }
        } else {
            return redirect()->back()->with(['messageFail' => 'This Sub-Category Is Being Used By Post!']);
        }
    }
}
