<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\mybudget_category;
use App\Models\mybudget_item;
use App\Models\mybudget_sectionbudget;
use App\Models\mybudget_section;

use Carbon\Carbon;

use DateTime, DateInterval, DatePeriod;

use Illuminate\Support\Facades\Auth;

class MyBudgetSetBudgetController extends Controller
{
    public function setbudget_form()
    {
        /*
        $TRANSACTIONS_SELECT = DB::table('mybudget_section')
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
        */
        $categories = mybudget_category::all();

        return view('mybudget/mybudget_setbudget')->with('categories', $categories);
    }

    public function post_setbudget(Request $request)
    {
        //$TEMP_DELETE = DB::table('mybudget_sectionbudget')->where('id', '>=', '18')->delete();
        $insert_userid = Auth::id();

        $start_date = $request->input('setbudget_date_start');
        $end_date = $request->input('setbudget_date_end');

        /*
        $sectionbudget = mybudget_sectionbudget::updateOrCreate(
            ['date_start' => $date_start, 'date_end' => $date_end, 'category_id' => $category, 'section_id' => $subcategory],
            ['budget' => $amount]
        );
        */


        $headers_array = explode(",", $request->input('setbudget-pages'));
        
        //return $request->all();
        //return $request->input("input-budget-25");

        for ($i = 0; $i < count($headers_array); $i++) {
            $header_value = $headers_array[$i]; 

            $SELECT_SECTION = mybudget_section::find($header_value);

            $header_cost = $request->input("input-budget-$header_value");

            if($header_cost == NULL) {
                              
            } else {
                $sectionbudget = mybudget_sectionbudget::updateOrCreate(
                    ['user_id' => $insert_userid, 'date_start' => $start_date, 'date_end' => $end_date, 'category_id' => (int)$SELECT_SECTION->category_id, 'section_id' => (int)$header_value],
                    ['budget' => (float)$header_cost]
                );    
            }

        }
        $ALL_CATEGORIES = mybudget_category::all();

        //return $request->all();

        return view('mybudget/mybudget_setbudget')->with('start_date', $start_date)
                                                  ->with('end_date', $end_date)
                                                  ->with('all_categories_selected', $ALL_CATEGORIES);


                                                  

    }
    

    public function get_date_ranges(){
    
        $categories = mybudget_category::all();

        $GET_SIMILAR_DATE_RANGES = DB::table('mybudget_sectionbudget')
                                    ->select('date_start', 'date_end')
                                    ->orderBy('date_start', 'asc')
                                    ->groupBy('date_start')
                                    ->get();

        $GET_ALL_CATEGORIES = DB::table('mybudget_category')
        ->select('id', 'name')
        ->get();

        $ALL_CATEGORIES = mybudget_category::all();

        return view('mybudget/mybudget_setbudget')->with('categories', $categories)
                                                  ->with('date_ranges', $GET_SIMILAR_DATE_RANGES)
                                                  ->with('start_date', '2022-01-01')
                                                  ->with('end_date', '2022-01-02')
                                                  ->with('all_categories_selected', $ALL_CATEGORIES);
    }

    public function get_date_ranges_render($start_date, $end_date) {

        $GET_DATE_RANGE_BUDGETS = DB::table('mybudget_sectionbudget')
                                    ->join('mybudget_category', 'mybudget_category.id', '=', 'mybudget_sectionbudget.category_id')
                                    ->join('mybudget_section', 'mybudget_section.id', '=', 'mybudget_sectionbudget.section_id')
                                    ->select(DB::raw('mybudget_sectionbudget.*,  mybudget_category.name as category_name, mybudget_section.name as section_name'))
                                    ->selectRaw("REPLACE(mybudget_sectionbudget.budget, ',', '') as section_budget")
                                    ->where("mybudget_sectionbudget.date_start", "=", [$start_date])
                                    ->where("mybudget_sectionbudget.date_end", "=", [$end_date])
                                    ->where('mybudget_sectionbudget.user_id', "=", [$insert_userid])
                                    ->orderBy('mybudget_category.name', 'asc')
                                    ->get();

        $categories = mybudget_category::all();

        $GET_SIMILAR_DATE_RANGES = DB::table('mybudget_sectionbudget')
                                    ->select('date_start', 'date_end')
                                    ->orderBy('date_start', 'asc')
                                    ->groupBy('date_start')
                                    ->get();

        $GET_ALL_CATEGORIES = DB::table('mybudget_category')
        ->select('id', 'name')
        ->get();

        $ALL_CATEGORIES = mybudget_category::all();
                                    
        return view('mybudget/partial_views/mybudget_createbudgetfromdaterange')->with('budgets', $GET_DATE_RANGE_BUDGETS)
                                                                                ->with('start_date', $start_date)
                                                                                ->with('end_date', $end_date)
                                                                                ->with('categories', $categories)
                                                                                ->with('date_ranges', $GET_SIMILAR_DATE_RANGES)
                                                                                ->with('all_categories_selected', $ALL_CATEGORIES)
                                                                                ->render();

                                                  

    }
    
