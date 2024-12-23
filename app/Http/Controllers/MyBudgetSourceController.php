<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\MyBudgetCategory;
use App\Models\MyBudgetItem;
use App\Models\MyBudgetSource;

use Illuminate\Support\Facades\Auth;

class MyBudgetSourceController extends Controller
{
    public function show_all_sources() {
        $insert_userid = Auth::id();

        $GET_ALL_CATEGORIES = DB::table('mybudget_category')
                                ->select('mybudget_category.*')
                                ->where('user_id', "=", "$insert_userid")
                                ->get();

        // $ALL_CATEGORIES = mybudget_category::all();

        // return $ALL_CATEGORIES;

        // return $GET_ALL_CATEGORIES;

  
        return view('mybudget/mybudget_viewsource')->with('all_categories_selected', $GET_ALL_CATEGORIES);

    }

    public function show_source($source_id) {

        $insert_userid = Auth::id();
        
        $GET_ITEMS_WITH_SOURCE = DB::table('mybudget_item')
                                    ->join('mybudget_section', 'mybudget_item.section_id', '=', 'mybudget_section.id')
                                    ->join('mybudget_source', 'mybudget_item.source_id', '=', 'mybudget_source.id')
                                    ->select('mybudget_item.*', 'mybudget_section.name as section_name', 'mybudget_source.name as source_name')
                                    ->where('mybudget_item.source_id', '=', $source_id)
                                    ->where('mybudget_item.user_id', "=", "$insert_userid")
                                    ->groupBy('mybudget_item.id', 'mybudget_source.name', 'section_name')
                                    ->orderBy('section_name', 'asc')
                                    ->get();
  
        return view('mybudget/mybudget_viewsource')->with('source_selected', $GET_ITEMS_WITH_SOURCE);

    }

    public function show($start_date, $end_date) {
    $insert_userid = Auth::id();
    // Add start and end date times for datetime compatibility
    $start_date .= " 00:00:00";
    $end_date .= " 23:59:59";

    $GET_SOURCE_SUM = DB::table('mybudget_source')
        ->join('mybudget_item', 'mybudget_source.id', '=', 'mybudget_item.source_id')
        ->select('mybudget_source.name as source_name')
        // ->selectRaw("SUM(REPLACE(mybudget_item.price, ',', '')) as sum_price")
        ->where('mybudget_item.user_id', "=", "$insert_userid")
        ->whereBetween("mybudget_item.created_at", [$start_date, $end_date])
        ->whereNull('mybudget_item.deleted_at')
        ->groupBy('mybudget_item.id', 'mybudget_source.name', 'section_name')
        ->orderBy("mybudget_item.price", "desc")
        ->get();

    return view('mybudget/mybudget_sources')->with('sources', $GET_SOURCE_SUM);
    }


}
