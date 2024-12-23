<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\MyBudgetCategory;
use App\Models\MyBudgetSection;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Schema;


class MyBudgetCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $insert_userid = Auth::id();

        $categories = DB::table('mybudget_category')
        ->select('id', 'name')
        ->where('user_id', $insert_userid)
        ->get();

        $sections = DB::table('mybudget_section')
        ->select('id', 'name')
        ->where('user_id', $insert_userid)
        ->get();
        
        return view('mybudget/mybudget_createcategory')->with('categories', $categories)
                                                       ->with('sections', $sections);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $insert_userid = Auth::id();

        $is_invalid = False;

        $name = $request->input('category-name-1');
        
        $textcolor = $request->input('category-color-text-1');

        $bgcolor = $request->input('category-color-bg-1');

        $iconcode = $request->input('category-icon-1');

        $iconcode = "&" . $iconcode . ";";

        $CHECK_FOR_CATEGORY = DB::select("select id from mybudget_category where name = ? and user_id = ?", [$name, $insert_userid]);

        // If category does not already exist, make the category.
        if (count($CHECK_FOR_CATEGORY) < 1) {
            $ITEM_INSERT = DB::table('mybudget_category')->insert([
                'name' => "$name",
                'user_id' => "$insert_userid",
                'color_bg' => "$bgcolor",
                'color_text' => "$textcolor",
                'icon_code' => "$iconcode"
            ]);
        } else {
            $is_invalid = True;    
        }


        $categories = MyBudgetCategory::all();

        $sections = MyBudgetSection::all();

        if ($is_invalid == False) {
        return view('mybudget/mybudget_createcategory')->with('success_message', $name)
                                                       ->with('categories', $categories)
                                                       ->with('sections', $sections);
        } else {
            $fail_message = 'Your category has not been added. Reason: Already exists';
            return view('mybudget/mybudget_createcategory')->with('fail_message', $fail_message)
                                                           ->with('categories', $categories)
                                                           ->with('sections', $sections);
        }
    }


    /**
     * Store a newly created subcategory in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_subcategory(Request $request) {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $insert_userid = Auth::id();
        //$TEMP_DELETE = DB::table('mybudget_item')->where('id', '>=', '272')->delete();
        //$column_listing_item = Schema::getColumnListing('mybudget_item');
        //$column_listing_category = Schema::getColumnListing('mybudget_category');
        //$column_listing_section = Schema::getColumnListing('mybudget_section');

        //$column_listing = array_merge($column_listing_item, $column_listing_category, $column_listing_section);

        $GET_SOURCE_SUM = DB::table('mybudget_item')
                                ->join('mybudget_source', 'mybudget_item.source_id', '=', 'mybudget_source.id')
                                ->select("mybudget_source.name as source_name")
                                ->selectRaw("SUM(mybudget_item.price) as sum_price")
                                ->groupBy("source_name")
                                ->get();

        
        $GET_SECTION_SUM = DB::table('mybudget_item')
                                ->join('mybudget_section', 'mybudget_item.section_id', '=', 'mybudget_section.id')
                                //->select("mybudget_section.id as section_id")
                                ->select("mybudget_section.name as section_name")
                                ->selectRaw("SUM(mybudget_item.price) as sum_price")
                                ->groupBy("section_name")
                                ->get();
        
        // Get Section Sum by Certain Category
        /*
        $GET_SECTION_SUM = DB::table('mybudget_item')
                                ->join('mybudget_section', 'mybudget_item.section_id', '=', 'mybudget_section.id')
                                ->join('mybudget_category', 'mybudget_item.category_id', '=', 'mybudget_category.id')
                                //->select("mybudget_section.id as section_id")
                                ->select("mybudget_section.name as section_name")
                                ->selectRaw("SUM(mybudget_item.price) as sum_price")
                                ->where("mybudget_category.id", "=", "2")
                                ->groupBy("section_name")
                                ->get();           
        */             

        // Get Section Sum by Certain Category within a Certain Month/Date Range
       
        $startDate = '2022-02-01 00:00:00';
        $endDate = '2022-02-19 00:00:00';

        $GET_SECTION_SUM = DB::table('mybudget_item')
                                ->join('mybudget_section', 'mybudget_item.section_id', '=', 'mybudget_section.id')
                                ->join('mybudget_category', 'mybudget_item.category_id', '=', 'mybudget_category.id')
                                //->select("mybudget_section.id as section_id")
                                ->select("mybudget_section.name as section_name")
                                ->selectRaw("SUM(mybudget_item.price) as sum_price")
                                ->where("mybudget_category.id", "=", "2")
                                ->whereBetween("mybudget_item.created_at", [$startDate, $endDate])
                                ->groupBy("section_name")
                                ->get();           
   
        //return mybudget_category::find($id);

        return $GET_SECTION_SUM;


        //return $column_listing;

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
        $category = mybudget_category::find($id);

        $bg_color_change = $request->input('category-color-bg-1-edit');
        $text_color_change = $request->input('category-color-text-1-edit');
        $icon_change = $request->input('category-icon-1-edit');

        $name = $request->input('category-name-1-edit');

        $icon_change_final = substr_replace($icon_change, '&', 0, 0);
        //$icon_change_final = substr_replace($icon_change_final, ';', 0, 0);
        $icon_change_final .= ';';
        
        $icon_change = $icon_change_final;

        $UPDATE_RECORD = DB::table('mybudget_category')
        ->where('id', $category['id'])
        ->update(['name' => $name, 'color_bg' => $bg_color_change, 'color_text' => $text_color_change, 'icon_code' => $icon_change])
        ;

        //return $bg_color_change;

        $categories = DB::table('mybudget_category')
                                ->select('mybudget_category.*')
                                ->where('user_id', "=", "$insert_userid")
                                ->get();

        $sections = DB::table('mybudget_section')
                                ->select('mybudget_section.*')
                                ->where('user_id', "=", "$insert_userid")
                                ->get();

        return view('mybudget/mybudget_createcategory')->with('success_message_edit', $name)
                                                       ->with('categories', $categories)
                                                       ->with('sections', $sections);

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

    public function view_sections() {

        $insert_userid = Auth::id();

        $GET_ALL_CATEGORIES = DB::table('mybudget_category')
                                ->select('mybudget_category.*')
                                ->where('user_id', "=", "$insert_userid")
                                ->get();

        // $ALL_CATEGORIES = mybudget_category::all();


        return view('mybudget/mybudget_viewsection')->with('all_categories_selected', $GET_ALL_CATEGORIES);

    }

    public function view_section($section_id) {
        $insert_userid = Auth::id();

        $GET_ALL_CATEGORIES = DB::table('mybudget_category')
                                ->select('id', 'name')
                                ->where('user_id', "=", "$insert_userid")
                                ->get();

        $GET_SECTION = DB::table('mybudget_section')
                        ->select('*')
                        ->where('id', '=', $section_id)
                        ->where('user_id', "=", "$insert_userid")
                        ->get();

        
        foreach($GET_SECTION as $SECTION) {
            $GET_CATEGORY_FROM_SECTION = DB::table('mybudget_category')
                                            ->select('*')
                                            ->where('id', '=', $SECTION->category_id)
                                            ->where('mybudget_category.user_id', "=", "$insert_userid")
                                            ->get();

            $GET_CATEGORY_FROM_SECTION = mybudget_category::find($SECTION->category_id);


        }

        
        /*
        $GET_ITEMS_RELATED_TO_SECTION = DB::table('mybudget_item')
                                            ->join('mybudget_category', 'mybudget_item.category_id', '=', 'mybudget_category.id')
                                            ->join('mybudget_section', 'mybudget_item.section_id', '=', 'mybudget_section.id')
                                            ->join('mybudget_source', 'mybudget_item.source_id', '=', 'mybudget_source.id')
                                            ->select('mybudget_item.*', 'mybudget_category.name as category_name', 'mybudget_section.name as section_name', 'mybudget_source.name as source_name')
                                            ->selectRaw("REPLACE(mybudget_item.price, ',', '') as price_twodp")
                                            ->whereNull('deleted_at')
                                            ->where("mybudget_section.id", "=", $section_id)
                                            ->inRandomOrder()
                                            ->limit(5)
                                            ->get();
        */

        $GET_ITEMS_RELATED_TO_SECTION = DB::table('mybudget_item')
                                            ->join('mybudget_category', 'mybudget_item.category_id', '=', 'mybudget_category.id')
                                            ->join('mybudget_section', 'mybudget_item.section_id', '=', 'mybudget_section.id')
                                            ->join('mybudget_source', 'mybudget_item.source_id', '=', 'mybudget_source.id')
                                            ->select('mybudget_item.*', 'mybudget_item.name as name', 'mybudget_item.price as price_twodp', 'mybudget_category.name as category_name', 'mybudget_section.name as section_name', 'mybudget_source.name as source_name')
                                            ->whereNull('deleted_at')
                                            ->where("mybudget_section.id", "=", $section_id)
                                            ->where('mybudget_item.user_id', "=", "$insert_userid")
                                            ->orderBy('mybudget_item.created_at', "desc")
                                            ->get();



        //return $GET_ITEMS_RELATED_TO_SECTION;
        
        $GET_DATES_RELATED_TO_SECTION = DB::table('mybudget_item')
                                            ->join('mybudget_category', 'mybudget_item.category_id', '=', 'mybudget_category.id')
                                            ->join('mybudget_section', 'mybudget_item.section_id', '=', 'mybudget_section.id')
                                            ->join('mybudget_source', 'mybudget_item.source_id', '=', 'mybudget_source.id')
                                            ->select('mybudget_item.created_at', DB::raw('mybudget_item.price as price_twodp'))
                                            ->whereNull('mybudget_item.deleted_at')
                                            ->where('mybudget_section.id', '=', $section_id)
                                            ->where('mybudget_item.user_id', '=', $insert_userid)
                                            ->groupBy('mybudget_item.price', 'mybudget_item.created_at')
                                            ->orderBy('mybudget_item.created_at', 'asc')
                                            ->get();

        $labels = [];
        $bar_data = [];

        $bar_color = (string)$GET_CATEGORY_FROM_SECTION['color_text'];
        $bg_color = (string)$GET_CATEGORY_FROM_SECTION['color_bg'];
        
        foreach($GET_DATES_RELATED_TO_SECTION as $date_section) {
            array_push($labels, (string)date('jS M Y', strtotime($date_section->created_at)));
            array_push($bar_data, (float)$date_section->price_twodp);
        }

        $pie_labels = [];
        $pie_data = [];
        $pie_colors = [];

        $GET_SOURCE_SUMS_RELATED_TO_SECTION = DB::table('mybudget_item')
                                                ->join('mybudget_category', 'mybudget_item.category_id', '=', 'mybudget_category.id')
                                                ->join('mybudget_section', 'mybudget_item.section_id', '=', 'mybudget_section.id')
                                                ->join('mybudget_source', 'mybudget_item.source_id', '=', 'mybudget_source.id')
                                                ->select('mybudget_item.name as name', 'mybudget_source.name as source_name', 'mybudget_item.price as price_twodp')
                                                ->whereNull('mybudget_item.deleted_at')
                                                ->where('mybudget_section.id', '=', $section_id)
                                                ->where('mybudget_item.user_id', '=', $insert_userid)
                                                ->groupBy('mybudget_item.id', 'mybudget_source.name', 'mybudget_item.price')
                                                ->orderBy('mybudget_item.price', 'desc')
                                                ->limit(10)
                                                ->get();


        foreach($GET_SOURCE_SUMS_RELATED_TO_SECTION as $source) {
            array_push($pie_labels, (string)($source->source_name));
            array_push($pie_data, (float)($source->price_twodp));
        }
                    
        return view('mybudget/mybudget_viewsection')->with('section_selected', $GET_SECTION)
                                                    ->with('section_items', $GET_ITEMS_RELATED_TO_SECTION)
                                                    ->with('category_selected', $GET_CATEGORY_FROM_SECTION)
                                                    ->with('labels', $labels)
                                                    ->with('bar_data', $bar_data)
                                                    ->with('bar_color', $bar_color)
                                                    ->with('bg_color', $bg_color)
                                                    ->with('pie_labels', $pie_labels)
                                                    ->with('pie_data', $pie_data);
    }

    public function add_subcategory(Request $request, $id) {
        
        $insert_userid = Auth::id();

        $categories  = DB::table('mybudget_category')
        ->select('mybudget_category.*')
        ->where('user_id', "=", "$insert_userid")
        ->get();

        $sections = DB::table('mybudget_section')
        ->select('mybudget_section.*')
        ->where('user_id', "=", "$insert_userid")
        ->get();


        //$TEMP_DELETE = DB::table('mybudget_category')->where('id', '>=', '14')->delete();

        $is_invalid = False;


        $subcategory_name = $request->input('subcategory-name-1');
        
        $CHECK_FOR_SUBCATEGORY = DB::select("select id from mybudget_section where name = ? and user_id = ?", [$subcategory_name, $insert_userid]);

        $current_datetime = date('Y-m-d H:i:s');
        
        if ($id == 'NONE') {
            $is_invalid = True;
            $fail_message = 'You need to select a category to make a subcategory.';

        } else {
            if (count($CHECK_FOR_SUBCATEGORY) < 1) { 
                $INSERT_SUBCATEGORY = DB::table('mybudget_section')->insert([
                    'name' => "$subcategory_name",
                    'created_at' => "$current_datetime",
                    'user_id' => "$insert_userid",
                    'category_id' => $id
                ]);

                $success_message_subcategory = "Congratulations, your subcategory: $subcategory_name has been added.";
            } else {
                $fail_message = 'Sorry, your subcategory already exists.';
                $is_invalid = True;

            }
        }

        

        if ($is_invalid == True) {
            
            return view('mybudget/mybudget_createcategory')->with('fail_message', $fail_message)
                                                           ->with('categories', $categories)
                                                           ->with('sections', $sections);

        } else {
            return view('mybudget/mybudget_createcategory')->with('success_message_subcategory', $success_message_subcategory)
                                                           ->with('categories', $categories)
                                                           ->with('sections', $sections);
        }

    }

    public function edit_subcategory(Request $request) {

        $insert_userid = Auth::id();

        $id = $request->input('subcategory-select-1-edit');

        $categories = DB::table('mybudget_category')
                        ->join('mybudget_section', 'mybudget_category.id', '=', 'mybudget_section.category_id')
                        ->select('mybudget_category.id as category_id', 'mybudget_category.name as category_name', 'mybudget_section.id as section_id', 'mybudget_section.name as section_name')
                        ->orderBy('mybudget_category.name')
                        ->orderBy('mybudget_section.name')
                        ->where('mybudget_category.user_id', '=', $insert_userid)
                        ->get();


                        $groupedData = $categories->groupBy('category_id');

        $sections = DB::table('mybudget_section')
                ->select('mybudget_section.*')
                ->where('user_id', $insert_userid)
                ->get();

        $is_invalid = False;

        $subcategory_name = $request->input('subcategory-select-1-edit-input');

        $CHECK_FOR_SUBCATEGORY = DB::select("select id from mybudget_section where name = ? and user_id = ?", [$subcategory_name, $insert_userid]);

        $current_datetime = date('Y-m-d H:i:s');
        


        if ($id == 'NONE') {
            $is_invalid = True;
            $fail_message = 'You need to select a subcategory first.';

        } else {
            if (count($CHECK_FOR_SUBCATEGORY) < 1) { 
                $UPDATE_RECORD = DB::table('mybudget_section')
                    ->where('id', $id)
                    ->update(['name' => $subcategory_name]);

                $success_message_subcategory = 'Congratulations, your subcategory has been edited.';
            } else {
                $fail_message = 'Sorry, your subcategory already exists.';
                $is_invalid = True;

            }
        }

        if ($is_invalid == True) {
            
            return view('mybudget/mybudget_createcategory')->with('fail_message', $fail_message)
                                                           ->with('categories', $categories)
                                                           ->with('sections', $sections)
                                                           ->with('groupedData', compact('groupedData'));

        } else {

            return view('mybudget/mybudget_createcategory')->with('success_message_subcategory', $success_message_subcategory)
                                                           ->with('categories', $categories)
                                                           ->with('sections', $sections)
                                                           ->with('groupedData', compact('groupedData'));
        }

        

    }
}


