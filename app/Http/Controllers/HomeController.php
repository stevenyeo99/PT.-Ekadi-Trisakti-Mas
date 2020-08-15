<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categories;
use App\User;
use App\Posts;
use App\slideshow;
use App\SubCategories;
use App\product_browsures;
use App\photos;
use Illuminate\Support\Facades\DB;
use Analytics;
use Spatie\Analytics\Period;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $tab = "dashboard";
        $postSize = Posts::all()->count();
        $slideshowSize = slideshow::all()->count();
        $browsureSize = product_browsures::all()->count();
        $gallerySize = photos::distinct()->get('post_id')->count();
        return view('admin/admin-components/dashboard', compact('tab', 'postSize', 'slideshowSize', 'browsureSize', 'gallerySize'));
    }

    public function gettingJsonVisitorPageView() {
        $visitor = Analytics::fetchVisitorsAndPageViews(Period::days(7));
        $result[] = ['date', 'visitor'];

        $last7Days = "-7 Days";
        for($i = 1; $i <= 7; $i++) {
            $date = date('d/m/Y', strtotime($last7Days . "+" . $i . "Days"));
            array_push($result, [$date, 0]);
        }

        foreach($visitor as $value) {
            for($i = 0; $i < count($result); $i++) {
                if($result[$i][0] == $value["date"]->format("d/m/Y")) {
                    $result[$i][1] = $value["visitors"];
                }
            }
        }

        return response()->json($result, 200);
    }

    public function setAjaxChartBarData()
    {
        $listOfGraphicArray = array();

        $categorySize = Categories::all()->count();
        $listOfGraphicArray['categorySize'] = $categorySize;

        $slideshowSize = slideshow::all()->count();
        $listOfGraphicArray['slideshowSize'] = $slideshowSize;

        $postSize = Posts::all()->count();

        // declare post base of category
        $listOfCategory = DB::table('categories')->select('id', 'title')->get()->toArray();


        foreach($listOfCategory as $category)
        {
            $postByCategoryId = Posts::where('category_id', '=', $category->id)->count();
            $subcategoryByCategory = DB::table('sub_categories')->select('id', 'title')->where('category_id', '=', $category->id)->get()->toArray();
            $subCategoryUsed = false;
            foreach($subcategoryByCategory as $subCategory)
            {
                $postBySubCategoryId = Posts::where('subcategory_id', '=', $subCategory->id)->count();
                $listOfGraphicArray['posted'][$category->title.' ('.$subCategory->title.')'] = $postBySubCategoryId;
                $subCategoryUsed = true;
            }

            if(!$subCategoryUsed) {
                $listOfGraphicArray['posted'][$category->title] = $postByCategoryId;
            }
        }
        // dd($listOfGraphicArray);


        $subcategorySize = SubCategories::all()->count();
        $adminSize = User::all()->count();
        return response()->json(
          $listOfGraphicArray, 200);
    }
}