    public function get_date_range_budgets($start_date, $end_date) {
        $GET_DATE_RANGE_BUDGETS = DB::table('mybudget_sectionbudget')
                                    ->join('mybudget_category', 'mybudget_category.id', '=', 'mybudget_sectionbudget.category_id')
                                    ->join('mybudget_section', 'mybudget_section.id', '=', 'mybudget_sectionbudget.section_id')
                                    ->select(DB::raw('mybudget_sectionbudget.*, mybudget_category.name as category_name, mybudget_section.name as section_name'))
                                    ->where("mybudget_sectionbudget.date_start", "=", [$start_date])
                                    ->where("mybudget_sectionbudget.date_end", "=", [$end_date])
                                    ->where('mybudget_sectionbudget.user_id', "=", [$insert_userid])
                                    ->orderBy('mybudget_category.name', 'asc')
                                    ->get();
                                    

        return view('mybudget/mybudget_viewbudget')->with('budgets', $GET_DATE_RANGE_BUDGETS)
                                                    ->with('start_date', $start_date)
                                                    ->with('end_date', $end_date);

    }

    public function get_sum_cost_within_date_range($category_id, $section_id, $start_date, $end_date) {
        $GET_ALL_CATEGORIES = DB::table('mybudget_category')
                                ->select('id', 'name')
                                ->get();

        $SECTION_SUM = [];

        for ($x = 0; $x < count($GET_ALL_CATEGORIES); $x++) {
            $SECTION_SUM[$GET_ALL_CATEGORIES[$x]->name] = [];

        }

        for ($x = 0; $x < count($GET_ALL_CATEGORIES); $x++) {

            $GET_SECTIONS_FROM_CATEGORY = DB::table('mybudget_section')
                                        ->select('id', 'name', 'category_id')
                                        ->where('category_id', $category_id)
                                        ->get();
            

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


        $GET_SUM_COST_WITHIN_DATE_RANGE = DB::table('mybudget_item')
                                            ->join('mybudget_category', 'mybudget_item.category_id', '=', 'mybudget_category.id')
                                            ->join('mybudget_section', 'mybudget_item.section_id', '=', 'mybudget_section.id')
                                            ->join('mybudget_source', 'mybudget_item.source_id', '=', 'mybudget_source.id')
                                            ->select('mybudget_category.name as category_name', 'mybudget_section.name as section_name')
                                            ->selectRaw("SUM(REPLACE(mybudget_item.price, ',', '')) as sum_price")
                                            ->where("mybudget_category.id", "=", "$category_id")
                                            ->where("mybudget_section.id", "=", "$section_id")
                                            ->where("mybudget_item.has_subtransactions", "=", 0)
                                            ->whereBetween("mybudget_item.created_at", [$start_date, $end_date])
                                            ->whereNull('deleted_at')
                                            ->groupBy('category_name', 'section_name')
                                            ->get();

        /*
        $GET_SUM_COST_WITHIN_DATE_RANGE_SUBTRANSACTIONS = DB::table('mybudget_item')
                                                            ->join('mybudget_category', 'mybudget_item.category_id', '=', 'mybudget_category.id')
                                                            ->join('mybudget_section', 'mybudget_item.section_id', '=', 'mybudget_section.id')
                                                            ->join('mybudget_source', 'mybudget_item.source_id', '=', 'mybudget_source.id')
                                                            ->select("mybudget_section.name as section_name")
                                                            ->selectRaw("SUM(REPLACE(mybudget_item.price, ',', '')) as sum_price")
                                                            ->where("mybudget_category.id", "=", "$category_id")
                                                            ->where("mybudget_section.id", "=", "$section_id")
                                                            ->where("mybudget_item.has_subtransactions", "=", 1)
                                                            ->whereBetween("mybudget_item.created_at", [$start_date, $end_date])
                                                            ->whereNull('deleted_at')
                                                            ->groupBy("section_name")
                                                            ->get();
        */

        $GET_SUBTRANSACTIONS_FROM_SECTION = DB::table('mybudget_item')
                                            ->select("*")
                                            ->whereNull('deleted_at')
                                            ->where('category_id', '=', $category_id)
                                            ->where('section_id', '=', $section_id)
                                            ->whereBetween("created_at", [$start_date, $end_date])
                                            ->where('has_subtransactions', '=', '1')
                                            ->get();

        

        for ($x = 0; $x < count($GET_ALL_CATEGORIES); $x++) {
                            
            for ($i = 0; $i < count($GET_SECTIONS_FROM_CATEGORY); $i++) {
                //array_push($section_list, $GET_SECTIONS_FROM_CATEGORY[$i]);
                
                $CATEGORY_ID = $GET_ALL_CATEGORIES[$x]->id;
                $CATEGORY_NAME = $GET_ALL_CATEGORIES[$x]->name;

                $SECTION_ID = $GET_SECTIONS_FROM_CATEGORY[$i]->id;
                $SECTION_NAME = $GET_SECTIONS_FROM_CATEGORY[$i]->name;

                $GET_ITEMS_FROM_SECTION = DB::table('mybudget_item')
                                    ->selectRaw("ROUND(REPLACE(mybudget_item.price, ',', ''), 2) as price")
                                    ->whereNull('deleted_at')

                                    ->where('category_id', '=', $CATEGORY_ID) 
                                    ->where('section_id', '=', $SECTION_ID)
                                    ->whereBetween("created_at", [$start_date, $end_date])
                                    ->where('has_subtransactions', '=', '0')
                                    ->get(); 

                for ($ii = 0; $ii < count($GET_ITEMS_FROM_SECTION); $ii++) {

                    //echo "$ii. $i CN: " . $CATEGORY_NAME . "<br>";
                    //echo "$ii. $i SN: " . $SECTION_NAME . "<br>";

                    // Category Name: Groceries
                    // Section Name: Frozen Food
                    // $SECTION_SUM['Groceries']['Frozen Food'] += $GET_ITEMS_FROM_SECTION[$ii]->price;
                    $SECTION_SUM["$CATEGORY_NAME"]["$SECTION_NAME"] += $GET_ITEMS_FROM_SECTION[$ii]->price;
                }
            }
        }

        /*
        for ($iii = 0; $iii < count($GET_SUBTRANSACTIONS_FROM_SECTION); $iii++) {

            $TRANSACTION_ID = $GET_SUBTRANSACTIONS_FROM_SECTION[$iii]->id;

            
            //$TRANSACTION_ID = 417;
            
            $GET_SUBTRANSACTIONS_FROM_ITEM = DB::table('mybudget_subtransactions')
                                                ->join('mybudget_category', 'mybudget_subtransactions.category_id', '=', 'mybudget_category.id')
                                                ->join('mybudget_section', 'mybudget_subtransactions.section_id', '=', 'mybudget_section.id')
                                                ->select('mybudget_category.name as category_name', 'mybudget_section.name as section_name')
                                                //->select('mybudget_section.name as section_name')
                                                ->selectRaw('SUM(REPLACE(price, ",", "")) as sum_price')
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
        */
        
        foreach ($GET_SUM_COST_WITHIN_DATE_RANGE as $SECTION) {
            
            //$SECTION->sum_price += $SECTION_SUM["$SECTION->category_name"]["$SECTION->section_name"];
            
        }



        return $GET_SUM_COST_WITHIN_DATE_RANGE;
    }

    public function get_date_range_budgets_v2($start_date, $end_date) {

        $GET_DATE_RANGE_BUDGETS = DB::table('mybudget_sectionbudget')
                                    ->join('mybudget_category', 'mybudget_category.id', '=', 'mybudget_sectionbudget.category_id')
                                    ->join('mybudget_section', 'mybudget_section.id', '=', 'mybudget_sectionbudget.section_id')
                                    ->select(DB::raw('mybudget_sectionbudget.*, mybudget_category.name as category_name, mybudget_section.name as section_name'))
                                    ->where("mybudget_sectionbudget.date_start", "=", [$start_date])
                                    ->where("mybudget_sectionbudget.date_end", "=", [$end_date])
                                    ->orderBy('mybudget_category.name', 'asc')
                                    ->get();

        $categories = mybudget_category::all();

        $GET_SIMILAR_DATE_RANGES = DB::table('mybudget_sectionbudget')
                                    ->select('date_start', 'date_end')
                                    ->orderBy('date_start', 'asc')
                                    ->groupBy('date_start')
                                    ->get();

        $GET_ALL_CATEGORIES = DB::table('mybudget_category')
        ->select('id', 'name')
        ->get();

        $ALL_CATEGORIES = mybudget_category::all();
                                    
        return view('mybudget/mybudget_setbudget')->with('budgets', $GET_DATE_RANGE_BUDGETS)
                                                  ->with('start_date', $start_date)
                                                  ->with('end_date', $end_date)
                                                  ->with('categories', $categories)
                                                  ->with('date_ranges', $GET_SIMILAR_DATE_RANGES)
                                                  ->with('all_categories_selected', $ALL_CATEGORIES);
                                                  

    }

    public function view_budget_history() {           

        $placeholder_start_date = Carbon::now();

        $placeholder_start_date = '2022-02-01';

        $placeholder_end_date = '2022-06-31';

        /*
        $placeholder_start_date->year(2022)->month(5)->day(22)->hour(0)->minute(0)->second(0)->toDateTimeString();

        $weeks_array = [];

        for($i=1; $i<=13; $i++) {
            array_push($weeks_array, $placeholder_start_date->addWeek($i)->toDateString());
        }

        return $weeks_array;
        */

        //credit to https://stackoverflow.com/questions/29106854/getting-all-months-between-2-dates
        $start    = (new DateTime($placeholder_start_date))->modify('first day of this month');
        $end      = (new DateTime($placeholder_end_date))->modify('first day of this month');
        $interval = DateInterval::createFromDateString('1 week');
        $period   = new DatePeriod($start, $interval, $end);
        
        $months = array();
        

        foreach ($period as $dt) {
            $months[] = $dt->format("Y-m-d");
            //$months[] = $dt->format("F j Y");
        }

        // return $months;
        //$current = Carbon::now();

        $categories = mybudget_category::all();

        $months_Carbon = new Carbon("2022-05-21");

        /*
        $GET_SUMS_OF_DATE_RANGE = DB::table('mybudget_item')
                                    ->join('mybudget_category', 'mybudget_item.category_id', '=', 'mybudget_category.id')
                                    ->join('mybudget_section', 'mybudget_item.section_id', '=', 'mybudget_section.id')
                                    ->join('mybudget_source', 'mybudget_item.source_id', '=', 'mybudget_source.id')
                                    ->select('mybudget_item.created_at')
                                    ->selectRaw("SUM(REPLACE(mybudget_item.price, ',', '')) as price_twodp")
                                    //->where('mybudget_section.name', '=', "$section_name")
                                    //->where('mybudget_section.name', '!=', 'Income')
                                    ->whereNull('deleted_at')
                                    ->whereBetween("mybudget_item.created_at", [$months_Carbon, $months_Carbon_addweek])
                                    ->groupBy('mybudget_item.created_at')
                                    ->orderBy('mybudget_item.created_at', "asc")
                                    ->get();

        return $GET_SUMS_OF_DATE_RANGE;
        */

        /*
        $GET_SUMS_OF_DATE_RANGE = DB::table('mybudget_item')
                                    ->join('mybudget_category', 'mybudget_item.category_id', '=', 'mybudget_category.id')
                                    ->join('mybudget_section', 'mybudget_item.section_id', '=', 'mybudget_section.id')
                                    ->join('mybudget_source', 'mybudget_item.source_id', '=', 'mybudget_source.id')
                                    ->select('mybudget_item.created_at')
                                    ->selectRaw("SUM(REPLACE(mybudget_item.price, ',', '')) as price_twodp")
                                    //->where('mybudget_section.name', '=', "$section_name")
                                    //->where('mybudget_section.name', '!=', 'Income')
                                    ->whereNull('deleted_at')
                                    ->whereBetween("mybudget_item.created_at", [$months_Carbon, $months_Carbon->copy()->subSecond()->addWeek(13)])
                                    ->groupBy('mybudget_item.created_at')
                                    ->orderBy('mybudget_item.created_at', "asc")
                                    ->get();


        return $GET_SUMS_OF_DATE_RANGE;
        */

        /*
        $DATERANGE_SUM = DB::table('mybudget_item')
                                    ->select('*')
                                    ->selectRaw("SUM(REPLACE(mybudget_item.price, ',', '')) as price_twodp")
                                    //->where('mybudget_section.name', '=', "$section_name")
                                    //->where('mybudget_section.name', '!=', 'Income')
                                    ->whereNull('deleted_at')
                                    ->whereBetween("mybudget_item.created_at", [$months_Carbon, $months_Carbon->copy()->subSecond()->addWeek(1)])
                                    //->groupBy('mybudget_item.created_at')
                                    //->orderBy('mybudget_item.created_at', "asc")
                                    ->sum('price_twodp');

        return $DATERANGE_SUM;
        */

        return view('mybudget/mybudget_viewbudgethistory')->with('all_categories', $categories)
                                                          ->with('month_range', $months);

        

    }

    public function view_budget_history_renderspending() {
        $categories = mybudget_category::all();

        $placeholder_start_date = '2022-02-01';

        $placeholder_end_date = '2022-06-31';

        //credit to https://stackoverflow.com/questions/29106854/getting-all-months-between-2-dates
        $start    = (new DateTime($placeholder_start_date))->modify('first day of this month');
        $end      = (new DateTime($placeholder_end_date))->modify('first day of this month');
        $interval = DateInterval::createFromDateString('1 week');
        $period   = new DatePeriod($start, $interval, $end);
        
        $months = array();
        

        foreach ($period as $dt) {
            $months[] = $dt->format("Y-m-d");
        }

        return view('mybudget/subcomponents/budgethistory_renderspending')->with('all_categories', $categories)
                                                                          ->with('month_range', $months);
    }

    public function view_budget_history_renderbudgets() {

        $categories = mybudget_category::all();

        $placeholder_start_date = '2022-02-01';

        $placeholder_end_date = '2022-06-31';

        //credit to https://stackoverflow.com/questions/29106854/getting-all-months-between-2-dates
        $start    = (new DateTime($placeholder_start_date))->modify('first day of this month');
        $end      = (new DateTime($placeholder_end_date))->modify('first day of this month');
        $interval = DateInterval::createFromDateString('1 week');
        $period   = new DatePeriod($start, $interval, $end);
        
        $months = array();
        

        foreach ($period as $dt) {
            $months[] = $dt->format("Y-m-d");
        }

        return view('mybudget/subcomponents/budgethistory_renderbudgets')->with('all_categories', $categories)
                                                                         ->with('month_range', $months);

        
    }

    public function view_budget_history_renderpercentages() {

        $categories = mybudget_category::all();

        $placeholder_start_date = '2022-02-01';

        $placeholder_end_date = '2022-06-31';

        //credit to https://stackoverflow.com/questions/29106854/getting-all-months-between-2-dates
        $start    = (new DateTime($placeholder_start_date))->modify('first day of this month');
        $end      = (new DateTime($placeholder_end_date))->modify('first day of this month');
        $interval = DateInterval::createFromDateString('1 week');
        $period   = new DatePeriod($start, $interval, $end);
        
        $months = array();
        

        foreach ($period as $dt) {
            $months[] = $dt->format("Y-m-d");
        }

        return view('mybudget/subcomponents/budgethistory_renderpercentages')->with('all_categories', $categories)
                                                                             ->with('month_range', $months);

        
    }

     public function get_subcategories($id){

        // For Subcategory Select, Filter specifically for this dropdown.

        $categories = mybudget_category::all();

        $GET_SUBCATEGORIES_BY_ID = DB::table('mybudget_section')
                                      ->select('id', 'name')
                                      ->where('category_id', $id)
                                      ->get();

        return view('mybudget/subcomponents/subcategories_select')->with('subcategories', $GET_SUBCATEGORIES_BY_ID);

    }

    public function get_subcategories_edit($id) {
        $categories = mybudget_category::all();

        $GET_SUBCATEGORIES_BY_ID = DB::table('mybudget_section')
                                      ->select('id', 'name')
                                      ->where('category_id', $id)
                                      ->get();

        return view('mybudget/subcomponents/subcategories_select_edit')->with('subcategories', $GET_SUBCATEGORIES_BY_ID);
    }

}
