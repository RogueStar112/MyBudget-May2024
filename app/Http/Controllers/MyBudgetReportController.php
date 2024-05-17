<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\mybudget_category;
use App\Models\mybudget_item;

class MyBudgetReportController extends Controller
{
    public function index_report() {

       return view('mybudget/mybudget_report');

    }

    public function generate_report($start_date, $end_date) {
        
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

        return view('mybudget/mybudget_report')->with('transactions', $TRANSACTIONS_SELECT);
        
    }
}
