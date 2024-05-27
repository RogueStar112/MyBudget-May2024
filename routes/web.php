<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

use App\Http\Controllers\LoginController;

use App\Http\Controllers\MyBudgetController;
use App\Http\Controllers\MyBudgetCategoryController;
use App\Http\Controllers\MyBudgetSetBudgetController;
use App\Http\Controllers\MyBudgetStatisticsController;
use App\Http\Controllers\MyBudgetSourceController;

use App\Http\Controllers\MyBudgetCompareController;

use App\Http\Controllers\MyBudgetReportController;

use App\Http\Controllers\PdfController;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

use App\Models\mybudget_category;
use App\Models\mybudget_item;
use App\Models\mybudget_section;


use App\Http\Controllers\MyJournalController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

route::resource('/budgeting-app/app/', MyBudgetController::class);

route::resource('/budgeting-app/app/categories/', MyBudgetCategoryController::class);

Route::get('/', function () {
    return view('welcome')->with('brandName', 'MyLifeline')
                          ->with('brandColor', 'orange');
});

Route::get('/greeting', function () {
    return 'Hello World';
});



// MY NUTRITION //

Route::get('/nutrition-app', function () {
    return view('mynutrition/nutritionapp');
});

// MY JOURNAL //

Route::middleware(['auth:sanctum', 'verified'])->group(function () {

    Route::get('/budgeting-app', function () {
    return view('mybudget/budgetingapp')->with('brandName', 'MyBudget');
});

Route::get('/budgeting-app/app/categories/create', function () {
    
    $insert_userid = Auth::id();

    $categories = DB::table('mybudget_category')
    ->select('mybudget_category.*')
    ->where('user_id', $insert_userid)
    ->get();

    $sections = DB::table('mybudget_section')
    ->select('mybudget_section.*')
    ->where('user_id', $insert_userid)
    ->get();

    return view('mybudget/mybudget_createcategory')->with('categories', $categories)
                                                   ->with('sections', $sections);
});

Route::get('/budgeting-app/app/search/{column}/{criteria}', [MyBudgetController::class, 'search_results']);

Route::get('/budgeting-app/app/categories/{id}', [MyBudgetCategoryController::class, 'show']);

Route::put('/budgeting-app/app/categories/{id}', [MyBudgetCategoryController::class, 'update']);

Route::post('/budgeting-app/app/subcategories/add/{id}', [MyBudgetCategoryController::class, 'add_subcategory']);

Route::put('/budgeting-app/app/subcategories/edit/{id}', [MyBudgetCategoryController::class, 'edit_subcategory']);


// Get Transactions for View Mode
Route::get('/budgeting-app/app/create', function () {
    $insert_userid = Auth::id();
    $mybudget_item_join = DB::table('mybudget_item')
                        ->join('mybudget_category', 'mybudget_item.category_id', '=', 'mybudget_category.id')
                        ->join('mybudget_section', 'mybudget_item.section_id', '=', 'mybudget_section.id')
                        ->join('mybudget_source', 'mybudget_item.source_id', '=', 'mybudget_source.id')
                        ->select('mybudget_item.*', "mybudget_item.price as price", 'mybudget_category.name as category_name', 'mybudget_section.name as section_name', 'mybudget_source.name as source_name', 'mybudget_category.color_bg as color_bg', 'mybudget_category.color_text as color_text', 'mybudget_category.icon_code as icon_code')
                        //->selectRaw('PRINTF("%.2f", mybudget_item.price) as price_twodp')
                        ->where('mybudget_item.user_id', '=', $insert_userid)
                        ->orderBy('mybudget_item.id', 'desc')
                        //->limit(25)
                        ->paginate(30);
                        //->get();

    // $categories = mybudget_category::all();

    $insert_userid = Auth::id();

    $categories = DB::table('mybudget_category')
    ->join('mybudget_section', 'mybudget_category.id', '=', 'mybudget_section.category_id')
    ->select('mybudget_category.id as category_id', 'mybudget_category.name as category_name', 'mybudget_section.id as section_id', 'mybudget_section.name as section_name')
    ->orderBy('mybudget_category.name')
    ->orderBy('mybudget_section.name')
    ->where('mybudget_category.user_id', '=', $insert_userid)
    ->get();


    $groupedData = $categories->groupBy('category_id');

    // return compact($groupedData);
    // return $category_check;
                    
    return view('mybudget/mybudget_createtransaction')->with('transactions', $mybudget_item_join)
                                                      ->with('categories', $categories)
                                                      ->with('groupedData', compact('groupedData'));
});                                                  


// View Subtransaction Form - NEW! - 10/04/2022

Route::get('/budgeting-app/app/view/subtransactions', [MyBudgetController::class, 'subtransaction_view']);

// Create Subtransaction Form

Route::get('/budgeting-app/app/create/subtransaction/{id}', [MyBudgetController::class, 'subtransaction_form']);

// Create Actual Subtransactions

Route::post('/budgeting-app/app/create/subtransaction/{id}/success', [MyBudgetController::class, 'store_subtransactions']);


// Filter Transactions For View Mode

Route::get('/budgeting-app/app/create/{column_select}/{column_search}', [MyBudgetController::class, 'column_search']);


// Edit Single Transaction by its ID
Route::get('/budgeting-app/app/transactions/edit/{id}', [MyBudgetController::class, 'edit_form']);

Route::put('/budgeting-app/app/transactions/edit/{id}', [MyBudgetController::class, 'edit']);

// Delete Single Transaction by its ID - FORM!
Route::get('/budgeting-app/app/transactions/delete/{id}', [MyBudgetController::class, 'delete_form']);

Route::get('/budgeting-app/app/transactions/delete_undo/{id}', [MyBudgetController::class, 'undo_delete_form']);

Route::put('/budgeting-app/app/transactions/delete_undo/{id}', [MyBudgetController::class, 'undo_delete']);

//Route::get('/budgeting-app/app/transactions/get_subcategories/{id}', [MyBudgetSetBudgetController::class, 'get_subcategories']);



Route::delete('/budgeting-app/app/transactions/destroy/{id}', [MyBudgetController::class, 'destroy']);

// Show transaction by its ID
Route::get('/budgeting-app/app/transactions/show/{id}', [MyBudgetController::class, 'show']);

Route::get('/budgeting-app/app/transactions/show/{section}/{start_date}/{end_date}', [MyBudgetController::class, 'show_date_range']);

//

/*
Route::get('/budgeting-app/app/create/success', function () {
    return view('mybudget/mybudget_createtransaction_success');
});

*/

// Budgeting App - Set Budget

//Route::get('/budgeting-app/app/budget', [MyBudgetSetBudgetController::class, 'setbudget_form']);
Route::get('/budgeting-app/app/budget', [MyBudgetSetBudgetController::class, 'get_date_ranges']);

Route::get('/budgeting-app/app/budget/{start_date}/{end_date}', [MyBudgetSetBudgetController::class, 'get_date_ranges_render']);

Route::get('/budgeting-app/app/getsubcategories/{id}', [MyBudgetSetBudgetController::class, 'get_subcategories']);

Route::get('/budgeting-app/app/getsubcategories_edit/{id}', [MyBudgetSetBudgetController::class, 'get_subcategories_edit']);

Route::post('/budgeting-app/app/budget', [MyBudgetSetBudgetController::class, 'post_setbudget']);

Route::get('/budgeting-app/app/budget/viewv2/{start_date}/{end_date}', [MyBudgetSetBudgetController::class, 'get_date_range_budgets_v2']);

Route::get('/budgeting-app/app/budget/view/{start_date}/{end_date}', [MyBudgetSetBudgetController::class, 'get_date_range_budgets']);

/*
Route::get('/budgeting-app/app/budget', function () {
    return view('mybudget/mybudget_setbudget')->with([MyBudgetSetBudgetController::class, 'setbudget_form']);
});
*/
Route::get('/budgeting-app/app/budget/history', [MyBudgetSetBudgetController::class, 'view_budget_history']);

Route::get('/budgeting-app/app/budget/spending_history', [MyBudgetSetBudgetController::class, 'view_budget_history_renderspending']);

Route::get('/budgeting-app/app/budget/budget_history', [MyBudgetSetBudgetController::class, 'view_budget_history_renderbudgets']);

Route::get('/budgeting-app/app/budget/budget_history_percentages', [MyBudgetSetBudgetController::class, 'view_budget_history_renderpercentages']);


//Route::get('/budgeting-app/app/budget/history/{start_date}/{end_date}', [MyBudgetSetBudgetController::class, 'view_budget_history']);

//Route::view('/budgeting-app/app/budget', 'setbudget', [MyBudgetSetBudgetController::class, 'setbudget_form']);

Route::get('/budgeting-app/app/view/section', [MyBudgetCategoryController::class, 'view_sections']);

Route::get('/budgeting-app/app/view/section/{section_id}', [MyBudgetCategoryController::class, 'view_section']);


/*
Route::get('/budgeting-app/app/sources', function () {

    return view('mybudget/mybudget_sources')->with([MyBudgetController::class, 'subtransaction_form']);
});
*/

Route::get('/budgeting-app/app/view/sources', [MyBudgetSourceController::class, 'show_all_sources']);

Route::get('/budgeting-app/app/view/sources/{source_id}', [MyBudgetSourceController::class, 'show_source']);

Route::get('/budgeting-app/app/view/sources/{start_date}/{end_date}', [MyBudgetSourceController::class, 'show']);

Route::get('/budgeting-app/app/statistics', function () {
    $insert_userid = Auth::id();

    $categories = DB::table('mybudget_category')
    ->join('mybudget_section', 'mybudget_category.id', '=', 'mybudget_section.category_id')
    ->select('mybudget_category.id as category_id', 'mybudget_category.name as category_name', 'mybudget_section.id as section_id', 'mybudget_section.name as section_name')
    ->orderBy('mybudget_category.name')
    ->orderBy('mybudget_section.name')
    ->where('mybudget_category.user_id', '=', $insert_userid)
    ->get();

    return view('mybudget/mybudget_statistics')->with('categories', $categories);
});

Route::get('/budgeting-app/app/statistics/{id}/{start_date}/{end_date}', [MyBudgetStatisticsController::class, 'show']);

Route::get('/budgeting-app/app/compare', [MyBudgetCompareController::class, 'compare_selection_screen']);

Route::get('/budgeting-app/app/compare/{start_date_a}/{end_date_a}/{start_date_b}/{end_date_b}', [MyBudgetCompareController::class, 'compare_two_dates']);

Route::get('/budgeting-app/app/reports', [MyBudgetReportController::class, 'index_report']);

Route::get('/budgeting-app/app/reports/generate/{start_date}/{end_date}', [PdfController::class, 'index']);

Route::get('/budgeting-app/app/items/history', [MyBudgetController::class, 'item_history_index']);

Route::get('/budgeting-app/app/items/history/{name}', [MyBudgetController::class, 'item_history_search']);

    Route::get('/journalling-app', function () {
        return view('myjournal/journallingapp')->with('userName', Auth::user()->name);
    });
    
    Route::get('/journalling-app/entries', [MyJournalController::class, 'entries_page']);

    Route::get('/journalling-app/entries/view', [MyJournalController::class, 'entries_view']);

    Route::post('/journalling-app/entries/', [MyJournalController::class, 'entries_store']);

    Route::get('/journalling-app/ratings', [MyJournalController::class, 'ratings_page']);
    
    // EDIT ENTRY    
    Route::get('/journalling-app/entries/edit/{user_id}/{id}', [MyJournalController::class, 'edit_entry_form']);
    Route::put('/journalling-app/entries/edit/{user_id}/{id}', [MyBudgetController::class, 'edit_entry']);

    // DELETE ENTRY
    Route::get('/journalling-app/entries/delete/{user_id}/{id}', [MyJournalController::class, 'delete_entry_form']);
    Route::delete('/journalling-app/entries/delete/{user_id}/{id}', [MyJournalController::class, 'delete_entry']);

    
    // RENDER VIEWS (Views that are not full pages, but are rendered as part of a page.)
    Route::get('/journalling-app/entries/select/{array}', [MyJournalController::class, 'entries_select_array']);

});

// MY REVIEW //

Route::get('/reviewing-app', function () {
    return view('myreviews/reviewingapp');
});

/*
Route::get('/{any?}', [
    function () {
        return view('welcome');
    }
])->where('any', '.*');
*/
Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('mybudget/budgetingapp')->with('brandName', 'MyBudget')
                                        ->with('userName', Auth::user()->name);

})->name('dashboard');

// https://websitelink/api/migrate

// Route::get('/migrate', function () {
//     Artisan::call('migrate', ["--force" => true]);
//     return response()->json(['message' => 'Migrations run successfully'], 200);
// });

// Route::get('/rollback-migrations', function () {
//     try {
//         Artisan::call('migrate:rollback', ['--force' => true]);
//         return response()->json([
//             'status' => 'success',
//             'message' => Artisan::output(),
//         ]);
//     } catch (\Exception $e) {
//         return response()->json([
//             'status' => 'error',
//             'message' => $e->getMessage(),
//         ], 500);
//     }
// });

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('logout');

