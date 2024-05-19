<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MyBudgetCompareController extends Controller
{
    
    public function compare_selection_screen() {
        return view('mybudget/mybudget_comparetransactions');
    }

    public function compare_two_dates($start_date_a, $end_date_a, $start_date_b, $end_date_b) {
        $insert_userid = Auth::id();


        $TRANSACTION_SUMMARY_ALPHA = DB::table('mybudget_item')
                                        ->join('mybudget_category', 'mybudget_item.category_id', '=', 'mybudget_category.id')
                                        ->join('mybudget_section', 'mybudget_item.section_id', '=', 'mybudget_section.id')
                                        ->select('mybudget_category.name as category_name')
                                        ->selectRaw('SUM(REPLACE(price, ",", "")) as sum_price')
                                        ->whereNull('mybudget_item.deleted_at')
                                        ->whereBetween("mybudget_item.created_at", [$start_date_a, $end_date_a])
                                        ->where('mybudget_item.user_id', "=", "$insert_userid")
     
                                        //->where('has_subtransactions', '=', '0')
                                        ->groupBy("category_name")
                                        ->orderBy("sum_price", "desc")
                                        ->get();   


        //$TRANSACTION_SUMMARY_BRAVO = DB::table('mybudget_item');
        
        $BRAVO_LIST = [];

        // Get ALL 
        for ($x = 0; $x < count($TRANSACTION_SUMMARY_ALPHA); $x++) {
            $BRAVO_LIST[$TRANSACTION_SUMMARY_ALPHA[$x]->category_name] = 0;
        }
        
        foreach ($BRAVO_LIST as $key => $val) {
        //foreach ($x = 0; $x < count($BRAVO_LIST); $x++) {

            $TRANSACTION_SUMMARY_BRAVO = DB::table('mybudget_item')
                                        ->join('mybudget_category', 'mybudget_item.category_id', '=', 'mybudget_category.id')
                                        ->join('mybudget_section', 'mybudget_item.section_id', '=', 'mybudget_section.id')
                                        ->select('mybudget_category.name as category_name')
                                        ->selectRaw('SUM(REPLACE(price, ",", "")) as sum_price')
                                        ->whereNull('mybudget_item.deleted_at')
                                        ->where('mybudget_item.user_id', "=", "$insert_userid")
                                        ->whereBetween("mybudget_item.created_at", [$start_date_b, $end_date_b])
                                        ->where('mybudget_category.name', '=', "$key")
                                        ->groupBy("category_name")
                                        ->orderBy("sum_price", "desc")
                                        ->get();   

            for ($i = 0; $i < count($TRANSACTION_SUMMARY_BRAVO); $i++) {
                
                $BRAVO_LIST[$key] += $TRANSACTION_SUMMARY_BRAVO[$i]->sum_price;


            }

        }

        
        $ALPHA_LIST_CALCULATIONS = [];

        $BRAVO_LIST_CALCULATIONS = [];

        for ($x = 0; $x < count($TRANSACTION_SUMMARY_ALPHA); $x++) {
            $ALPHA_LIST_CALCULATIONS[$TRANSACTION_SUMMARY_ALPHA[$x]->category_name] = (float)$TRANSACTION_SUMMARY_ALPHA[$x]->sum_price;
        }


        foreach($BRAVO_LIST as $key => $value) {
            $BRAVO_LIST_CALCULATIONS[$key] = $value;
        }

        //return $ALPHA_LIST_CALCULATIONS;

        //return $BRAVO_LIST_CALCULATIONS;

        $ALPHA_LIST_CALCULATIONS_ii = [];

        $BRAVO_LIST_CALCULATIONS_ii = [];

        $COUNT_ALPHA = count($ALPHA_LIST_CALCULATIONS);
        $COUNT_BRAVO = count($BRAVO_LIST_CALCULATIONS);

        for ($x = 0; $x < count($ALPHA_LIST_CALCULATIONS); $x++) {

            if ($BRAVO_LIST_CALCULATIONS[$TRANSACTION_SUMMARY_ALPHA[$x]->category_name] == 0) {
                $ALPHA_LIST_CALCULATIONS_ii[$TRANSACTION_SUMMARY_ALPHA[$x]->category_name] = 0;
            } else {
                $ALPHA_LIST_CALCULATIONS_ii[$TRANSACTION_SUMMARY_ALPHA[$x]->category_name] = ((float)$TRANSACTION_SUMMARY_ALPHA[$x]->sum_price / ($BRAVO_LIST_CALCULATIONS[$TRANSACTION_SUMMARY_ALPHA[$x]->category_name]+(float)$TRANSACTION_SUMMARY_ALPHA[$x]->sum_price));

                $BRAVO_LIST_CALCULATIONS_ii[$TRANSACTION_SUMMARY_ALPHA[$x]->category_name] = 1 - ((float)$TRANSACTION_SUMMARY_ALPHA[$x]->sum_price / ($BRAVO_LIST_CALCULATIONS[$TRANSACTION_SUMMARY_ALPHA[$x]->category_name]+(float)$TRANSACTION_SUMMARY_ALPHA[$x]->sum_price));
            }
            
            
        }
        
        //return $ALPHA_LIST_CALCULATIONS_ii;
        //return $BRAVO_LIST_CALCULATIONS_ii;


        /*
        foreach($ALPHA_LIST_CALCULATIONS as $key_alpha => $value_alpha) {
            
        }
        */

        
        /*
        foreach($ALPHA_LIST_CALCULATIONS as $key_alpha => $value_alpha) {
            $ALPHA_LIST_CALCULATIONS_ii = $value_alpha;
        }
        */

        /*
        foreach($ALPHA_LIST_CALCULATIONS as $key_alpha => $value_alpha) {
            foreach($BRAVO_LIST_CALCULATIONS as $key_bravo => $value_bravo) {
                if ($BRAVO_LIST_CALCULATIONS[$key_bravo] == 0) {
                 $ALPHA_LIST_CALCULATIONS[$key_alpha] = 0;
                } else {

                 $alpha_bravo_sum = $value_alpha + $value_bravo;

                 //$ALPHA_LIST_CALCULATIONS[$key_alpha] = (float)number_format(($value_alpha / $BRAVO_LIST_CALCULATIONS[$key_bravo]+$value_alpha) * 100, 2);
                 $ALPHA_LIST_CALCULATIONS_ii[$key_alpha] = (float)number_format(($value_alpha / $alpha_bravo_sum) * 100, 2);
                 
                 $BRAVO_LIST_CALCULATIONS_ii[$key_bravo] = (float)number_format(($value_bravo / $alpha_bravo_sum) * 100, 2);
                }
            }
        }
        */

        //return $BRAVO_LIST_CALCULATIONS_ii;

        //return $BRAVO_LIST_CALCULATIONS;

        //return $TRANSACTION_SUMMARY_ALPHA;
        
        //return $BRAVO_LIST;

        return view('mybudget/mybudget_comparetransactions')->with('start_date_a', $start_date_a)
                                                            ->with('end_date_a', $end_date_a)
                                                            ->with('start_date_b', $start_date_b)
                                                            ->with('end_date_b', $end_date_b)
                                                            ->with('alpha_list', $TRANSACTION_SUMMARY_ALPHA)
                                                            ->with('alpha_list_perc', $ALPHA_LIST_CALCULATIONS_ii)
                                                            ->with('bravo_list', $BRAVO_LIST)
                                                            ->with('bravo_list_perc', $BRAVO_LIST_CALCULATIONS_ii);






    }


}
