<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categories;
use App\SubCategories;
use App\slideshow;
use App\Posts;
use App\photos;
use App\product_browsures;
use Mail;
use Unicodeveloper\EmailValidator\EmailValidatorFacade;
use Illuminate\Support\Facades\DB;

class WebPageController extends Controller
{
    public function index()
    {
      $categories = Categories::all();
      $subCategories = SubCategories::all();
      $listOfSlideShow = slideshow::all()->sortByDesc('id')->take(8);
      $postListing = DB::table('posts')
                    ->select('posts.*', 'categories.title as catTitle')
                    ->leftJoin('categories', 'posts.category_id', '=', 'categories.id')
                    ->where('categories.type', '=', 'LISTING')
                    ->orderBy('id', 'desc')
                    ->take(2)->get();
      $postSubListing = DB::table('posts')
                    ->select('posts.*', 'sub_categories.title as subTitle')
                    ->leftJoin('categories', 'posts.category_id', '=', 'categories.id')
                    ->leftJoin('sub_categories', 'posts.subcategory_id', '=', 'sub_categories.id')
                    ->where('categories.type', '=', 'LISTING SUB')
                    ->orderBy('id', 'desc')
                    ->take(2)->get();
      $tab = "FIRST PAGE";
      return view('home', compact('categories', 'subCategories', 'listOfSlideShow', 'tab', 'postListing', 'postSubListing'));
    }

    public function viewContent($prvTab, $postId) {
        $categories = Categories::all();
        $subCategories = SubCategories::all();
        $post = Posts::find($postId);
        // visits($post)->increment();
        // $post_data = array_shift($post);
        $tab = $prvTab;
        $countBrowsure = product_browsures::where('product_id', $postId)->count();
        // dd($countBrowsure);
        $gallery = photos::where('post_id', '=', $postId)->get();
        $subcategoryId = $post->subcategory_id;
        return  view('post', compact('categories', 'subCategories', 'post', 'gallery', 'tab', 'countBrowsure', 'subcategoryId'));
    }

    public function getPDFBrowsure($postId) {
      $browsureArray = DB::table('product_browsures')->select('tmp_file')
                  ->where('product_id', $postId)->get()->toArray();
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

    public function getSubListingPage($subcategoryId) {
        $categories = Categories::all();
        $subCategories = SubCategories::all();
        $postListing = Posts::where('subcategory_id', $subcategoryId)->paginate(5);
        $tab = "SUB LISTING";
        return view('listing', compact('categories', 'subCategories', 'tab', 'subcategoryId', 'postListing'));
    }

    public function getListingPage($categoryId) {
      $categories = Categories::all();
      $subCategories = SubCategories::all();
      $postListing = Posts::where('category_id', $categoryId)->paginate(5);
      $tab = "LISTING";
      return view('listing', compact('categories', 'subCategories', 'tab', 'categoryId', 'postListing'));
    }

    public function getFacilityPage()
    {
        $categories = Categories::all();
        $subCategories = SubCategories::all();
        $facilityCategory = DB::table('categories')->where('type', '=', 'MAINTANANCE')->get()->toArray();
        $facilityId = array_shift($facilityCategory)->id;
        // dd($facilityId);
        $facilities = Posts::all();
        $listOfFacility = $facilities->where('category_id', $facilityId);

        $tab = "MAINTANANCE";
        // $hallo = "yes";
        return view('facility', compact('tab', 'categories', 'subCategories', 'listOfFacility'));
    }

    public function getAboutUsPage()
    {
        $categories = Categories::all();
        $subCategories = SubCategories::all();
        $aboutCategory = DB::table('categories')->where('title', '=', 'About Us')->get()->toArray();
        $aboutId = array_shift($aboutCategory)->id;
        $abouts = Posts::all();
        $listOfAbouts = $abouts->where('category_id', $aboutId);
        // dd($listOfAbouts);
        $tab = "ABOUT US";
        return view('about', compact('tab', 'categories', 'subCategories', 'listOfAbouts'));
    }

    public function bindSendEmailWithAjaxPostRequest(Request $request)
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $subject = $request->input('subject');
        $message = $request->input('message');
        $data = false;
        $emailExist = EmailValidatorFacade::verify($email)->isValid()[0];
        if($emailExist) {
            Mail::raw($message, function($mailMessage) use ($subject, $email, $name)
            {
                $mailMessage->subject($subject);
                $mailMessage->from($email, $name);
                $mailMessage->to(['stevenyeo70@gmail.com', 'loseruib@gmail.com']);
            });
            $data = true;
        }
        return response()->json(['Delivered' => $data]);
    }
}
