<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\mybudget_category;
use App\Models\mybudget_item;

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

        // Add start and end date times for datetime compatibility
        $start_date .= " 00:00:00";
        $end_date .= " 23:59:59";

        if ($id === 'ALL') {
        $GET_ALL_CATEGORIES = DB::table('mybudget_category')
                                ->select('id', 'name')
                                ->get();
        } else {
            $GET_ALL_CATEGORIES = DB::table('mybudget_category')
                                    ->select('id', 'name')
                                    ->where('id', $id)
                                    ->get();    
        }

        $GET_SECTIONS_FROM_CATEGORY = DB::table('mybudget_section')
                                        ->select('id', 'name', 'category_id')
                                        ->where('category_id', $id)
                                        ->get();

        if ($id == 'ALL') {
            $GET_SECTIONS_FROM_CATEGORY = DB::table('mybudget_section')
                                        ->select('id', 'name', 'category_id')
                                        //->where('category_id', $id)
                                        ->get();
        }
        
        $GET_ITEMS_FROM_SECTION = DB::table('mybudget_item')
                                    ->select('*')
                                    ->where('deleted_at', '=', NULL)
                                    ->whereBetween("created_at", [$start_date, $end_date])
                                    ->get();


        $section_list = array();
    
        
        $SECTION_SUM = [];

        // Get ALL 
        for ($x = 0; $x < count($GET_ALL_CATEGORIES); $x++) {
            $SECTION_SUM[$GET_ALL_CATEGORIES[$x]->name] = [];

        }

        for ($x = 0; $x < count($GET_ALL_CATEGORIES); $x++) {

            $GET_SECTIONS_FROM_CATEGORY = DB::table('mybudget_section')
                                        ->select('id', 'name', 'category_id')
                                        ->where('category_id', $id)
                                        ->get();
            
            if ($id == 'ALL') {
                $GET_SECTIONS_FROM_CATEGORY = DB::table('mybudget_section')
                                            ->select('id', 'name', 'category_id')
                                            //->where('category_id', $id)
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
            
            $GET_SECTIONS_FROM_CATEGORY = DB::table('mybudget_section')
                                        ->select('id', 'name', 'category_id')
                                        ->where('category_id', $id)
                                        ->get();
            
            if ($id == 'ALL') {
                $GET_SECTIONS_FROM_CATEGORY = DB::table('mybudget_section')
                                            ->select('id', 'name', 'category_id')
                                            //->where('category_id', $id)
                                            ->get();
            }

            for ($i = 0; $i < count($GET_SECTIONS_FROM_CATEGORY); $i++) {
                //array_push($section_list, $GET_SECTIONS_FROM_CATEGORY[$i]);
                
                $CATEGORY_ID = $GET_ALL_CATEGORIES[$x]->id;
                $CATEGORY_NAME = $GET_ALL_CATEGORIES[$x]->name;

                $SECTION_ID = $GET_SECTIONS_FROM_CATEGORY[$i]->id;
                $SECTION_NAME = $GET_SECTIONS_FROM_CATEGORY[$i]->name;

                $GET_ITEMS_FROM_SECTION = DB::table('mybudget_item')
                                    ->selectRaw('SUM(REPLACE(price, ",", "")) as sum_price')
                                    ->whereNull('deleted_at')

                                    ->where('category_id', '=', $CATEGORY_ID) 
                                    ->where('section_id', '=', $SECTION_ID)
                                    ->whereBetween("created_at", [$start_date, $end_date])
                                    ->where('has_subtransactions', '=', '0')
                                    ->get(); 

                $GET_SUBTRANSACTIONS_FROM_SECTION = DB::table('mybudget_item')
                                                        ->select('id')
                                                        ->selectRaw('SUM(REPLACE(price, ",", "")) as sum_price')
                                                        ->whereNull('deleted_at')
                                                        ->where('category_id', '=', $CATEGORY_ID) 
                                                        ->where('section_id', '=', $SECTION_ID)
                                                        ->whereBetween("created_at", [$start_date, $end_date])
                                                        ->where('has_subtransactions', '=', '1')
                                                        ->get();  
                
                
                 $GET_SUBTRANSACTIONS_FROM_SECTION = DB::table('mybudget_item')
                                            ->select("*")
                                            ->whereNull('deleted_at')
                                            ->where('category_id', '=', $CATEGORY_ID)
                                            ->where('section_id', '=', $SECTION_ID)
                                            ->whereBetween("created_at", [$start_date, $end_date])
                                            ->where('has_subtransactions', '=', '1')
                                            ->get();

                for ($ii = 0; $ii < count($GET_ITEMS_FROM_SECTION); $ii++) {
                    //echo "$ii. $i CN: " . $CATEGORY_NAME . "<br>";
                    //echo "$ii. $i SN: " . $SECTION_NAME . "<br>";
                    $SECTION_SUM["$CATEGORY_NAME"]["$SECTION_NAME"] += $GET_ITEMS_FROM_SECTION[$ii]->sum_price;
                }

                for ($iii = 0; $iii < count($GET_SUBTRANSACTIONS_FROM_SECTION); $iii++) {

                    $TRANSACTION_ID = $GET_SUBTRANSACTIONS_FROM_SECTION[$iii]->id;

                    $GET_SUBTRANSACTIONS_FROM_ITEM = DB::table('mybudget_subtransactions')
                                                        ->join('mybudget_section', 'mybudget_subtransactions.section_id', '=', 'mybudget_section.id')
                                                        ->select('mybudget_section.name as section_name')
                                                        ->selectRaw('SUM(REPLACE(price, ",", "")) as sum_price')
                                                        ->where("transaction_id", $TRANSACTION_ID)
                                                        ->where("section_id", $SECTION_ID)
                                                        ->groupBy('section_name')
                                                        ->get();

                    for ($iv = 0; $iv < count($GET_SUBTRANSACTIONS_FROM_ITEM); $iv++) {
                        $SUBTRANSACTION_NAME = $GET_SUBTRANSACTIONS_FROM_ITEM[$iv]->section_name;
                        $SUBTRANSACTION_PRICE = $GET_SUBTRANSACTIONS_FROM_ITEM[$iv]->sum_price;

                        $SECTION_SUM["$CATEGORY_NAME"]["$SECTION_NAME"] += $GET_SUBTRANSACTIONS_FROM_ITEM[$iv]->sum_price;
                    }
                }
            }
        }

        return $SECTION_SUM;
        

        $GET_SECTIONS_FROM_CATEGORY = DB::table('mybudget_section')
                                        ->select('id', 'name', 'category_id')
                                        ->where('category_id', $id)
                                        ->get();
        
        // Returns the SUM of a section's items, if they have no subtransactions.
        $GET_ITEMS_FROM_SECTION = DB::table('mybudget_item')
                                    ->selectRaw('SUM(REPLACE(price, ",", "")) as sum_price')
                                    ->whereNull('deleted_at')

                                    ->where('section_id', '=', $SECTION_ID)
                                    ->whereBetween("created_at", [$start_date, $end_date])
                                    ->where('has_subtransactions', '=', '0')
                                    ->get();   



        /*
        for ($x = 0; $x < count($GET_ALL_CATEGORIES); $x++) {
            


            if($GET_ALL_CATEGORIES[$x]->id == $id) {

                for ($i = 0; $i < count($GET_SECTIONS_FROM_CATEGORY); $i++) {
                    $GET_SECTIONS_FROM_CATEGORY = DB::table('mybudget_section')
                                        ->select('id', 'name', 'category_id')
                                        ->where('category_id', $GET_ALL_CATEGORIES[$x]->id)
                                        ->get();

                    if ($GET_SECTIONS_FROM_CATEGORY[$i]->category_id == $id) {
            
                        $SECTION_ID = $GET_SECTIONS_FROM_CATEGORY[$i]->id;
                        $SECTION_NAME = $GET_SECTIONS_FROM_CATEGORY[$i]->name;
                    
                    }

                    $GET_ITEMS_FROM_SECTION = DB::table('mybudget_item')
                                                ->selectRaw('SUM(REPLACE(price, ",", "")) as sum_price')
                                                ->whereNull('deleted_at')

                                                ->where('section_id', '=', $SECTION_ID)
                                                ->whereBetween("created_at", [$start_date, $end_date])
                                                ->where('has_subtransactions', '=', '0')
                                                ->get();       
                                                
                    for ($ii = 0; $ii < count($GET_ITEMS_FROM_SECTION); $ii++) {
                        $SECTION_SUM[$GET_ALL_CATEGORIES[$x]->id][$SECTION_NAME] += $GET_ITEMS_FROM_SECTION[$ii]->sum_price;
                    }
                }
            }

            
        }
        */


        /*

        for ($x = 0; $x < count($GET_ALL_CATEGORIES); $x++) {

            for ($i = 0; $i < count($GET_ALL_CATEGORIES[$x]); $i++) {
                //array_push($section_list, $GET_SECTIONS_FROM_CATEGORY[$i]);
                
                $SECTION_SUM[$GET_ALL_CATEGORIES[$x]][$SECTION_NAME] = 0;
            }
        }
        */

        /*
        for ($x = 0; $x < count($GET_ALL_CATEGORIES); $x++) {

            for ($i = 0; $i < count($GET_SECTIONS_FROM_CATEGORY); $i++) {
                //array_push($section_list, $GET_SECTIONS_FROM_CATEGORY[$i]);
                
                
                $SECTION_ID = $GET_SECTIONS_FROM_CATEGORY[$i]->id;
                $SECTION_NAME = $GET_SECTIONS_FROM_CATEGORY[$i]->name;

                $GET_ITEMS_FROM_SECTION = DB::table('mybudget_item')
                ->selectRaw('SUM(REPLACE(price, ",", "")) as sum_price')
                ->whereNull('deleted_at')

                ->where('section_id', '=', $SECTION_ID)
                ->whereBetween("created_at", [$start_date, $end_date])
                ->where('has_subtransactions', '=', '0')
                ->get();
                
                for ($ii = 0; $ii < count($GET_ITEMS_FROM_SECTION); $ii++) {
                    
                    if ($GET_ITEMS_FROM_SECTION[$ii]->sum_price != 0 && $SECTION_SUM[$GET_ALL_CATEGORIES[$x]->id] == $x) {
                        $SECTION_SUM[$GET_ALL_CATEGORIES[$x]->id][$SECTION_NAME] += $GET_ITEMS_FROM_SECTION[$ii]->sum_price;
                    }
    
                }
                
                /*
                if($GET_SECTIONS_FROM_CATEGORY[$i]->category_id == $GET_ALL_CATEGORIES[$x]->id) {

                    
                    $SECTION_SUM[$GET_ALL_CATEGORIES[$x]->id][$SECTION_NAME] += 0;

                    
                } else {

                }
         
            }              
                
        }
        */
            
        /*
        $GET_ITEMS_FROM_SECTION = DB::table('mybudget_item')
                                            ->selectRaw('SUM(REPLACE(price, ",", "")) as sum_price')
                                            ->whereNull('deleted_at')
                                            ->where('category_id', '=', $CATEGORY_SELECTED)
                                            ->where('section_id', '=', $SECTION_ID)
                                            ->whereBetween("created_at", [$start_date, $end_date])
                                            ->where('has_subtransactions', '=', '0')
                                            ->get();

                                            
            $GET_ITEMS_WITH_SUBTRANSACTIONS = DB::table('mybudget_item')
                ->select("*")
                ->whereNull('deleted_at')
                ->where('category_id', '=', $CATEGORY_SELECTED)
                ->where('section_id', '=', $SECTION_ID)
                ->whereBetween("created_at", [$start_date, $end_date])
                ->where('has_subtransactions', '=', '1')
                ->get();
        */


        //return $SECTION_SUM;
        
        /*
        for ($x = 0; $x < count($GET_ALL_CATEGORIES); $x++) {


                

                for ($i = 0; $i < count($GET_SECTIONS_FROM_CATEGORY); $i++) {
                    //array_push($section_list, $GET_SECTIONS_FROM_CATEGORY[$i]);
                    
                    $SECTION_ID = $GET_SECTIONS_FROM_CATEGORY[$i]->id;
                    $SECTION_NAME = $GET_SECTIONS_FROM_CATEGORY[$i]->name;
                    
                    $GET_ITEMS_FROM_SECTION = DB::table('mybudget_item')
                                            ->selectRaw('SUM(REPLACE(price, ",", "")) as sum_price')
                                            ->whereNull('deleted_at')
                                            ->where('category_id', '=', $SECTION_SUM[$GET_ALL_CATEGORIES[$x]->id])
                                            ->where('section_id', '=', $SECTION_ID)
                                            ->whereBetween("created_at", [$start_date, $end_date])
                                            ->where('has_subtransactions', '=', '0')
                                            ->get();
    
                    $GET_ITEMS_WITH_SUBTRANSACTIONS = DB::table('mybudget_item')
                                            ->select("*")
                                            ->whereNull('deleted_at')
                                            ->where('category_id', '=', $SECTION_SUM[$GET_ALL_CATEGORIES[$x]->id])
                                            ->where('section_id', '=', $SECTION_ID)
                                            ->whereBetween("created_at", [$start_date, $end_date])
                                            ->where('has_subtransactions', '=', '1')
                                            ->get();

                    if($GET_SECTIONS_FROM_CATEGORY[$i]->category_id == $GET_ALL_CATEGORIES[$x]->id) {

                    } else {
    
                    }

                    for ($ii = 0; $ii < count($GET_ITEMS_FROM_SECTION); $ii++) {
                    
                        if ($GET_ITEMS_FROM_SECTION[$ii]->sum_price != 0) {
                            $SECTION_SUM[$GET_ALL_CATEGORIES[$x]->id][$SECTION_NAME] += $GET_ITEMS_FROM_SECTION[$ii]->sum_price;
                        }
        
                    }
                    
                    for ($iii = 0; $iii < count($GET_ITEMS_WITH_SUBTRANSACTIONS); $iii++) {
                        $TRANSACTION_ID = $GET_ITEMS_WITH_SUBTRANSACTIONS[$iii]->id;
        
                        $GET_SUBTRANSACTIONS_FROM_ITEM = DB::table('mybudget_subtransactions')
                                                         ->join('mybudget_section', 'mybudget_subtransactions.section_id', '=', 'mybudget_section.id')
                                                         ->select('mybudget_section.name as section_name')
                                                         ->selectRaw('SUM(REPLACE(price, ",", "")) as sum_price')
                                                         ->where("transaction_id", $TRANSACTION_ID)
                                                         ->groupBy('section_name')
                                                         ->get();
        
                        for ($iv = 0; $iv < count($GET_SUBTRANSACTIONS_FROM_ITEM); $iv++) {
                            $SUBTRANSACTION_NAME = $GET_SUBTRANSACTIONS_FROM_ITEM[$iv]->section_name;
                            $SUBTRANSACTION_PRICE = $GET_SUBTRANSACTIONS_FROM_ITEM[$iv]->sum_price;
                            
                            /*
                            if(array_key_exists("$SUBTRANSACTION_NAME", $SECTION_SUM[$x])) {
                                $SECTION_SUM[$GET_ALL_CATEGORIES[$x]->id][$SECTION_NAME] += $SUBTRANSACTION_PRICE;
                            } else {
                                $SECTION_SUM[$GET_ALL_CATEGORIES[$x]->id][$SECTION_NAME] = 0;
                                $SECTION_SUM[$GET_ALL_CATEGORIES[$x]->id][$SECTION_NAME] += $SUBTRANSACTION_PRICE;
                            }
 
                        }
                    }
        
                }

                                    
               
                
    
                if ($i == count($GET_SECTIONS_FROM_CATEGORY)-1) {
                    array_push($section_list, $GET_ITEMS_FROM_SECTION);
                }
    
            }

            */
    
    
            return $SECTION_SUM;
    
            $ALL_CATEGORIES = mybudget_category::all();
    
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
    
            $GET_CATEGORY_DETAILS = mybudget_category::find($id);
    
            if ($id = 'ALL') {
            return view('mybudget/mybudget_statistics')->with('categories', $ALL_CATEGORIES)
                                                    ->with('sections', $SECTION_SUM)
                                                    ->with('category_selected', $ALL_CATEGORIES)
                                                    ->with('start_date', $start_date)
                                                    ->with('end_date', $end_date)
                                                    ->with('id', $id)
                                                    ->with('transactions', $TRANSACTIONS_SELECT);
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
