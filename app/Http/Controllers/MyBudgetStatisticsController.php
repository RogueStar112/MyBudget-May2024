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
    public function show(Request $request, $id, $start_date, $end_date) {
        $insert_userid = Auth::id();      
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

     

        if ($id == 'ALL') {
            $GET_SECTIONS_FROM_CATEGORY = DB::table('mybudget_section')
                                        ->select('id', 'name', 'category_id')
                                        ->where('user_id', "=", "$insert_userid")
                                        //->orderBy('category_id', 'asc')
                                        //->where('category_id', $id)
                                        
                                        ->get();
        } else {
               $GET_SECTIONS_FROM_CATEGORY = DB::table('mybudget_section')
                                        ->select('id', 'name', 'category_id')
                                        ->where('category_id', $id)
                                        ->where('user_id', "=", "$insert_userid")
                                        //->orderBy('category_id', 'asc')
                                        ->get();
        }

        //return $GET_SECTIONS_FROM_CATEGORY;
        
        $GET_ITEMS_FROM_SECTION = DB::table('mybudget_item')
                                    ->select('*')
                                    ->where('user_id', "=", "$insert_userid")
                                    ->where('deleted_at', '=', NULL)
                                    ->whereBetween("created_at", [$start_date, $end_date])
                                    ->get();


        $section_list = array();
    
        
        $SECTION_SUM = [];

        // Get ALL 
        for ($x = 0; $x < count($GET_ALL_CATEGORIES); $x++) {
            $SECTION_SUM[$GET_ALL_CATEGORIES[$x]->name] = [];

        }

        //return $SECTION_SUM;

        for ($x = 0; $x < count($GET_ALL_CATEGORIES); $x++) {

     
            
            if ($id == 'ALL') {
                $GET_SECTIONS_FROM_CATEGORY = DB::table('mybudget_section')
                                            ->select('id', 'name', 'category_id')
                                            //->where('category_id', $id)
                                            ->where('user_id', "=", "$insert_userid")
                                            ->get();
            } else {
                $GET_SECTIONS_FROM_CATEGORY = DB::table('mybudget_section')
                                ->select('id', 'name', 'category_id')
                                ->where('category_id', $id)
                                ->where('user_id', "=", "$insert_userid")
                                ->get();
            }   

            for ($i = 0; $i < count($GET_SECTIONS_FROM_CATEGORY); $i++) {
                //array_push($section_list, $GET_SECTIONS_FROM_CATEGORY[$i]);
                
                $SECTION_ID = $GET_SECTIONS_FROM_CATEGORY[$i]->id;
                $SECTION_NAME = $GET_SECTIONS_FROM_CATEGORY[$i]->name;
    
                if($GET_SECTIONS_FROM_CATEGORY[$i]->category_id == $GET_ALL_CATEGORIES[$x]->id) {
                    $SECTION_SUM[$GET_ALL_CATEGORIES[$x]->name][$SECTION_NAME] = 0;
                } else {

                }
            }
        }

        

        //return $SECTION_SUM;

        for ($x = 0; $x < count($GET_ALL_CATEGORIES); $x++) {
            
          
            if ($id == 'ALL') {
                $GET_SECTIONS_FROM_CATEGORY = DB::table('mybudget_section')
                                            ->select('id', 'name', 'category_id')
                                            //->where('category_id', $id)
                                            ->where('user_id', "=", "$insert_userid")
                                            ->get();
            } else {
                  $GET_SECTIONS_FROM_CATEGORY = DB::table('mybudget_section')
                                        ->select('id', 'name', 'category_id')
                                        ->where('category_id', $id)
                                        ->where('user_id', "=", "$insert_userid")
                                        ->get();
            

            }

            for ($i = 0; $i < count($GET_SECTIONS_FROM_CATEGORY); $i++) {
                //array_push($section_list, $GET_SECTIONS_FROM_CATEGORY[$i]);
                
                $CATEGORY_ID = $GET_ALL_CATEGORIES[$x]->id;
                $CATEGORY_NAME = $GET_ALL_CATEGORIES[$x]->name;

                $SECTION_ID = $GET_SECTIONS_FROM_CATEGORY[$i]->id;
                $SECTION_NAME = $GET_SECTIONS_FROM_CATEGORY[$i]->name;

                $GET_ITEMS_FROM_SECTION = DB::table('mybudget_item')
                                    ->select('mybudget_item.price as price')
    
                                    ->whereNull('deleted_at')

                                    ->where('category_id', '=', $CATEGORY_ID) 
                                    ->where('section_id', '=', $SECTION_ID)
                                    ->where('user_id', "=", "$insert_userid")
                                    ->whereBetween("created_at", [$start_date, $end_date])
                                    ->where('has_subtransactions', '=', '0')
                                    ->get(); 

                // return $GET_ITEMS_FROM_SECTION;
                /*
                $GET_SUBTRANSACTIONS_FROM_SECTION = DB::table('mybudget_item')
                                                        ->select('id')
                                                        ->selectRaw('SUM(REPLACE(price, ",", "")) as sum_price')
                                                        ->whereNull('deleted_at')
                                                        ->where('category_id', '=', $CATEGORY_ID) 
                                                        ->where('section_id', '=', $SECTION_ID)
                                                        ->whereBetween("created_at", [$start_date, $end_date])
                                                        ->where('has_subtransactions', '=', '1')
                                                        ->get();  
                */
                
                
                 $GET_SUBTRANSACTIONS_FROM_SECTION = DB::table('mybudget_item')
                                            ->select("*")
                                            ->whereNull('deleted_at')
                                            ->where('category_id', '=', $CATEGORY_ID)
                                            ->where('section_id', '=', $SECTION_ID)
                                            ->whereBetween("created_at", [$start_date, $end_date])
                                            ->where('user_id', "=", "$insert_userid")
                                            ->where('has_subtransactions', '=', '1')
                                            ->get();

                foreach ($GET_ITEMS_FROM_SECTION as $ii) {
                    //$SECTION_SUM["$CATEGORY_NAME"]["$SECTION_NAME"] += [$ii]->price;
                }

                // return [$SECTION_SUM, $CATEGORY_NAME, $SECTION_NAME, $CATEGORY_ID, $GET_ITEMS_FROM_SECTION];
                
                for ($ii = 0; $ii < count($GET_ITEMS_FROM_SECTION); $ii++) {

                    //echo "$ii. $i CN: " . $CATEGORY_NAME . "<br>";
                    //echo "$ii. $i SN: " . $SECTION_NAME . "<br>";

                    // Category Name: Groceries
                    // Section Name: Frozen Food
                    // $SECTION_SUM['Groceries']['Frozen Food'] += $GET_ITEMS_FROM_SECTION[$ii]->price;

                    if (isset($SECTION_SUM["$CATEGORY_NAME"]["$SECTION_NAME"])) {
                    $SECTION_SUM["$CATEGORY_NAME"]["$SECTION_NAME"] += $GET_ITEMS_FROM_SECTION[$ii]->price;
                    } else {
                        // do nothing
                    }

                }

                return [$SECTION_SUM, $CATEGORY_NAME, $SECTION_NAME, $CATEGORY_ID, $GET_ITEMS_FROM_SECTION];
                
                
                // return [$GET_ITEMS_FROM_SECTION, $SECTION_SUM, $CATEGORY_NAME, $SECTION_NAME];
                
                for ($iii = 0; $iii < count($GET_SUBTRANSACTIONS_FROM_SECTION); $iii++) {

                    $TRANSACTION_ID = $GET_SUBTRANSACTIONS_FROM_SECTION[$iii]->id;

                    //$TRANSACTION_ID = 417;
                    
                    $GET_SUBTRANSACTIONS_FROM_ITEM = DB::table('mybudget_subtransactions')
                                                        ->join('mybudget_category', 'mybudget_subtransactions.category_id', '=', 'mybudget_category.id')
                                                        ->join('mybudget_section', 'mybudget_subtransactions.section_id', '=', 'mybudget_section.id')
                                                        ->select('mybudget_category.name as category_name', 'mybudget_section.name as section_name')
                                                        //->select('mybudget_section.name as section_name')
                                                        ->selectRaw("SUM(mybudget_subtransactions.price) as sum_price")
    
                                                        ->where("transaction_id", $TRANSACTION_ID)
                                                        //->where("section_id", $SECTION_ID)
                                                        ->groupBy('category_name', 'section_name')
                                                        //->distinct()
                                                        ->get();

                    for ($iv = 0; $iv < count($GET_SUBTRANSACTIONS_FROM_ITEM); $iv++) {

                        $SUBTRANSACTION_CATEGORY = $GET_SUBTRANSACTIONS_FROM_ITEM[$iv]->category_name;
                        $SUBTRANSACTION_NAME = $GET_SUBTRANSACTIONS_FROM_ITEM[$iv]->section_name;
                        $SUBTRANSACTION_PRICE = $GET_SUBTRANSACTIONS_FROM_ITEM[$iv]->sum_price;

                        $SECTION_SUM["$SUBTRANSACTION_CATEGORY"]["$SUBTRANSACTION_NAME"] += $SUBTRANSACTION_PRICE;
                    }
                }
            }
        }
        
        //arsort($SECTION_SUM);
        //return $SECTION_SUM;
        

        $GET_SECTIONS_FROM_CATEGORY = DB::table('mybudget_section')
                                        ->select('id', 'name', 'category_id')
                                        ->where('category_id', $id)
                                        ->get();
        
        // Returns the SUM of a section's items, if they have no subtransactions.
        $GET_ITEMS_FROM_SECTION = DB::table('mybudget_item')
                                    ->selectRaw('SUM(price) as sum_price')
                                    ->whereNull('deleted_at')

                                    ->where('section_id', '=', $SECTION_ID)
                                    ->whereBetween("created_at", [$start_date, $end_date])
                                    ->where('has_subtransactions', '=', '0')
                                    ->get();   

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
                                ->where('user_id', $insert_userid)
                                ->whereBetween("mybudget_item.created_at", [$start_date, $end_date])
                                ->whereNull('deleted_at')
                                ->groupBy('mybudget_item.id', 'mybudget_item.name', 'category_name', 'section_name', 'source_name')
                                ->orderBy('mybudget_item.created_at', 'desc')
                                ->get();


        $GET_CATEGORY_DETAILS = mybudget_category::find($id);

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
                                    ->select('mybudget_item.created_at')
                                    ->selectRaw("SUM(mybudget_item.price) as price_twodp")
                                    ->where('mybudget_section.name', '!=', 'Income')
                                    ->whereNull('deleted_at')
                                    ->whereBetween("mybudget_item.created_at", [$start_date, $end_date])
                                    ->groupBy('mybudget_item.id', 'mybudget_item.created_at')
                                    ->orderBy('mybudget_item.created_at', "asc")
                                    ->get();
       
        $labels = [];
        $bar_data = [];
        
        foreach($GET_SUMS_OF_DATE_RANGE as $date_section) {
            array_push($labels, (string)date('jS M Y', strtotime($date_section->created_at)));
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
