<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\mybudget_category;
use App\Models\mybudget_item;

class MyBudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        return view('mybudget/mybudget_createtransaction');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        // Database Insertion 1- Insert INTO category and section AND source
        
        $insert_userid = Auth::id();

        $headers = $request->input('transaction-pages');

        $headers = explode(",", $headers);

        $headers_array = $headers;

        $names = array();
        $prices = array();
        $categories = array();
        $subcategories = array();
        $sources = array();
        $dates = array();
        $descriptions = array();

        //echo $headers_array[1];

        // Populate the above EMPTY arrays with their respective inputs
        for ($i = 0; $i < count($headers_array); $i++) {
            $header_value = $headers_array[$i];
        

            $header_name = $request->input("transaction-name-$header_value");
            
            
            $header_price = $request->input("transaction-price-$header_value");

            // if
            $header_category = $request->input("transaction-category-$header_value");
            $header_subcategory = $request->input("transaction-subcategory-$header_value");
            $header_source = $request->input("transaction-source-$header_value");
            $header_date = $request->input("transaction-date-$header_value");
            $header_description = $request->input("transaction-description-$header_value");



            
            array_push($names, $header_name);
            array_push($prices, $header_price);
            array_push($categories, $header_category);
            array_push($subcategories, $header_subcategory);
            array_push($sources, $header_source);
            array_push($dates, $header_date);
            array_push($descriptions, $header_description);
        }
        
        $data = [
            'names' => $names,
            'prices' => $prices,
            'categories' => $categories,
            'subcategories' => $subcategories,
            'sources' => $sources,
            'dates' => $dates,
            'descriptions' => $descriptions,
        ];

        for ($i = 0; $i < count($data['names']); $i++) {
            /*
            echo $data['names'][$i];
            echo "<br>";
            */


            $i_display = $i+1;
            $name = $data['names'][$i];
            $price = $data['prices'][$i];
            $category = $data['categories'][$i];
            $subcategory = $data['subcategories'][$i];
            $source = $data['sources'][$i];
            $date = $data['dates'][$i];

            // Convert the date to dd/mm/yyyy format
            $date_display = date("d/m/Y", strtotime($date));
            $description = $data['descriptions'][$i];

            $CHECK_FOR_CATEGORY = DB::select("select id from mybudget_category where name = ? AND user_id = ?", [$category, $insert_userid]);

            // VALID STATEMENTS: CURRENTLY NOT BEING USED. WILL BE USED TO VALIDATE SQL STATEMENTS LATER DOWN THE LINE. (04/02/2022)
            $CATEGORY_STATEMENT_VALID = False;
            $SUBCATEGORY_STATEMENT_VALID = False;
            $SOURCE_STATEMENT_VALID = False;

            $ALL_STATEMENTS_VALID = False;
            
            // IF CFC IS EMPTY;

            /*
            if (count($CHECK_FOR_CATEGORY) < 1) {
                $INSERT_CATEGORY = DB::insert('insert into mybudget_category (name) values (?)', [$category]);
                $CHECK_FOR_CATEGORY = DB::select('select id from mybudget_category where name = ?', [$category]);
                $CATEGORY_ID = $CHECK_FOR_CATEGORY;

                $CATEGORY_ID = $CHECK_FOR_CATEGORY;

                foreach($CATEGORY_ID as $CATEGORY) {
                    $CATEGORY_ID = $CATEGORY->id;
                }

            } else {
                $CHECK_FOR_CATEGORY = DB::select('select id from mybudget_category where name = ?', [$category]);
                $CATEGORY_ID = $CHECK_FOR_CATEGORY;

                foreach($CATEGORY_ID as $CATEGORY) {
                    $CATEGORY_ID = $CATEGORY->id;
                }
            }

            $CHECK_FOR_SUBCATEGORY = DB::select('select id from mybudget_section where name = ?', [$subcategory]);

            $current_datetime = date('Y-m-d H:i:s');
            if (count($CHECK_FOR_SUBCATEGORY) < 1) {
                $INSERT_SUBCATEGORY = DB::table('mybudget_section')->insert([
                    'name' => "$subcategory",
                    'budget' => 0,
                    'cost' => 0,
                    'created_at' => "$current_datetime",
                    'category_id' => $CATEGORY_ID
                ]);

                $CHECK_FOR_SUBCATEGORY = DB::select('select id from mybudget_section where name = ?', [$subcategory]);
                $SUBCATEGORY_ID = $CATEGORY_ID;
                $SUBCATEGORY_ID = $CHECK_FOR_SUBCATEGORY;

                foreach($SUBCATEGORY_ID as $SUBCATEGORY) {
                    $SUBCATEGORY_ID = $SUBCATEGORY->id;
                }

            } else {
                $CHECK_FOR_SUBCATEGORY = DB::select('select id from mybudget_section where name = ?', [$subcategory]);
                $SUBCATEGORY_ID = $CHECK_FOR_SUBCATEGORY;

                foreach($SUBCATEGORY_ID as $SUBCATEGORY) {
                    $SUBCATEGORY_ID = $SUBCATEGORY->id;
                }
            }

            */

            $current_datetime = date('Y-m-d H:i:s');
            
            $CHECK_FOR_SOURCE = DB::select('select id from mybudget_source where name = ? and user_id = ?', [$source, $insert_userid]);

            if (count($CHECK_FOR_SOURCE) < 1) {
                $INSERT_SOURCE = DB::insert('insert into mybudget_source (name, user_id) values (?, ?)', [$source, $insert_userid]);
                $CHECK_FOR_SOURCE = DB::select('select id from mybudget_source where name = ? and user_id = ?', [$source, $insert_userid]);

                $SOURCE_ID = $CHECK_FOR_SOURCE;

                foreach($SOURCE_ID as $SOURCE) {
                    $SOURCE_ID = $SOURCE->id;
                }

            } else {
                $CHECK_FOR_SOURCE = DB::select('select id from mybudget_source where name = ?  and user_id = ?', [$source, $insert_userid]);

                $SOURCE_ID = $CHECK_FOR_SOURCE;

                foreach($SOURCE_ID as $SOURCE) {
                    $SOURCE_ID = $SOURCE->id;
                }

                //echo "SOURCE ID " . $SOURCE_ID;

            }

            //echo "C_AT " . $current_datetime;
            //echo "NAME " . $name;
            //echo "PRICE " . $price;
            //echo "CATEGORY_ID " . $CATEGORY_ID;
            //echo "SECTION_ID " . var_dump($SUBCATEGORY_ID);
            //echo "SOURCE_ID " .  $SOURCE_ID;
            //echo "DESCRIPTION " . $description;  

            $date_to_insert = $date . " 00:00:00";
            
            $ITEM_INSERT = DB::table('mybudget_item')->insert([
                'created_at' => "$date_to_insert",
                'user_id' => "$insert_userid",
                'updated_at' => "$current_datetime",
                'name' => "$name",
                'price' => $price,
                'category_id' => $category,
                'section_id' => $subcategory,
                'source_id' => $SOURCE_ID,
                'description' => $description
            ]);

        }

        echo "</tbody>
        </table>";

        $mybudget_item_join = DB::table('mybudget_item')
                        ->join('mybudget_category', 'mybudget_item.category_id', '=', 'mybudget_category.id')
                        ->join('mybudget_section', 'mybudget_item.section_id', '=', 'mybudget_section.id')
                        ->join('mybudget_source', 'mybudget_item.source_id', '=', 'mybudget_source.id')
                        ->select('mybudget_item.*', 'mybudget_category.name as category_name', 'mybudget_section.name as section_name', 'mybudget_source.name as source_name')
                        //->selectRaw('PRINTF("%.2f", mybudget_item.price) as price_twodp')
                        ->where('mybudget_item.user_id', "=", "$insert_userid")
                        ->orderBy('mybudget_item.id', 'desc')

                        ->paginate(30);


        return view('mybudget/mybudget_createtransaction')->with('headers', $names)
                                                          ->with('data', $data)
                                                          ->with('transactions', $mybudget_item_join);
        


        //DB::insert('insert into mybudget_category (name) values (?)', [$request->]);

        

        /*
        $phase_1 = DB::table('category')->insert([
                        'name' => $request->$name,
                    ]);
        */
        
        /*
        $validated = $request->validate([
            'name' => 'required|max:30',
            'price' => 'required|numeric',
            'category' => 'required|max:30',
            'subcategory' => 'required|max:30',
            'source' => 'required|max:30',
            //'category_id' => 'numeric',
            //'section_id' => 'numeric',
            //'source_id' => 'numeric',
            //'description' =>
        ]);
        */

        /*
        \App\Product::create([
            'name' => $request->get('name'),
            'description' => $request->get('description'),
            'price' => $request->get('price'),
            'count' => $request->get('count'),
          ]);
  
        return redirect('/products');
        */
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
        $SHOW_TRANSACTION = DB::table('mybudget_item')
                                ->join('mybudget_category', 'mybudget_item.category_id', '=', 'mybudget_category.id')
                                ->join('mybudget_section', 'mybudget_item.section_id', '=', 'mybudget_section.id')
                                ->join('mybudget_source', 'mybudget_item.source_id', '=', 'mybudget_source.id')
                                ->select('mybudget_item.*', 'mybudget_category.name as category_name', 'mybudget_section.name as section_name', 'mybudget_source.name as source_name')
                                //->selectRaw('PRINTF("%.2f", mybudget_item.price) as price_twodp')
                                // ->selectRaw("REPLACE(mybudget_item.price, ',', '') as price_twodp")
                                ->where('mybudget_item.user_id', "=", "$insert_userid")
                                ->where("mybudget_item.id", "=", "$id")
                                ->get();

        $SHOW_SUBTRANSACTIONS = DB::table('mybudget_subtransactions')
                                    ->join('mybudget_category', 'mybudget_subtransactions.category_id', '=', 'mybudget_category.id')
                                    ->join('mybudget_section', 'mybudget_subtransactions.section_id', '=', 'mybudget_section.id')
                                    ->join('mybudget_source', 'mybudget_subtransactions.source_id', '=', 'mybudget_source.id')
                                    ->select('mybudget_subtransactions.*', 'mybudget_category.name as category_name', 'mybudget_section.name as section_name', 'mybudget_source.name as source_name')
                                    //->selectRaw('PRINTF("%.2f", mybudget_item.price) as price_twodp')
                                    // ->selectRaw("REPLACE(mybudget_subtransactions.price, ',', '') as price_twodp")
                                    ->where("mybudget_subtransactions.transaction_id", "=", "$id")
                                    ->where('mybudget_subtransactions.user_id', "=", "$insert_userid")
                                    ->get();

        
        return view('mybudget/mybudget_viewtransaction')->with('transactions', $SHOW_TRANSACTION)
                                                        ->with('subtransactions', $SHOW_SUBTRANSACTIONS)
                                                        ->with('id', $id);


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit_form($id)
    {
             $insert_userid = Auth::id();
        $SHOW_TRANSACTION_TO_EDIT = DB::table('mybudget_item')
                                ->join('mybudget_category', 'mybudget_item.category_id', '=', 'mybudget_category.id')
                                ->join('mybudget_section', 'mybudget_item.section_id', '=', 'mybudget_section.id')
                                ->join('mybudget_source', 'mybudget_item.source_id', '=', 'mybudget_source.id')
                                ->select('mybudget_item.*', 'mybudget_category.name as category_name', 'mybudget_section.name as section_name', 'mybudget_source.name as source_name')
                                //->selectRaw('PRINTF("%.2f", mybudget_item.price) as price_twodp')
                                // ->selectRaw("REPLACE(mybudget_item.price, ',', '') as price_twodp")
                                ->where("mybudget_item.id", "=", "$id")
                                ->where('mybudget_item.user_id', "=", "$insert_userid")
                                ->get();
        
        return view('mybudget/mybudget_edittransaction')->with('transactions', $SHOW_TRANSACTION_TO_EDIT)
                                                        ->with('id', $id);
    }

    /**
     * Change the specific transaction
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
             $insert_userid = Auth::id();

        $current_datetime = date('Y-m-d H:i:s');
        
        $SHOW_TRANSACTION_TO_EDIT = DB::table('mybudget_item')
                                ->join('mybudget_category', 'mybudget_item.category_id', '=', 'mybudget_category.id')
                                ->join('mybudget_section', 'mybudget_item.section_id', '=', 'mybudget_section.id')
                                ->join('mybudget_source', 'mybudget_item.source_id', '=', 'mybudget_source.id')
                                ->select('mybudget_item.*', 'mybudget_category.name as category_name', 'mybudget_section.name as section_name', 'mybudget_source.name as source_name')
                                //->selectRaw('PRINTF("%.2f", mybudget_item.price) as price_twodp')
                                // ->selectRaw("REPLACE(mybudget_item.price, ',', '') as price_twodp")
                                ->where("mybudget_item.id", "=", "$id")
                                ->where('mybudget_item.user_id', "=", "$insert_userid")
                                ->get();

        
        // These do NOT have to be converted into anything.
        $name = $request->input('name_input');
        $price = $request->input('price_input');
        $description = $request->input('description_input');
        


        // These MUST be converted into their respective ID's. If no ID is found, create a new one.
        $category = $request->input('category_input');
        $subcategory = $request->input('subcategory_input');
        $source = $request->input('source_input');


        $date_display = $request->input('date_input') . " 00:00:00";

        // GET CATEGORY ID
        $CATEGORY_ID = DB::table('mybudget_category')
                        ->where('name', '=', $category)
                        ->value('id');


         // if no id is found create one, then select it.
        if (empty($CATEGORY_ID)) {
            $NEW_CATEGORY = DB::table('mybudget_category')
                            ->insert(['name' => $category]);

            $CATEGORY_ID = DB::table('mybudget_category')
                            ->where('name', '=', $category)
                            ->value('id');                
        }
        
        // GET SUBCATEGORY ID
        $SUBCATEGORY_ID = DB::table('mybudget_section')
                           ->where('name', '=', $subcategory)
                           ->where('category_id', '=', $CATEGORY_ID)
                           ->value('id');

        // if no id is found create one, then select it.
        if (empty($SUBCATEGORY_ID)) {
            $NEW_SUBCATEGORY = DB::table('mybudget_section')
                            ->insert(['name' => $subcategory, 
                            'budget' => 0,
                            'cost' => 0,
                            'created_at' => "$current_datetime",
                            'category_id' => $CATEGORY_ID]);

            $SUBCATEGORY_ID = DB::table('mybudget_section')
                            ->where('name', '=', $subcategory)
                            ->value('id');                
        }

        $SOURCE_ID = DB::table('mybudget_source')
                        ->where('name', '=', $source)
                        ->value('id');

         // if no id is found create one, then select it.
         if (empty($SOURCE_ID)) {
            $NEW_SOURCE = DB::table('mybudget_source')
                            ->insert(['name' => $source]);

            $SOURCE_ID = DB::table('mybudget_source')
                            ->where('name', '=', $source)
                            ->value('id');                
        }

        $current_datetime = date('Y-m-d H:i:s');
    
        $UPDATE_RECORD = DB::table('mybudget_item')
        ->where('id', '=', $id)
        ->update(['name' => $name,
        'created_at' => $date_display,
        'updated_at' => $current_datetime,
        'price' => $price, 
        'description' => $description, 
        'category_id' => $CATEGORY_ID, 
        'section_id' => $SUBCATEGORY_ID, 
        'source_id' => $SOURCE_ID]);


        $SHOW_TRANSACTION_TO_EDIT = DB::table('mybudget_item')
                                ->join('mybudget_category', 'mybudget_item.category_id', '=', 'mybudget_category.id')
                                ->join('mybudget_section', 'mybudget_item.section_id', '=', 'mybudget_section.id')
                                ->join('mybudget_source', 'mybudget_item.source_id', '=', 'mybudget_source.id')
                                ->select('mybudget_item.*', 'mybudget_category.name as category_name', 'mybudget_section.name as section_name', 'mybudget_source.name as source_name')
                                //->selectRaw('PRINTF("%.2f", mybudget_item.price) as price_twodp')
                                // ->selectRaw("REPLACE(mybudget_item.price, ',', '') as price_twodp")
                                ->where("mybudget_item.id", "=", "$id")
                                ->get();

        return view('mybudget/mybudget_edittransaction')->with('transactions', $SHOW_TRANSACTION_TO_EDIT)
                                                        ->with('id', $id)
                                                        ->with('success_message', $name);


        //return $SHOW_TRANSACTION_TO_EDIT;
    }

    
    /**
     * Update the specified resource in storage. NOT IN USE !!!!!!!!!!!!!!!!!!!!!!!!
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
    }

    /**
     * Show the form for deleting the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete_form($id)
    {
        $insert_userid = Auth::id();

        $SHOW_TRANSACTION_TO_DELETE = DB::table('mybudget_item')
                                ->join('mybudget_category', 'mybudget_item.category_id', '=', 'mybudget_category.id')
                                ->join('mybudget_section', 'mybudget_item.section_id', '=', 'mybudget_section.id')
                                ->join('mybudget_source', 'mybudget_item.source_id', '=', 'mybudget_source.id')
                                ->select('mybudget_item.*', 'mybudget_category.name as category_name', 'mybudget_section.name as section_name', 'mybudget_source.name as source_name')
                                //->selectRaw('PRINTF("%.2f", mybudget_item.price) as price_twodp')
                                // ->selectRaw("REPLACE(mybudget_item.price, ',', '') as price_twodp")
                                ->select('mybudget_item.name as item_name')  
                                ->select('mybudget_item.price as price_twodp')
                                ->where("mybudget_item.id", "=", "$id")
                                ->where('mybudget_item.user_id', "=", "$insert_userid")
                                ->get();

        
        return view('mybudget/mybudget_deletetransaction')->with('transactions', $SHOW_TRANSACTION_TO_DELETE)
                                                          ->with('transaction_id', $id);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $insert_userid = Auth::id();

        $TRANSACTION_TO_DELETE = mybudget_item::find($id);

        $TRANSACTION_DATA = $TRANSACTION_TO_DELETE;

        $TRANSACTION_TO_DELETE->delete();

        $mybudget_item_join = DB::table('mybudget_item')
                        ->join('mybudget_category', 'mybudget_item.category_id', '=', 'mybudget_category.id')
                        ->join('mybudget_section', 'mybudget_item.section_id', '=', 'mybudget_section.id')
                        ->join('mybudget_source', 'mybudget_item.source_id', '=', 'mybudget_source.id')
                        ->select('mybudget_item.*', 'mybudget_category.name as category_name', 'mybudget_section.name as section_name', 'mybudget_source.name as source_name')
                        //->selectRaw('PRINTF("%.2f", mybudget_item.price) as price_twodp')
                        // ->selectRaw("REPLACE(mybudget_item.price, ',', '') as price_twodp")
                        ->select('mybudget_item.price as price_twodp')
                        ->where('mybudget_item.user_id', '=', "$insert_userid")
                        ->orderBy('mybudget_item.id', 'desc')
                        ->paginate(30);

        return view('mybudget/mybudget_createtransaction')->with('success_message_delete', $TRANSACTION_DATA)
                                                          ->with('transactions', $mybudget_item_join);

    }

    public function undo_delete_form($id) {
        
        $insert_userid = Auth::id();

        $SHOW_TRANSACTION_TO_UNDO = DB::table('mybudget_item')
                                ->join('mybudget_category', 'mybudget_item.category_id', '=', 'mybudget_category.id')
                                ->join('mybudget_section', 'mybudget_item.section_id', '=', 'mybudget_section.id')
                                ->join('mybudget_source', 'mybudget_item.source_id', '=', 'mybudget_source.id')
                                ->select('mybudget_item.*', 'mybudget_category.name as category_name', 'mybudget_section.name as section_name', 'mybudget_source.name as source_name')
                                //->selectRaw('PRINTF("%.2f", mybudget_item.price) as price_twodp')
                                // ->selectRaw("REPLACE(mybudget_item.price, ',', '') as price_twodp")
                                ->select('mybudget_item.price as price_twodp')
                                ->where("mybudget_item.id", "=", "$id")
                                ->where('mybudget_item.user_id', "=", "$insert_userid")
                                ->get();

        
        return view('mybudget/mybudget_undodeletion')->with('transactions', $SHOW_TRANSACTION_TO_UNDO)
                                                     ->with('transaction_id', $id);
    }

    public function undo_delete($id) {

        $TRANSACTION_TO_UNDO = mybudget_item::find($id);
        $TRANSACTION_DATA = $TRANSACTION_TO_UNDO;

        $TRANSACTION_TO_UNDO = DB::table('mybudget_item')
                                    ->where('id', $id)
                                    ->update(['deleted_at' => NULL]);

        $mybudget_item_join = DB::table('mybudget_item')
                                    ->join('mybudget_category', 'mybudget_item.category_id', '=', 'mybudget_category.id')
                                    ->join('mybudget_section', 'mybudget_item.section_id', '=', 'mybudget_section.id')
                                    ->join('mybudget_source', 'mybudget_item.source_id', '=', 'mybudget_source.id')
                                    ->select('mybudget_item.*', 'mybudget_category.name as category_name', 'mybudget_section.name as section_name', 'mybudget_source.name as source_name')
                                    //->selectRaw('PRINTF("%.2f", mybudget_item.price) as price_twodp')
                                    // 
                                    ->select('mybudget_item.price as price_twodp')
                                    ->orderBy('mybudget_item.id', 'desc')
                                    ->paginate(30);

        
        return view('mybudget/mybudget_createtransaction')->with('transactions', $mybudget_item_join)
                                                          ->with('transaction_id', $id)
                                                          ->with('success_message_undo', $TRANSACTION_DATA);
        }


    public function subtransaction_view() {

        $SHOW_SUBTRANSACTIONS = DB::table('mybudget_subtransactions')
                                    ->join('mybudget_category', 'mybudget_subtransactions.category_id', '=', 'mybudget_category.id')
                                    ->join('mybudget_section', 'mybudget_subtransactions.section_id', '=', 'mybudget_section.id')
                                    ->join('mybudget_source', 'mybudget_subtransactions.source_id', '=', 'mybudget_source.id')
                                    ->select('*')
                                    ->orderBy('id', 'desc')
                                    ->get();

        

    }

    /**
     * Show the subtransaction form
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function subtransaction_form($id) {

        $SHOW_TRANSACTION = DB::table('mybudget_item')
                                ->join('mybudget_category', 'mybudget_item.category_id', '=', 'mybudget_category.id')
                                ->join('mybudget_section', 'mybudget_item.section_id', '=', 'mybudget_section.id')
                                ->join('mybudget_source', 'mybudget_item.source_id', '=', 'mybudget_source.id')
                                ->select('mybudget_item.*', 'mybudget_category.name as category_name', 'mybudget_section.name as section_name', 'mybudget_source.name as source_name')
                                //->selectRaw('PRINTF("%.2f", mybudget_item.price) as price_twodp')
                                ->selectRaw("REPLACE(mybudget_item.price, ',', '') as price_twodp")
                                ->where("mybudget_item.id", "=", "$id")
                                //->where("mybudget_item.has_subtransactions", "=", 0)
                                ->get();
        
        $SHOW_SUBTRANSACTIONS = DB::table('mybudget_subtransactions')
                                    ->join('mybudget_category', 'mybudget_subtransactions.category_id', '=', 'mybudget_category.id')
                                    ->join('mybudget_section', 'mybudget_subtransactions.section_id', '=', 'mybudget_section.id')
                                    ->join('mybudget_source', 'mybudget_subtransactions.source_id', '=', 'mybudget_source.id')
                                    ->select('mybudget_subtransactions.*', 'mybudget_category.name as category_name', 'mybudget_section.name as section_name', 'mybudget_source.name as source_name')
                                    //->selectRaw('PRINTF("%.2f", mybudget_item.price) as price_twodp')
                                    // ->selectRaw("REPLACE(mybudget_subtransactions.price, ',', '') as price_twodp")
                                    ->select('mybudget_subtransactions.price as price_twodp')
                                    ->where("mybudget_subtransactions.transaction_id", "=", "$id")
                                    ->get();

        //return $SHOW_SUBTRANSACTIONS;

        $categories = mybudget_category::all();

        return view('mybudget/mybudget_subtransaction_create')->with('transactions', $SHOW_TRANSACTION)
                                                              ->with('subtransactions', $SHOW_SUBTRANSACTIONS)
                                                              ->with('categories', $categories)
                                                              ->with('id', $id);

        
    }

    public function store_subtransactions(Request $request, $id) {
         $insert_userid = Auth::id();

        $categories = mybudget_category::all();

        $SHOW_TRANSACTION = DB::table('mybudget_item')
                                ->join('mybudget_category', 'mybudget_item.category_id', '=', 'mybudget_category.id')
                                ->join('mybudget_section', 'mybudget_item.section_id', '=', 'mybudget_section.id')
                                ->join('mybudget_source', 'mybudget_item.source_id', '=', 'mybudget_source.id')
                                ->select('mybudget_item.*', 'mybudget_category.name as category_name', 'mybudget_section.name as section_name', 'mybudget_source.name as source_name')
                                //->selectRaw('PRINTF("%.2f", mybudget_item.price) as price_twodp')
                                // ->selectRaw("REPLACE(mybudget_item.price, ',', '') as price_twodp")
                                ->select('mybudget_item.price as price_twodp')
                                ->where("mybudget_item.id", "=", "$id")
                                ->where('mybudget_item.user_id', "=", "$insert_userid")
                                ->get();
                                
        $headers = $request->input('subtransaction-pages');

        $TRANSACTION_ID = $request->input('transaction-id');

        $UPDATE_RECORD = DB::table('mybudget_item')
        ->where('id', '=', $TRANSACTION_ID)
        ->where('mybudget_item.user_id', "=", "$insert_userid")
        ->update(['has_subtransactions' => 1,

        ]);



        $headers = explode(",", $headers);

        $headers_array = $headers;

        $names = array();
        $prices = array();
        $categories = array();
        $subcategories = array();
        $sources = array();
        $dates = array();
        $descriptions = array();

        for ($i = 0; $i < count($headers_array); $i++) {
            $header_value = $headers_array[$i];

            $header_name = $request->input("subtransaction-$header_value-name");
            $header_price = $request->input("subtransaction-$header_value-price");
            $header_category = $request->input("subtransaction-$header_value-category");
            $header_subcategory = $request->input("subtransaction-$header_value-subcategory");
            $header_source = $request->input("subtransaction-$header_value-source");
            $header_date = $request->input("subtransaction-$header_value-date");
            $header_description = $request->input("subtransaction-$header_value-description");

            
            array_push($names, $header_name);
            array_push($prices, $header_price);
            array_push($categories, $header_category);
            array_push($subcategories, $header_subcategory);
            array_push($sources, $header_source);
            array_push($dates, $header_date);
            array_push($descriptions, $header_description);
        }


        // Create a 'dictionary' which contains the aforementioned arrays
        $data = [
            'names' => $names,
            'prices' => $prices,
            'categories' => $categories,
            'subcategories' => $subcategories,
            'sources' => $sources,
            'dates' => $dates,
            //'descriptions' => $descriptions,
        ];

        for ($i = 0; $i < count($data['names']); $i++) {
            /*
            echo $data['names'][$i];
            echo "<br>";
            */


            $i_display = $i+1;

            // Loop through the data dictionary's keys
            $name = $data['names'][$i];
            $price = number_format($data['prices'][$i], 2);
            $category = $data['categories'][$i];
            $subcategory = $data['subcategories'][$i];
            $source = $data['sources'][$i];
            $date = $data['dates'][$i];

            $date_display = date("d/m/Y", strtotime($date));

            $CATEGORY_ID = $category;
            $SUBCATEGORY_ID = $subcategory;

            $current_datetime = date('Y-m-d H:i:s');

            /*
            $CHECK_FOR_CATEGORY = DB::select("select id from mybudget_category where name = ?", [$category]);
            // if category does NOT exist
            if (count($CHECK_FOR_CATEGORY) < 1) {
                $INSERT_CATEGORY = DB::insert('insert into mybudget_category (name) values (?)', [$category]);
                $CHECK_FOR_CATEGORY = DB::select('select id from mybudget_category where name = ?', [$category]);
                $CATEGORY_ID = $CHECK_FOR_CATEGORY;

                $CATEGORY_ID = $CHECK_FOR_CATEGORY;

                foreach($CATEGORY_ID as $CATEGORY) {
                    $CATEGORY_ID = $CATEGORY->id;
                }

            } else {
                $CHECK_FOR_CATEGORY = DB::select('select id from mybudget_category where name = ?', [$category]);
                $CATEGORY_ID = $CHECK_FOR_CATEGORY;

                foreach($CATEGORY_ID as $CATEGORY) {
                    $CATEGORY_ID = $CATEGORY->id;
                }
            }
            
            $CHECK_FOR_SUBCATEGORY = DB::select('select id from mybudget_section where name = ?', [$subcategory]);

            $current_datetime = date('Y-m-d H:i:s');

            // if subcategory does NOT exist
            if (count($CHECK_FOR_SUBCATEGORY) < 1) {
                $INSERT_SUBCATEGORY = DB::table('mybudget_section')->insert([
                    'name' => "$subcategory",
                    'budget' => 0,
                    'cost' => 0,
                    'created_at' => "$current_datetime",
                    'category_id' => $CATEGORY_ID
                ]);

                $CHECK_FOR_SUBCATEGORY = DB::select('select id from mybudget_section where name = ?', [$subcategory]);
                $SUBCATEGORY_ID = $CATEGORY_ID;
                $SUBCATEGORY_ID = $CHECK_FOR_SUBCATEGORY;

                foreach($SUBCATEGORY_ID as $SUBCATEGORY) {
                    $SUBCATEGORY_ID = $SUBCATEGORY->id;
                }

            } else {
                $CHECK_FOR_SUBCATEGORY = DB::select('select id from mybudget_section where name = ?', [$subcategory]);
                $SUBCATEGORY_ID = $CHECK_FOR_SUBCATEGORY;

                foreach($SUBCATEGORY_ID as $SUBCATEGORY) {
                    $SUBCATEGORY_ID = $SUBCATEGORY->id;
                }
            }
            */

            $CHECK_FOR_SOURCE = DB::select('select id from mybudget_source where name = ?', [$source]);

            if (count($CHECK_FOR_SOURCE) < 1) {
                $INSERT_SOURCE = DB::insert('insert into mybudget_source (name) values (?)', [$source]);
                $CHECK_FOR_SOURCE = DB::select('select id from mybudget_source where name = ?', [$source]);

                $SOURCE_ID = $CHECK_FOR_SOURCE;

                foreach($SOURCE_ID as $SOURCE) {
                    $SOURCE_ID = $SOURCE->id;
                }

            } else {
                $CHECK_FOR_SOURCE = DB::select('select id from mybudget_source where name = ?', [$source]);

                $SOURCE_ID = $CHECK_FOR_SOURCE;

                foreach($SOURCE_ID as $SOURCE) {
                    $SOURCE_ID = $SOURCE->id;
                }

                //echo "SOURCE ID " . $SOURCE_ID;

            }

            // MVC Model

            // VUE, React before Laravel



            $date_to_insert = $date . " 00:00:00";
            
            $ITEM_INSERT = DB::table('mybudget_subtransactions')->insert([
                'created_at' => "$date_to_insert",
                'updated_at' => "$current_datetime",
                'user_id' => "$insert_userid",
                'name' => "$name",
                'price' => $price,
                'description' => 'N/A',
                'transaction_id' => $TRANSACTION_ID,
                'category_id' => $CATEGORY_ID,
                'section_id' => $SUBCATEGORY_ID,
                'source_id' => $SOURCE_ID


                //'description' => $description
            ]);
        }

        return view('mybudget/mybudget_subtransaction_create')->with('transactions', $SHOW_TRANSACTION)
                                                              ->with('data', $data)
                                                              ->with('id', $id);

    }

    public function create_subtransactions($id) {
        return '';
    }

    public function load_more_transactions(Request $request) {
        return '';
    }

    public function column_search($column_select, $column_search) {
         $insert_userid = Auth::id();

        $transactions = DB::table('mybudget_item')
        ->join('mybudget_category', 'mybudget_item.category_id', '=', 'mybudget_category.id')
        ->join('mybudget_section', 'mybudget_item.section_id', '=', 'mybudget_section.id')
        ->join('mybudget_source', 'mybudget_item.source_id', '=', 'mybudget_source.id')
        ->select('mybudget_item.*', 'mybudget_category.name as category_name', 'mybudget_section.name as section_name', 'mybudget_source.name as source_name')
        //->selectRaw('PRINTF("%.2f", mybudget_item.price) as price_twodp')
        // ->selectRaw("REPLACE(mybudget_item.price, ',', '') as price_twodp")
        ->select('mybudget_item.price as price_twodp')
        ->where("$column_select", 'LIKE','%'.$column_search.'%')
        ->where('mybudget_item.user_id', "=", "$insert_userid")
        ->orderBy('mybudget_item.id', 'desc')
        //->limit(25)
        //->paginate(30);
        ->get();
        
        return view('mybudget/partial_views/mybudget_createtransactiontable')->with('transactions', $transactions)
                                                                             ->render();
    }

    //function search_results($)

    public function show_date_range($section, $start_date, $end_date) {
         $insert_userid = Auth::id();


        $mybudget_item_join = DB::table('mybudget_item')
        ->join('mybudget_category', 'mybudget_item.category_id', '=', 'mybudget_category.id')
        ->join('mybudget_section', 'mybudget_item.section_id', '=', 'mybudget_section.id')
        ->join('mybudget_source', 'mybudget_item.source_id', '=', 'mybudget_source.id')
        ->select('mybudget_item.*', 'mybudget_category.name as category_name', 'mybudget_section.name as section_name', 'mybudget_source.name as source_name')
        //->selectRaw('PRINTF("%.2f", mybudget_item.price) as price_twodp')
        // ->selectRaw("REPLACE(mybudget_item.price, ',', '') as price_twodp")
        ->select('mybudget_item.price as price_twodp')
        ->where('mybudget_item.section_id', '=', $section)
        ->where('mybudget_item.user_id', "=", "$insert_userid")
        ->whereBetween('mybudget_item.created_at', [$start_date, $end_date])
        ->orderBy('mybudget_item.id', 'desc')
        ->paginate(30);

        return view('mybudget/mybudget_createtransaction')->with('transactions', $mybudget_item_join);

    }

    public function item_history_index() {
        $mybudget_subtransactions_join = DB::table('mybudget_subtransactions')
                                            ->join('mybudget_category', 'mybudget_subtransactions.category_id', '=', 'mybudget_category.id')
                                            ->join('mybudget_section', 'mybudget_subtransactions.section_id', '=', 'mybudget_section.id')
                                            ->join('mybudget_source', 'mybudget_subtransactions.source_id', '=', 'mybudget_source.id')
                                            ->select('mybudget_subtransactions.name', 'mybudget_subtransactions.price', 'mybudget_subtransactions.created_at')
                                            //->where('mybudget_subtransactions.name', '=', $name)
                                            ->orderBy('mybudget_subtransactions.created_at', 'asc')
                                            ->get();

       return view('mybudget/mybudget_viewitemtrends')->with('items', $mybudget_subtransactions_join);
    }

    public function item_history_search($name) {
        $mybudget_subtransactions_join = DB::table('mybudget_subtransactions')
                                            ->join('mybudget_category', 'mybudget_subtransactions.category_id', '=', 'mybudget_category.id')
                                            ->join('mybudget_section', 'mybudget_subtransactions.section_id', '=', 'mybudget_section.id')
                                            ->join('mybudget_source', 'mybudget_subtransactions.source_id', '=', 'mybudget_source.id')
                                            ->select('mybudget_subtransactions.name', 'mybudget_subtransactions.price', 'mybudget_subtransactions.created_at')
                                            ->where("mybudget_subtransactions.name", 'LIKE','%'.$name.'%')
                                            ->orderBy('mybudget_subtransactions.created_at', 'desc')
                                            ->groupBy('mybudget_subtransactions.name')
                                            ->get();


        return view('mybudget/partial_views/mybudget_itemsearchresults')->with('items', $mybudget_subtransactions_join)
                                                                        ->render();
    
    }
}
