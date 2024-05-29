<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\mybudget_category;
use App\Models\mybudget_item;

use Illuminate\Support\Facades\Auth;

class MyBudgetStatisticsController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @param  string  $start_date
     * @param  string  $end_date
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request) {
        $insert_userid = Auth::id();      

        $id = $request->input('select-category');
        $start_date = $request->input('input-date-start');
        $end_date = $request->input('input-date-end');


        // Add start and end date times for datetime compatibility
        $start_date .= " 00:00:00";
        $end_date .= " 23:59:59";

        if ($id === 'ALL') {
        $GET_ALL_CATEGORIES = DB::table('mybudget_category')
                                ->select('id', 'name')
                                ->where('user_id', "=", "$insert_userid")
                                ->get();
        } else {
            $GET_ALL_CATEGORIES = DB::table('mybudget_category')
                                    ->select('id', 'name')
                                    ->where('id', $id)
                                    ->where('user_id', "=", "$insert_userid")
                                    ->get();    
        }

     

        // if ($id == 'ALL') {
        //     $GET_SECTIONS_FROM_CATEGORY = DB::table('mybudget_section')
        //                                 ->select('id', 'name', 'category_id')
        //                                 ->where('user_id', "=", "$insert_userid")
        //                                 //->orderBy('category_id', 'asc')
        //                                 //->where('category_id', $id)
                                        
        //                                 ->get();
        // } else {
        //        $GET_SECTIONS_FROM_CATEGORY = DB::table('mybudget_section')
        //                                 ->select('id', 'name', 'category_id')
        //                                 ->where('category_id', $id)
        //                                 ->where('user_id', "=", "$insert_userid")
        //                                 //->orderBy('category_id', 'asc')
        //                                 ->get();
        // }

        //return $GET_SECTIONS_FROM_CATEGORY;
        
        // $GET_ITEMS_FROM_SECTION = DB::table('mybudget_item')
        //                             ->select('*')
        //                             ->where('user_id', "=", "$insert_userid")
        //                             ->where('deleted_at', '=', NULL)
        //                             ->whereBetween("created_at", [$start_date, $end_date])
        //                             ->get();


        // $section_list = array();
    
        
        $SECTION_SUM = [];

        // Get ALL 
        // Assuming $GET_ALL_CATEGORIES is already populated and $insert_userid, $start_date, $end_date are defined

            $CATEGORY_IDS = array_column($GET_ALL_CATEGORIES->toArray(), 'id');

            // Fetch all sections for the given categories and user in one query
            $GET_SECTIONS_FROM_CATEGORY = DB::table('mybudget_section')
                ->select('id', 'name', 'category_id')
                ->whereIn('category_id', $CATEGORY_IDS)
                ->where('user_id', '=', $insert_userid)
                ->get();

            // Group sections by category_id for easy access
            $sectionsByCategory = $GET_SECTIONS_FROM_CATEGORY->groupBy('category_id');

            // Fetch all items for the given categories, sections, and user in one query
            $GET_ITEMS_FROM_SECTION = DB::table('mybudget_item')
                ->select('category_id', 'section_id', 'price')
                ->whereNull('deleted_at')
                ->whereIn('category_id', $CATEGORY_IDS)
                ->whereIn('section_id', $GET_SECTIONS_FROM_CATEGORY->pluck('id'))
                ->where('user_id', '=', $insert_userid)
                ->whereBetween('created_at', [$start_date, $end_date])
                ->where('has_subtransactions', '=', '0')
                ->get();

            // Initialize an empty array for sums
            $SECTION_SUM = [];

            // Iterate through categories
            foreach ($GET_ALL_CATEGORIES as $category) {
                $CATEGORY_ID = $category->id;
                $CATEGORY_NAME = $category->name;

                if (isset($sectionsByCategory[$CATEGORY_ID])) {
                    foreach ($sectionsByCategory[$CATEGORY_ID] as $section) {
                        $SECTION_ID = $section->id;
                        $SECTION_NAME = $section->name;

                        // Sum items for this section
                        $sum = $GET_ITEMS_FROM_SECTION->where('category_id', $CATEGORY_ID)->where('section_id', $SECTION_ID)->sum('price');
                        $SECTION_SUM[$CATEGORY_NAME][$SECTION_NAME] = $sum;
                    }
                }
            }

            // Output or use $SECTION_SUM as needed
            // return $SECTION_SUM;
        

        // $GET_SECTIONS_FROM_CATEGORY = DB::table('mybudget_section')
        //                                 ->select('id', 'name', 'category_id')
        //                                 ->where('category_id', $id)
        //                                 ->get();
        
        // // Returns the SUM of a section's items, if they have no subtransactions.
        // $GET_ITEMS_FROM_SECTION = DB::table('mybudget_item')
        //                             ->selectRaw('SUM(price) as sum_price')
        //                             ->whereNull('deleted_at')

        //                             ->where('section_id', '=', $SECTION_ID)
        //                             ->whereBetween("created_at", [$start_date, $end_date])
        //                             ->where('has_subtransactions', '=', '0')
        //                             ->get();   

        // $ALL_CATEGORIES = DB::table('mybudget_category')
        //                     ->join('mybudget_section', 'mybudget_category.id', '=', 'mybudget_section.category_id')
        //                     ->select('mybudget_category.id as category_id', 'mybudget_category.name as category_name', 'mybudget_section.id as section_id', 'mybudget_section.name as section_name')
        //                     ->orderBy('mybudget_category.name')
        //                     ->orderBy('mybudget_section.name')
        //                     ->where('mybudget_category.user_id', '=', $insert_userid)
        //                     ->get();

        $ALL_CATEGORIES = DB::table('mybudget_category')
                            ->select('mybudget_category.*')
                            ->where('user_id', $insert_userid)
                            ->get();

        $TRANSACTIONS_SELECT = DB::table('mybudget_item')
                                ->join('mybudget_category', 'mybudget_item.category_id', '=', 'mybudget_category.id')
                                ->join('mybudget_section', 'mybudget_item.section_id', '=', 'mybudget_section.id')
                                ->join('mybudget_source', 'mybudget_item.source_id', '=', 'mybudget_source.id')
                                ->select('mybudget_item.*', 'mybudget_category.name as category_name', 'mybudget_section.name as section_name', 'mybudget_source.name as source_name')
                                ->selectRaw("SUM(mybudget_item.price) as price_twodp")
                                ->where('mybudget_item.user_id', $insert_userid)
                                ->whereBetween("mybudget_item.created_at", [$start_date, $end_date])
                                ->whereNull('deleted_at')
                                ->groupBy('mybudget_item.id', 'mybudget_item.name', 'category_name', 'section_name', 'source_name')
                                ->orderBy('mybudget_item.created_at', 'desc')
                                ->get();


      

        if ($id == 'ALL') {
        
        $GET_DATES_RELATED_TO_SECTION = DB::table('mybudget_item')
                                            ->join('mybudget_category', 'mybudget_item.category_id', '=', 'mybudget_category.id')
                                            ->join('mybudget_section', 'mybudget_item.section_id', '=', 'mybudget_section.id')
                                            ->join('mybudget_source', 'mybudget_item.source_id', '=', 'mybudget_source.id')
                                            ->select('mybudget_item.created_at')
                                            ->selectRaw("SUM(mybudget_item.price) as price_twodp")
                                            ->whereNull('deleted_at')
                                            ->where("mybudget_section.id", "=", $SECTION_ID)
                                            ->groupBy('mybudget_item.id', 'mybudget_item.created_at')
                                            ->orderBy('mybudget_item.created_at', "asc")
                                            ->get();

                    $GET_SUMS_OF_DATE_RANGE = DB::table('mybudget_item')
                                            ->join('mybudget_category', 'mybudget_item.category_id', '=', 'mybudget_category.id')
                                            ->join('mybudget_section', 'mybudget_item.section_id', '=', 'mybudget_section.id')
                                            ->join('mybudget_source', 'mybudget_item.source_id', '=', 'mybudget_source.id')
                                            ->selectRaw("DATE(mybudget_item.created_at) as date")
                                            ->selectRaw("SUM(mybudget_item.price) as price_twodp")
                                            ->where('mybudget_section.name', '!=', 'Income')
                                            ->where('mybudget_item.user_id', $insert_userid)
                                            ->whereNull('deleted_at')
                                            ->whereBetween("mybudget_item.created_at", [$start_date, $end_date])
                                            ->groupBy(DB::raw("DATE(mybudget_item.created_at)"))
                                            ->orderBy(DB::raw("DATE(mybudget_item.created_at)"), "asc")
                                            ->get();
       
        $labels = [];
        $bar_data = [];
        
        foreach($GET_SUMS_OF_DATE_RANGE as $date_section) {
            array_push($labels, (string)date('jS M Y', strtotime($date_section->date)));
            array_push($bar_data, (float)$date_section->price_twodp);
        }

        return view('mybudget/mybudget_statistics')->with('categories', $ALL_CATEGORIES)
                                                ->with('sections', $SECTION_SUM)
                                                ->with('category_selected', $ALL_CATEGORIES)
                                                ->with('start_date', $start_date)
                                                ->with('end_date', $end_date)
                                                ->with('id', $id)
                                                ->with('transactions', $TRANSACTIONS_SELECT)
                                                ->with('daily_graph_labels', $labels)
                                                ->with('daily_graph_data', $bar_data);
        } else {
          $GET_CATEGORY_DETAILS = mybudget_category::find($id);
        return view('mybudget/mybudget_statistics')->with('categories', $ALL_CATEGORIES)
                                                ->with('sections', $SECTION_SUM)
                                                ->with('category_selected', $GET_CATEGORY_DETAILS)
                                                ->with('start_date', $start_date)
                                                ->with('end_date', $end_date)
                                                ->with('id', $id)
                                                ->with('transactions', $TRANSACTIONS_SELECT);    
        }
    }
        
        /*

        How the algorithm works

        Loop Through A Selected Category's Sections
            Get the Section

        */

    

        //return $section_list;

        /*
        $NEW_GET_SECTION_SUM = DB::table('mybudget_item')
                                ->join('mybudget_section', 'mybudget_item.section_id', '=', 'mybudget_section.id')
                                ->join('mybudget_category', 'mybudget_item.category_id', '=', 'mybudget_category.id')
                                //->select("mybudget_section.id as section_id")
                                ->select("mybudget_section.name as section_name")
                                ->selectRaw("SUM(REPLACE(mybudget_item.price, ',', '')) as sum_price")
                                ->where("mybudget_category.id", "=", "$id")

    
                                
        $GET_SECTION_SUM = DB::table('mybudget_item')
                            ->join('mybudget_section', 'mybudget_item.section_id', '=', 'mybudget_section.id')
                            ->join('mybudget_category', 'mybudget_item.category_id', '=', 'mybudget_category.id')
                            //->select("mybudget_section.id as section_id")
                            ->select("mybudget_section.name as section_name")
                            ->selectRaw("SUM(REPLACE(mybudget_item.price, ',', '')) as sum_price")
                            ->where("mybudget_category.id", "=", "$id")
                            ->whereBetween("mybudget_item.created_at", [$start_date, $end_date])
                            ->whereNull('deleted_at')
                            ->groupBy("section_name")
                            ->orderBy("sum_price", "desc")
                            ->get();
        
        $ALL_CATEGORIES = mybudget_category::all();

        $GET_CATEGORY_DETAILS = mybudget_category::find($id);

        $TRANSACTIONS_SELECT = DB::table('mybudget_item')
                                ->join('mybudget_category', 'mybudget_item.category_id', '=', 'mybudget_category.id')
                                ->join('mybudget_section', 'mybudget_item.section_id', '=', 'mybudget_section.id')
                                ->join('mybudget_source', 'mybudget_item.source_id', '=', 'mybudget_source.id')
                                ->select('mybudget_item.*', 'mybudget_category.name as category_name', 'mybudget_section.name as section_name', 'mybudget_source.name as source_name')
                                ->selectRaw("REPLACE(mybudget_item.price, ',', '') as price_twodp")
                                ->where("mybudget_category.id", "=", "$id")
                                ->whereBetween("mybudget_item.created_at", [$start_date, $end_date])
                                ->whereNull('deleted_at')
                                ->orderBy('mybudget_item.created_at', 'desc')
                                ->get();

        if ($id == 'ALL') {

            
            $GET_SECTION_SUM = DB::table('mybudget_item')
                            ->join('mybudget_section', 'mybudget_item.section_id', '=', 'mybudget_section.id')
                            ->join('mybudget_category', 'mybudget_item.category_id', '=', 'mybudget_category.id')
                            //->select("mybudget_section.id as section_id")
                            ->select("mybudget_section.name as section_name")
                            ->selectRaw("SUM(REPLACE(mybudget_item.price, ',', '')) as sum_price")
                            ->where("mybudget_category.id", "=", "$id")
                            ->whereBetween("mybudget_item.created_at", [$start_date, $end_date])
                            ->whereNull('deleted_at')
                            ->groupBy("section_name")
                            ->orderBy("sum_price", "desc")
                            ->get();

            $TRANSACTIONS_SELECT = DB::table('mybudget_item')
                                ->join('mybudget_category', 'mybudget_item.category_id', '=', 'mybudget_category.id')
                                ->join('mybudget_section', 'mybudget_item.section_id', '=', 'mybudget_section.id')
                                ->join('mybudget_source', 'mybudget_item.source_id', '=', 'mybudget_source.id')
                                ->select('mybudget_item.*', 'mybudget_category.name as category_name', 'mybudget_section.name as section_name', 'mybudget_source.name as source_name')
                                ->selectRaw("REPLACE(mybudget_item.price, ',', '') as price_twodp")
                                ->whereBetween("mybudget_item.created_at", [$start_date, $end_date])
                                ->whereNull('deleted_at')
                                ->orderBy('mybudget_item.created_at', 'desc')
                                ->get();
        }

        // Temporary Solution 
        // Section ID 26 = Income Section. ->where Clause Means, Where there are no income transactions

        // ->selectRaw('DISTINCT(substr(created_at, 1, 10)) as dates') Means, Select Dates WITHOUT datetime

        $toggle_daily_sum_bool = $request->input('toggle-daily-sum');

        if($toggle_daily_sum_bool == 'on') {
            $TRANSACTIONS_SELECT_DATES_SUM = DB::table('mybudget_item')
                                            ->selectRaw('DISTINCT(substr(created_at, 1, 10)) as dates')
                                            ->selectRaw('SUM(REPLACE(price, ",", "")) as sum_price')
                                            ->where("section_id", "<>", "26")
                                            ->whereBetween("dates", [$start_date, $end_date])
                                            ->groupBy('dates')
                                            ->orderBy('dates', 'desc')
                                            ->get();
        } else {
            $TRANSACTIONS_SELECT_DATES_SUM = 'None';
        }

        if($id == 'ALL'){
            return view('mybudget/mybudget_statistics')->with('categories', $ALL_CATEGORIES)
                                                      ->with('sections', $GET_SECTION_SUM)
                                                      ->with('category_selected', $ALL_CATEGORIES)
                                                      ->with('start_date', $start_date)
                                                      ->with('end_date', $end_date)
                                                      ->with('id', $id)
                                                      ->with('transactions', $TRANSACTIONS_SELECT);
        } else {
            return view('mybudget/mybudget_statistics')->with('categories', $ALL_CATEGORIES)
                                                      ->with('category_selected', $GET_CATEGORY_DETAILS)
                                                      ->with('start_date', $start_date)
                                                      ->with('end_date', $end_date)
                                                      ->with('id', $id)
                                                      ->with('sections', $GET_SECTION_SUM)
                                                      ->with('transactions', $TRANSACTIONS_SELECT);
        }


        if($toggle_daily_sum_bool == 'on') {
        return view('mybudget/mybudget_statistics')->with('categories', $ALL_CATEGORIES)
                                                   ->with('category_selected', $GET_CATEGORY_DETAILS)
                                                   ->with('sections', $GET_SECTION_SUM)
                                                   ->with('transactions', $TRANSACTIONS_SELECT)
                                                   ->with('transaction_dates', $TRANSACTIONS_SELECT_DATES_SUM);
        } else {
            return view('mybudget/mybudget_statistics')->with('categories', $ALL_CATEGORIES)
                                                   ->with('category_selected', $GET_CATEGORY_DETAILS)
                                                   ->with('sections', $GET_SECTION_SUM)
                                                   ->with('transactions', $TRANSACTIONS_SELECT);
        }

        */
    }
