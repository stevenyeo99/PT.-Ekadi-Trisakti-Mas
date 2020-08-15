<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categories;
use App\SubCategories;
use App\Posts;
use App\photos;
use Illuminate\Support\Facades\DB;
use File;
use Image;
use Storage;

class imagesController extends Controller
{
    private $originalPath = 'img/product/original';
    private $thumbNailPath = 'img/product/thumbnail';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tab="manageGallery";
        $listing = DB::table('posts')->select('posts.*')
        ->leftjoin('categories', 'posts.category_id', '=', 'categories.id')
        ->whereIn('categories.type', ['LISTING', 'LISTING SUB'])->get();
        // dd($listing);
        return view('admin.admin-components.manageGallery', compact('tab', 'listing'));
    }

    public function onChangeByPostIdFromListingParent($postId, Request $request)
    {
          $tab="manageGallery";
          $valid = "add";
          $listing = DB::table('posts')->select('posts.*')
          ->leftjoin('categories', 'posts.category_id', '=', 'categories.id')
          ->whereIn('categories.type', ['LISTING', 'LISTING SUB'])->get();
          $postId = $request->get('post_id');
          $listImageByPostId = photos::all()->where('post_id', $postId);
          // $productName = DB::table('posts')->select('category_id', 'subcategory_id')->where('id', '=', $postId)->get()
          // ->toArray();
          $productName = Posts::all()->where('id', $postId)->toArray();
          $productAttr = array_shift($productName);

          $categoryId = $productAttr["category_id"];

          $subCategoryId = $productAttr["subcategory_id"];

          $postTitle = $productAttr["post_title"];
          $category = Categories::find($categoryId);
          // dd($category->title);
          $category_title = $category->title;
          $subCategory = SubCategories::find($subCategoryId);
          // dd($subCategory);

          $name = $postTitle . "&nbsp;&nbsp; ";
          if($subCategory != null) {
              $subcategory_title = $subCategory->title;
              $name .= "[".$category_title."(".$subcategory_title.")]";
          } else {
              $name .= "[".$category_title."]";
          }
          return view('admin.admin-components.manageGallery', compact('tab', 'listing', 'postId', 'listImageByPostId', 'name', 'valid'));
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
        // dd("hello");
        $postId = $request->get('type');
        $description = $request->get('description');

        // dd($postId);
        if($request->hasFile('file_name')) {
          $imageTmp = $request->file('file_name');
          $imageName = $request->file('file_name')->getClientOriginalName();
          $imageUploadedName = time().'.'.$imageTmp->getClientOriginalExtension();

          $originalImage = Image::make($imageTmp->getRealPath());
          $publicOrginalPath = public_path($this->originalPath.'/'.$postId);
          if(!File::isDirectory($publicOrginalPath)) {
              File::makeDirectory($publicOrginalPath, 0777, true, true);
          }

          $originalPathFile = $this->originalPath.'/'.$postId.'/'.$imageUploadedName;

          $originalImage->resize(2000, 800)->save($publicOrginalPath.'/'.$imageUploadedName);

          $thumbNailImage = Image::make($imageTmp->getRealPath());
          $publicThumbNailPath = public_path($this->thumbNailPath.'/'.$postId);
          if(!File::isDirectory($publicThumbNailPath)) {
              File::makeDirectory($publicThumbNailPath, 0777, true, true);
          }

          $thumbnailPathFile = $this->thumbNailPath.'/'.$postId.'/'.$imageUploadedName;
          $thumbNailImage->resize(2000, 800)->save($publicThumbNailPath.'/'.$imageUploadedName);

          DB::insert('insert into photos(file_name, original_path, thumbnail_path, alt, post_id, created_at) values(?, ?, ?, ?, ?, ?)', [$imageName, $originalPathFile, $thumbnailPathFile, $description, $postId, now()]);
        }
        return redirect()->back()->with(['message' => 'You Have Succesfull Upload Your Image!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function updateImageGallery(Request $request)
    {
      // dd("hallo");
        $postId = $request->get('post_id_edit');
        $id = $request->get('id');
        $existingPhoto = photos::find($id);
        $description = $request->get('description');
        $changeImage = $request->get('changeImage');

        $oldFilePath = $existingPhoto->original_path;
        $oldThumbNailPath = $existingPhoto->thumbnail_path;

        if(isset($changeImage) && $changeImage == 1) {
            if($request->hasFile('file_name')) {
                $imageTmp = $request->file('file_name');
                $imageName = $request->file('file_name')->getClientOriginalName();
                $imageUploadedName = time().'.'.$imageTmp->getClientOriginalExtension();

                $originalImage = Image::make($imageTmp->getRealPath());
                $publicOrginalPath = public_path($this->originalPath.'/'.$postId);
                if(!File::isDirectory($publicOrginalPath)) {
                    File::makeDirectory($publicOrginalPath, 0777, true, true);
                }

                $originalPathFile = $this->originalPath.'/'.$postId.'/'.$imageUploadedName;

                $originalImage->resize(2000, 800)->save($publicOrginalPath.'/'.$imageUploadedName);

                $thumbNailImage = Image::make($imageTmp->getRealPath());
                $publicThumbNailPath = public_path($this->thumbNailPath.'/'.$postId);
                if(!File::isDirectory($publicThumbNailPath)) {
                    File::makeDirectory($publicThumbNailPath, 0777, true, true);
                }

                $thumbnailPathFile = $this->thumbNailPath.'/'.$postId.'/'.$imageUploadedName;
                $thumbNailImage->resize(2000, 800)->save($publicThumbNailPath.'/'.$imageUploadedName);

                $oldFilePath = public_path($oldFilePath);
                if(File::exists($oldFilePath)) {
                    File::delete($oldFilePath);
                }

                $oldThumbNailPath = public_path($oldThumbNailPath);
                if(File::exists($oldThumbNailPath)) {
                    File::delete($oldThumbNailPath);
                }

                $existingPhoto->file_name = $imageName;
                $existingPhoto->original_path = $originalPathFile;
                $existingPhoto->thumbnail_path = $thumbnailPathFile;
                $existingPhoto->alt = $description;
                $existingPhoto->save();
            }
        } else {
            $existingPhoto->alt = $description;
            $existingPhoto->save();
        }
        return redirect()->back()->with(['message' => 'You Have Been Successfull Modify The Changes!']);
    }

    public function deleteImageGallery(Request $request)
    {
        $id = $request->get('id');
        $existingPhoto = photos::find($id);
        $postId = $existingPhoto->post_id;
        $originalPhoto = $existingPhoto->original_path;
        $thumbNailPhoto = $existingPhoto->thumbnail_path;

        $originalPhoto = public_path($originalPhoto);
        if(File::exists($originalPhoto)) {
            File::delete($originalPhoto);
        }

        $thumbNailPhoto = public_path($thumbNailPhoto);
        if(File::exists($thumbNailPhoto)) {
            File::delete($thumbNailPhoto);
        }

        $existingPhoto->delete();

        // delete post id folder if post id dont have photo
        $postStillExist = photos::where('post_id', '=', $postId)->get('id')->count();
        // dd($postStillExist);
        if($postStillExist == 0) {
            $postIdFolderOriginal = public_path($this->originalPath.'/'.$postId);
            $postIdFolderThumbNail = public_path($this->thumbNailPath.'/'.$postId);
            if(File::isDirectory($postIdFolderOriginal)) {
                File::deleteDirectory($postIdFolderOriginal);
            }

            if(File::isDirectory($postIdFolderThumbNail)) {
                File::deleteDirectory($postIdFolderThumbNail);
            }
        }

        return redirect()->back()->with(['message' => 'You Have been successfull delete the image!']);
    }
}
