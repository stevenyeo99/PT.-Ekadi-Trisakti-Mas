<?php

namespace App\Http\Controllers;

use App\Posts;
use App\Categories;
use App\SubCategories;
use App\product_browsures;
use App\photos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = $this->getPostData('all', 0);
        $tab = "posts";
        $categories = Categories::all();
        return view('admin.admin-components.viewAllPosts', compact('tab', 'posts', 'categories'));
    }

    public function filterResultPost(Request $request) {
        $categoryData = $request->get('ddlCategoryFilter');
        $subCategoryData = $request->get('ddlSubCategoryFilter');
        $subCategories = SubCategories::all()->where('category_id', $categoryData);
        $sizeSubCategory = count($subCategories);
        // dd($sizeSubCategory);
        $posts = [];
        $byResult = [];
        if(isset($categoryData)) {
            if($categoryData != "0") {
                if($subCategoryData != null && $subCategoryData != "0") {
                    $posts = $this->getPostData('bySubCategoryId', $subCategoryData);
                    $byResult = [
                                   'postResultFilter' => $posts,
                                   'category_id' => $categoryData,
                                   'subCategoryId' => $subCategoryData,
                                   'listOfSubCategories' => $subCategories,
                                   'sizeSub' => $sizeSubCategory
                                ];
                } else {
                    $posts = $this->getPostData('byCategoryId', $categoryData);
                    $byResult = [
                                    'postResultFilter' => $posts,
                                    'category_id' => $categoryData,
                                    'subCategoryId' => 0,
                                    'listOfSubCategories' => $subCategories,
                                    'sizeSub' => $sizeSubCategory
                                  ];
                }
            } else {
                $posts = $this->getPostData('all', 0);
                $byResult =   [
                                'postResultFilter' => $posts,
                                'category_id' => 0,
                                'subCategoryId' => 0,
                                'listOfSubCategories' => $subCategories,
                                'sizeSub' => $sizeSubCategory
                              ];
            }
        } else {
            $posts = $this->getPostData('all', 0);
            $byResult =   [
                            'postResultFilter' => $posts,
                            'category_id' => 0,
                            'subCategoryId' => 0,
                            'listOfSubCategories' => $subCategories,
                            'sizeSub' => $sizeSubCategory
                          ];
        }
        return redirect()->route('posts.index')->with($byResult);
    }


    /** query method **/
    private function getPostData($type, $id) {
        $posts = [];
        switch($type) {
          case "byCategoryId":
            $posts = DB::table('posts')->select('posts.*', 'categories.title as catTitle', 'sub_categories.title as subCatTitle')
              ->leftjoin('categories', 'posts.category_id', '=', 'categories.id')
              ->leftjoin('sub_categories', 'posts.subcategory_id', '=', 'sub_categories.id')
              ->where('posts.category_id', $id)
              ->orderBy('categories.id', 'DESC')
              ->orderBy('sub_categories.id', 'DESC')->get();
            break;
          case "bySubCategoryId":
            $posts = DB::table('posts')->select('posts.*', 'categories.title as catTitle', 'sub_categories.title as subCatTitle')
              ->leftjoin('categories', 'posts.category_id', '=', 'categories.id')
              ->leftjoin('sub_categories', 'posts.subcategory_id', '=', 'sub_categories.id')
              ->where('subcategory_id', $id)
              ->orderBy('categories.id', 'DESC')
              ->orderBy('sub_categories.id', 'DESC')->get();
            break;
            default:
            $posts = DB::table('posts')->select('posts.*', 'categories.title as catTitle', 'sub_categories.title as subCatTitle')
                ->leftjoin('categories', 'posts.category_id', '=', 'categories.id')
                ->leftjoin('sub_categories', 'posts.subcategory_id', '=', 'sub_categories.id')
                ->orderBy('categories.id', 'DESC')
                ->orderBy('sub_categories.id', 'DESC')->get();
              break;
        }
      return $posts;
    }

    public function showPost($id)
    {
        $tab = "";
        $posts = Posts::find($id);
        return view('admin.admin-components.viewEachPost', compact('tab', 'posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tab = "posts";
        $categories = Categories::all();
        return view('admin.admin-components.addPost', compact('tab', 'categories'));
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
          'post_title' => 'required|max:20|min:3',
          'category_id' => 'required|exists:categories,id',
          'product' => 'required',
          'body' => 'required',
        ]);
        $post_title = $request->get('post_title');
        // $tags = $request->get('tags');
        $category_id = $request->get('category_id');
        $subcategory_id = $request->get('subcategory_id');
        $product = $request->get('product');
        $body = $request->get('body');

        $count = 0;
        if($subcategory_id != null) {
            $count = Posts::where([['post_title', '=', $post_title], ['category_id', '=', $category_id], ['subcategory_id', '=', $subcategory_id],]);
        } else {
            $count = Posts::where([['post_title', '=', $post_title], ['category_id', '=', $category_id],]);
        }

        if($count->count() == 0) {
            DB::insert('insert into posts(category_id, subcategory_id, post_title, product, product_used, body, created_at) values(?, ?, ?, ?, ?, ?, ?)', [$category_id, $subcategory_id, $post_title, $product, 0, $body, now()]);
            return redirect()->route('posts.index')->with(['message' => 'You Have Successfull Add New Post!']);
        } else {
            return redirect()->route('posts.index')->with(['messageFail' => 'This Post With Category Or Sub Category Type Already Exist!']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Posts  $posts
     * @return \Illuminate\Http\Response
     */
    public function show(Posts $posts)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Posts  $posts
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tab = 'posts';
        $posts = Posts::find($id);
        $categories = Categories::all();
        $subCategories = DB::table('sub_categories')->where('category_id', '=', $posts->category_id)->get();
        return view('admin.admin-components.editPost', compact('tab', 'posts', 'categories', 'subCategories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Posts  $posts
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'id' => 'required',
            'post_title' => 'required|max:20|min:3',
            'category_id' => 'required|exists:categories,id',
            'product' => 'required',
            'body' => 'required',
        ]);

        $post = Posts::where([
            ['id', '!=', $request->get('id')],
            ['post_title', '=', $request->get('post_title')],
        ]);

        if($post->count() == 0) {
            $post = Posts::find($id);
            $post->post_title = $request->get('post_title');
            // $post->tags = $request->get('tags');
            $post->category_id = $request->get('category_id');
            $post->subcategory_id = $request->get('subcategory_id');
            $post->product = $request->get('product');
            $post->body = $request->get('body');
            $post->save();
            return redirect()->route('posts.index')->with(['message' => 'You Have Succesfull Update This Post!']);
        } else {
            return back()->with(['messageFail' => 'Post Title Already Exist On Another Post!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Posts  $posts
     * @return \Illuminate\Http\Response
     */
    public function destroy(Posts $posts)
    {
        //
    }

    public function getSubCategoryIdByCategoryId($id)
    {
        $subCategory = DB::table('sub_categories')->where('category_id', '=', $id)->get();
        return response()->json([
          'error' => false,
          'subCategory' => $subCategory,
        ], 200);
    }

    public function deletePosts(Request $request)
    {
        $request->validate([
            'ids' => 'required',
        ]);

        $ids = $request->get('ids');
        $listOfIds = explode(',',$ids);
        // dd($listOfIds);
        $postThatNotDeleted = 0;
        $postThatDeleted = 0;
        foreach($listOfIds as $id)
        {
            $browsure = product_browsures::all()->where('product_id', $id)->count();
            $photo = photos::all()->where('post_id', $id)->count();
            // dd($photo);
            $detectB = 0;
            $detectP = 0;
            if($browsure > 0) {
              $detectB = 1;
            }

            if($photo > 0) {
              $detectP = 1;
            }

            if($detectB == 1 || $detectP == 1) {
                $postThatNotDeleted += 1;
            }

            if($detectB == 0 && $detectP == 0) {
                $postById = Posts::find($id);
                $postById->delete();
                $postThatDeleted += 1;
            }
        }

        if($postThatNotDeleted > 0 && $postThatDeleted == 0) {
            return redirect()->route('posts.index')->with(['messageFail' => 'theres '.$postThatNotDeleted.' post that are being still used!']);
        } else if($postThatNotDeleted > 0 && $postThatDeleted > 0) {
            return redirect()->route('posts.index')->with(['messageFail' => 'only '.$postThatDeleted.' are being deleted, '.$postThatNotDeleted.'are still being used!']);
        }
        else {
            return redirect()->route('posts.index')->with(['message' => 'You Have Succesfully Delete Your Post!']);
        }

    }
}
