<?php

namespace App\Http\Controllers;

use App\product_browsures;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Posts;
use File;

class ManageBrowsureController extends Controller
{
    private $productBrowsurePath = 'files/browsure';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tab="manageBrowsure";
        $postByProduct = DB::table('posts')->select('posts.*', 'categories.title as catTitle', 'sub_categories.title as subCatTitle')
          ->where([['product', '=', 1], ['product_used', '=', 0]])
          ->leftjoin('categories', 'posts.category_id', '=', 'categories.id')
          ->leftjoin('sub_categories', 'posts.subcategory_id', '=', 'sub_categories.id')
          ->orderBy('categories.id', 'DESC')
          ->orderBy('sub_categories.id', 'DESC')
          ->get();
        $listOfProductBrowsures = DB::table('product_browsures')->select('*')->get();


        return view('admin.admin-components.manageBrowsure', compact('tab', 'postByProduct', 'listOfProductBrowsures'));
    }

    public function getPDFBrowsure($id) {
        $browsureArray = DB::table('product_browsures')->select('tmp_file')
                    ->where('id', $id)->get()->toArray();
        $tmp_path = array_shift($browsureArray)->tmp_file;

        $file = public_path().'/'.$tmp_path;
        $header = [
            'Content-Type' => 'application/pdf',
        ];

        return response()->make(file_get_contents($file), 200, [
            'Content-Type' => 'application/pdf',
            'Content-disposition' => 'inline; filename="'.$file.'"',
        ]);
    }

    public function getAjaxEditProductList($id)
    {
      /* reference query
      select posts.*, categories.title as catTitle, sub_categories.title as subCatTitle
      from posts
      left join categories on categories.id = posts.category_id
      left join sub_categories on sub_categories.id = posts.subcategory_id
      where posts.product = 1 and posts.product_used = 0 or posts.id = 1
      order by categories.id desc, sub_categories.id desc
      */
      $postByProduct = DB::table('posts')->select('posts.*', 'categories.title as catTitle', 'sub_categories.title as subCatTitle')
        ->where([['product', '=', 1], ['product_used', '=', 0]])->orWhere('posts.id', $id)
        ->leftjoin('categories', 'posts.category_id', '=', 'categories.id')
        ->leftjoin('sub_categories', 'posts.subcategory_id', '=', 'sub_categories.id')
        ->leftjoin('product_browsures', 'posts.id', '=', 'product_browsures.product_id')
        ->orderBy('categories.id', 'DESC')
        ->orderBy('sub_categories.id', 'DESC')
        ->get();

        return response()->json(['listOfProductEditId' => $postByProduct]);
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
        $post_id = $request->get('post_id');
        $product_name = $request->get('product_name');

        if($request->hasFile('file_name')) {
            $file = $request->file('file_name');
            $fileName = $file->getClientOriginalName();
            $TmpFileName = time().'_'.$fileName;
            $productBrowsurePath = $this->productBrowsurePath;
            $tmpFilePath = $productBrowsurePath.'/'.$TmpFileName;

            $file->move(public_path($productBrowsurePath), $TmpFileName);

            DB::insert('insert into product_browsures(product_id, product_name, file_name, tmp_file, created_at) values(?, ?, ?, ?, ?)', [$post_id, $product_name, $fileName, $tmpFilePath, now()]);
            DB::table('posts')->where('id', $post_id)->update(['product_used' => 1]);
        }

        return redirect()->route('manageBrowsure.index')->with(['message' => 'You Has Been Succesfull Uploaded product browsure!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\manageBrowsure  $manageBrowsure
     * @return \Illuminate\Http\Response
     */
    public function show(manageBrowsure $manageBrowsure)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\manageBrowsure  $manageBrowsure
     * @return \Illuminate\Http\Response
     */
    public function edit(manageBrowsure $manageBrowsure)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\manageBrowsure  $manageBrowsure
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $idBrowsure = $request->get('hiddenId');
        $postIdBySubCategoryEdit = $request->get('post_id');
        $productName = $request->get('product_name');
        $browsureEdited = $request->get('toggleEditBrowsure');
        $browsureDefault = product_browsures::find($idBrowsure);
        $oldPostIdStillUsed = true;
        $oldPostId = $browsureDefault->product_id;;
        // dd($browsureEdited);
        if($browsureEdited == 1) {
            if($request->hasFile('file_name')) {
                $file = $request->file('file_name');
                $fileName = $file->getClientOriginalName();
                $tmpFileName = time().'_'.$fileName;
                $productBrowsurePath = $this->productBrowsurePath;
                $tmpFilePath = $productBrowsurePath.'/'.$tmpFileName;

                $file->move(public_path($productBrowsurePath), $tmpFileName);
                $oldFile = $browsureDefault->tmp_file;
                if(File::exists($oldFile)) {
                    File::delete($oldFile);
                }

                if($browsureDefault->product_id != $postIdBySubCategoryEdit) {
                    $oldPostIdStillUsed = false;
                }
                $browsureDefault->product_id = $postIdBySubCategoryEdit;
                $browsureDefault->product_name = $productName;
                $browsureDefault->file_name = $fileName;
                $browsureDefault->tmp_file = $tmpFilePath;
                $browsureDefault->updated_at = now();
            }
        } else {
            if($browsureDefault->product_id != $postIdBySubCategoryEdit) {
                $oldPostIdStillUsed = false;
            }
            $browsureDefault->product_id = $postIdBySubCategoryEdit;
            $browsureDefault->product_name = $productName;
            $browsureDefault->updated_at = now();
        }
        $browsureDefault->save();
        if($oldPostIdStillUsed == false) {
            $newPostId = $postIdBySubCategoryEdit;
            DB::table('posts')->where('id', $oldPostId)->update(['product_used' => 0]);
            DB::table('posts')->where('id', $newPostId)->update(['product_used' => 1]);
        }
        return redirect()->route('manageBrowsure.index')->with(['message' => 'You Has Been Succesfull Updated Your Browsure!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\manageBrowsure  $manageBrowsure
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
    }

    public function deleteBrowsure(Request $request) {
        $id = $request->get('browsureHiddenId');
        // dd($id);
        $browsureToBeDeleted = product_browsures::find($id);
        $filePath = $browsureToBeDeleted->tmp_file;
        if(File::exists($filePath)) {
            File::delete($filePath);
        }
        $postId = $browsureToBeDeleted->product_id;
        DB::table('posts')->where('id', $postId)->update(['product_used' => 0]);
        $browsureToBeDeleted->delete();
        return redirect()->route('manageBrowsure.index')->with(['message' => 'You Has Been Succesfull Deleted Your Browsure!']);
    }
}
