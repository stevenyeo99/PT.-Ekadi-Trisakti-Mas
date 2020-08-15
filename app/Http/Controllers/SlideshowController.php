<?php

namespace App\Http\Controllers;

use App\slideshow;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use File;
use Image;

class SlideshowController extends Controller
{
    private $originalPath = 'img/slideshow/original';
    private $thumbNailPath = 'img/slideshow/thumbnail';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      // dd("hai");
        $slideShow = DB::table('slideshows')->orderBy('id', 'DESC')->get();
        $tab = "slideshow";
        return view('admin.admin-components.slideshow', compact('slideShow', 'tab'));
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
        $alt = $request->get('alt');

        if($request->hasFile('file_name')) {

          $imageTmp = $request->file('file_name');
          $imageName = $request->file('file_name')->getClientOriginalName();
          $imageUploadedName = time().'.'.$imageTmp->getClientOriginalExtension();

          $originalImage = Image::make($imageTmp->getRealPath());
          $publicOriginalPath = public_path($this->originalPath);
          if(!File::isDirectory($publicOriginalPath)) {
              File::makeDirectory($publicOriginalPath, 0777, true, true);
          }
          $originalPathFile = $this->originalPath.'/'.$imageUploadedName;
          $originalImage->resize(3000, 1200)->save($publicOriginalPath.'/'.$imageUploadedName);

          $thumbNailImage = Image::make($imageTmp->getRealPath());
          $publicThumbNailPath = public_path($this->thumbNailPath);
          if(!File::isDirectory($publicThumbNailPath)) {
              File::makeDirectory($publicThumbNailPath, 0777, true, true);
          }
          $thumbnailPathFile = $this->thumbNailPath.'/'.$imageUploadedName;
          $thumbNailImage->resize(2000, 800)->save($publicThumbNailPath.'/'.$imageUploadedName);

          DB::insert('insert into slideshows(file_name, alt, original_path, thumbnail_path, created_at) values(?, ?, ?, ?, ?)', [$imageName, $alt, $originalPathFile, $thumbnailPathFile, now()]);
        }

        return redirect()->back()->with(['message' => 'Your Image Has Been Succesfull Uploaded!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\slideshow  $slideshow
     * @return \Illuminate\Http\Response
     */
    public function show(slideshow $slideshow)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\slideshow  $slideshow
     * @return \Illuminate\Http\Response
     */
    public function edit(slideshow $slideshow)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\slideshow  $slideshow
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, slideshow $slideshow)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\slideshow  $slideshow
     * @return \Illuminate\Http\Response
     */
    public function destroy(slideshow $slideshow)
    {
        //
    }

    public function updateSlideShowImage(Request $request)
    {
        $slideShowOld = DB::table('slideshows')->select(['file_name', 'original_path', 'thumbnail_path', 'alt'])->where('id', '=', $request->get('id'))->get()->toArray();
        $fileOldName = array_shift($slideShowOld);
        $changeImage = $request->get('changeImage');
        $alt = $fileOldName->alt;
        $originalOldPath = $fileOldName->original_path;
        $thumbNailPath = $fileOldName->thumbnail_path;
        if($request->get('alt') != $alt) {
            $alt = $request->get('alt');
        }
        if(isset($changeImage) && $changeImage == 1) {
            if($request->hasFile('file_name')) {
                $imageTmp = $request->file('file_name');
                $imageName = $request->file('file_name')->getClientOriginalName();
                $imageUploadedName = time().'.'.$imageTmp->getClientOriginalExtension();

                // resize file size
                $originalImage = Image::make($imageTmp->getRealPath());
                $originalPathFile = $this->originalPath.'/'.$imageUploadedName;
                $originalImage->resize(3000, 1200)->save(public_path($originalPathFile));

                $thumbNailImage = Image::make($imageTmp->getRealPath());
                $thumbnailPathFile = $this->thumbNailPath.'/'.$imageUploadedName;
                $thumbNailImage->resize(2000, 800)->save(public_path($thumbnailPathFile));

                $slideShowUpdate = slideshow::find($request->get('id'));
                $slideShowUpdate->file_name = $imageName;
                $slideShowUpdate->alt = $alt;
                $slideShowUpdate->original_path = $originalPathFile;
                $slideShowUpdate->thumbnail_path = $thumbnailPathFile;

                $slideShowUpdate->save();
                // delete old image
                // public path
                $publicOriginalOldPath = public_path($originalOldPath);
                if(File::exists($publicOriginalOldPath)) {
                    File::delete($publicOriginalOldPath);
                }
                $publicThumbNailPath = public_path($thumbNailPath);
                if(File::exists($publicThumbNailPath)) {
                    File::delete($publicThumbNailPath);
                }

                return redirect()->route('slideshow.index')->with(['message' => 'You Have Succesfull Updated The SlideShow Image!']);
            }
        } else {
            $slideShowUpdate = slideshow::find($request->get('id'));
            $slideShowUpdate->alt = $request->get('alt');
            $slideShowUpdate->save();
            return redirect()->back()->with(['message' => 'You Have Successfull Updated The slideshow Description!']);
        }
        return redirect()->route('slideshow.index')->with(['messageFail' => 'You Have Failed Updated The SlideShow Image!']);
    }


    public function deleteSlideShowImage(Request $request)
    {
        $request->validate([
          'id' => 'required',
        ]);

        $slideShow = slideshow::find($request->get('id'));
        $originalPath = $slideShow->original_path;
        $thumbNailPath = $slideShow->thumbnail_path;
        if($slideShow->count() != 0) {
            $publicOriginalPath = public_path($originalPath);
            $publicThumbNailPath = public_path($thumbNailPath);
            if(File::exists($publicOriginalPath)) {
                File::delete($publicOriginalPath);
            }
            if(File::exists($publicThumbNailPath)) {
                File::delete($publicThumbNailPath);
            }
            $slideShow->delete();
            return redirect()->route('slideshow.index')->with(['message' => 'You Have Succesfull Deleted The SlideShow Image!']);
        }
        return redirect()->route('slideshow.index')->with(['messageFail' => 'You Failed To Delete This SlideShow Image!']);
    }
}
