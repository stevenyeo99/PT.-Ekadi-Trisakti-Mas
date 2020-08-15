<?php

namespace App\Http\Controllers;

use App\Categories;
use App\SubCategories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Categories::all();
        $length = count($categories);
        $about = 0; $home = 0; $listing = 0; $sublisting = 0; $maintanance = 0;
        foreach($categories as $category) {
            if($category->type === 'FIRST PAGE') {
              $home = 1;
            }
            if($category->type === 'ABOUT US') {
              $about = 1;
            }
            if($category->type === 'LISTING') {
              $listing = 1;
            }
            if($category->type === 'LISTING SUB') {
              $sublisting = 1;
            }
            if($category->type === 'MAINTANANCE') {
              $maintanance = 1;
            }
         }
        $tab = "category";
        return view('admin.admin-components.category', compact('categories', 'length', 'tab', 'home', 'about', 'listing', 'sublisting', 'maintanance'));
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
            'title' => 'required|unique:categories|max:20|min:3',
            'type' => 'required',
        ]);

        DB::insert('insert into categories(title, type, created_at) values(?, ?, ?)', [$request->get('title'), $request->get('type'), now()]);
        return redirect()->route('category.index')->with(['message' => 'Category '.$request->get('title').' Succesfull Added!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function show(Categories $categories)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function edit(Categories $categories)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function destroy(Categories $categories)
    {
        //
    }

    public function updateTitle(Request $request) {
        $request->validate([
            'id' => 'required',
            'title' => 'required|max:20|min:3',
        ]);
        $category = Categories::where([
          ['id', '!=', $request->get('id')],
          ['title', '=', $request->get('title')],
          // ['type', '=', $request->get('type')],
        ]);

        if($category->count() == 0) {
            $categoryToBeUpdate = Categories::find($request->get('id'));
            $categoryTitleBeforeUpdated = $categoryToBeUpdate->title;
            $categoryToBeUpdate->title = $request->get('title');
            $categoryToBeUpdate->save();
            return redirect()->route('category.index')->with(['message' => 'Category '.$categoryTitleBeforeUpdated.' has been change into '.$categoryToBeUpdate->title.' Succesfully!']);
        } else {
            return redirect()->route('category.index')->with(['messageFail' => 'Category Failed To Change']);
        }
    }

    public function deleteTitle(Request $request) {
        $checkCategoryExist = Categories::find($request->get('id'));
        $subCategoryUsed = SubCategories::where('category_id', '=', $request->get('id'))->count();
        $categoryTitle = $checkCategoryExist->title;

        if($subCategoryUsed > 0) {
            return redirect()->route('category.index')->with(['messageFail' => 'This Category Has Been Used By Sub Category!']);
        }
        else if($checkCategoryExist->count() != 0) {
            $checkCategoryExist->delete();
            return redirect()->route('category.index')->with(['message' => 'Category '.$categoryTitle.' has been Successfully Deleted!']);
        }  else {
            return redirect()->route('category.index')->with(['messageFail' => 'Category Failed To Delete!']);
        }
    }
}
