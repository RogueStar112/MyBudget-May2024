<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MyBudget - Statistics</title>

    <script src="https://kit.fontawesome.com/c36ba6cddf.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    

    <link href="{{ asset('css/mylifeline_home.css') }}" rel="stylesheet" type="text/css">
    <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>

    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">

    
</head>
<body>
    <div id="app">
        <x-navbar-complete brandName='MyBudget' />


        <div class="statistics-container mt-3">

            <div class="row">
                
                <div class="col-sm">
                <div class="container-headings">
                    <h1 style="color: blue; font-weight: 800;">STATISTICS</h1>
                    <i class="fas fa-chart-line statistics-icon"></i>
                </div>

                <form id="THE-FORM" method="GET" action="/budgeting-app/app/statistics/1">
                    <div class="row date-input" style="margin-bottom: 10px;">
                        <div class="col-md-6 mb-3">
                            <label for="input-date-start" class="form-label">Start Date</label>
                            <input type="date" class="form-control" id="input-date-start" name="input-date-start">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="input-date-end" class="form-label">End Date</label>
                            <input type="date" class="form-control" id="input-date-end" name="input-date-end">
                        </div>
                    </div>

                    <select class="form-select mb-3" id="select-category" name="select-category">
                        <option selected>Select by category</option>
                        @isset($categories)

                            @foreach($categories as $category)
                            
                                {{-- @php echo "<p>" . $category . "</p>"; @endphp --}}
                                <option value={{$category->id}} onClick="editFormAction({{$category->id}})">{{$category->name}}</option>


                                <!-- Add an ALL option; Which displays ALL Categories-->
                                @if($loop->last)
                                <option value="ALL" onClick="editFormAction('ALL')">ALL</option>
                                @endif
                            @endforeach
                        
                        @endisset
                    </select>

                    <div class="col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="toggle-daily-sum" name="toggle-daily-sum">
                            <label class="form-check-label" for="toggle-daily-sum">
                            Toggle Daily Sum
                            </label>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="toggle-all-categories" name="toggle-all-categories">
                            <label class="form-check-label" for="toggle-all-categories">
                            Toggle All Categories
                            </label>
                        </div>
                    </div>

                    <!--
                    <select style="margin-top: 10px;" class="form-select" id="select-date" name="select-category">
                        <option selected>Select by category</option>
                    </select>
                    -->

                    <button type="submit" class="btn btn-primary" id="SUBMIT-BUTTON-STATISTICS">Submit</button>
                </form>

                <div class="row flex-row">
                
                <div class="col-md-12">
                <div class="form-check form-check-inline col-md-4">
                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1" />
                <label class="form-check-label" for="inlineRadio1">1</label>
                </div>
                    
                <div class="form-check form-check-inline col-md-3">
                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2" />
                <label class="form-check-label" for="inlineRadio2">2</label>
                </div>
                
                <div class="form-check form-check-inline col-md-4">
                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio3" value="option3" disabled />
                <label class="form-check-label" for="inlineRadio3">3 (disabled)</label>
                </div>
                </div>

                @isset($category_selected)
                    @if ($id == 'ALL')

                        @foreach ($categories as $category_selected)
                        <div class="col-md-6">

                        @php

                        /*
                        $GET_SECTION_SUM = DB::table('mybudget_item')
                                                    ->join('mybudget_section', 'mybudget_item.section_id', '=', 'mybudget_section.id')
                                                    ->join('mybudget_category', 'mybudget_item.category_id', '=', 'mybudget_category.id')
                                                    //->select("mybudget_section.id as section_id")
                                                    ->select("mybudget_section.name as section_name")
                                                    ->selectRaw("SUM(REPLACE(mybudget_item.price, ',', '')) as sum_price")
                                                    ->where("mybudget_category.id", "=", $category_selected['id'])
                                                    //->where("mybudget_item.has_subtransactions", "=", 0)
                                                    ->whereBetween("mybudget_item.created_at", [$start_date, $end_date])
                                                    ->whereNull('deleted_at')
                                                    ->groupBy("section_name")
                                                    ->orderBy("sum_price", "desc")
                                                    ->get();

                        $sections = $GET_SECTION_SUM;
                        */
                        
                        @endphp
                        <div class="sample-category-container mt-3" id="sample-category-container" style="margin: 0 auto; color: {{$category_selected->color_text}}; position: relative; background: -moz-linear-gradient(90deg, #FFFFFF, {{$category_selected->color_bg}});">
                            <h3 id="view-category-text">{{$category_selected->name}}</h3>

                            <i class="fas rotate-20 upscale-icon-11x" id="view-category-icon">{{html_entity_decode($category_selected->icon_code)}}</i>
                            
                            <div class="sample-category-container-transactions">
                                <style type="text/css">
                                    .tg  {border-collapse:collapse;border-spacing:0;}
                                    .tg td{border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;
                                    overflow:hidden;padding:10px 5px;word-break:normal;}
                                    .tg th{border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;
                                    font-weight:normal;overflow:hidden;padding:10px 5px;word-break:normal;}
                                    .tg .tg-i7zr{font-family:Arial, Helvetica, sans-serif !important;text-align:left;vertical-align:top}
                                    .tg .tg-0lax{text-align:left;vertical-align:top}
                                    </style>
                                    <table style="width: 100%;" border="2">
                                        <tbody>
                                            <tr>
                                                <td style="font-weight: 800; text-align: left; margin-left: 30px;">Subcategory</td>
                                                <td style="font-weight: 800; text-align: right; margin-right: 30px;">Cost</td>
                                            </tr>
                                            @php
                                                $TRANSACTION_SUM = 0; 
                                            @endphp

                                            @if(count($sections) === 0)
                                                <td>No Transactions</td>
                                                <td></td>
                                            @endif
                                        

                                            @foreach($sections as $section => $subsection)
                                            
                                            @if($section == $category_selected['name'])
                                                
                                                @php
                                                    // Sorts the Section from Descending order.
                                                    arsort($subsection);
                                                @endphp

                                                @foreach($subsection as $ss_key => $ss_value)

                                                @if($ss_value != 0)
                                                <tr>
                                                    <td>{{$ss_key}}</td>
                                                    <td>£{{number_format($ss_value, 2)}}</td>
                                                </tr>
                                                @endif

                                                @php
                                                    $TRANSACTION_SUM += $ss_value;
                                                @endphp
                                                @endforeach

                                            @endif

                                            @php
                                            @endphp
                                
                                            
                                            @if($loop->last)
                                            <tr>
                                                <td style="font-weight: 800; font-size: 20px;">TOTAL</td>
                                                <td style="font-weight: 800; font-size: 20px;">£{{number_format($TRANSACTION_SUM, 2)}}</td>
                                            </tr>
                                            @endif


                                            @endforeach
                                        </tbody>
                                    </table>
                                    <!-- DivTable.com -->
                                    <p>&nbsp;</p>
                            </div>
                        </div>
                        </div>
                        @endforeach
                    @else
                    
                    @php

                    /*
                        $GET_SECTION_SUM = DB::table('mybudget_item')
                                                    ->join('mybudget_section', 'mybudget_item.section_id', '=', 'mybudget_section.id')
                                                    ->join('mybudget_category', 'mybudget_item.category_id', '=', 'mybudget_category.id')
                                                    //->select("mybudget_section.id as section_id")
                                                    ->select("mybudget_section.name as section_name")
                                                    ->selectRaw("SUM(REPLACE(mybudget_item.price, ',', '')) as sum_price")
                                                    ->where("mybudget_category.id", "=", $category_selected['id'])
                                                    ->whereBetween("mybudget_item.created_at", [$start_date, $end_date])
                                                    ->whereNull('deleted_at')
                                                    ->groupBy("section_name")
                                                    ->orderBy("sum_price", "desc")
                                                    ->get();

                        $sections = $GET_SECTION_SUM;
                    */
                    

                
                    @endphp

                    <div class="sample-category-container mt-3" id="sample-category-container" style="margin: 0 auto; color: {{$category_selected->color_text}}; position: relative; background: -moz-linear-gradient(90deg, '#FFFFFF', {{$category_selected->color_bg}});">
                        <h3 id="view-category-text">{{$category_selected->name}}</h3>

                        <i class="fas rotate-20 upscale-icon-11x" id="view-category-icon">{{html_entity_decode($category_selected->icon_code)}}</i>
                        
                        <div class="sample-category-container-transactions">
                            <style type="text/css">
                                .tg  {border-collapse:collapse;border-spacing:0;}
                                .tg td{border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;
                                overflow:hidden;padding:10px 5px;word-break:normal;}
                                .tg th{border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;
                                font-weight:normal;overflow:hidden;padding:10px 5px;word-break:normal;}
                                .tg .tg-i7zr{font-family:Arial, Helvetica, sans-serif !important;text-align:left;vertical-align:top}
                                .tg .tg-0lax{text-align:left;vertical-align:top}
                                </style>
                                <table style="width: 100%;" border="2">
                                    <tbody>
                                        <tr>
                                            <td style="font-weight: 800; text-align: left; margin-left: 30px;">Subcategory</td>
                                            <td style="font-weight: 800; text-align: right; margin-right: 30px;">Cost</td>
                                        </tr>
                                        @php
                                            $TRANSACTION_SUM = 0;    
                                        @endphp
                                        @foreach($sections as $section_key => $section_value)

                                        @php
                                            //$TRANSACTION_SUM += $section->sum_price;
        
                                        @endphp
                                        @if($section_key == $category_selected['name'])
                                        @foreach($section_value as $ss_key => $ss_value)
                                        <tr>
                                            <td>{{$ss_key}}</td>
                                            <td>£{{number_format($ss_value, 2)}}</td>
                                        </tr>

                                        @php
                                        $TRANSACTION_SUM += $ss_value;
                                        @endphp
                                        @endforeach
                                        @endif
                                        
                                        
                                        @if($loop->last)
                                        <tr>
                                            <td style="font-weight: 800; font-size: 20px;">TOTAL</td>
                                            <td style="font-weight: 800; font-size: 20px;">£{{number_format($TRANSACTION_SUM, 2)}}</td>
                                        </tr>
                                        @endif


                                        @endforeach
                                    </tbody>
                                </table>
                                <!-- DivTable.com -->
                                <p>&nbsp;</p>
                        </div>
                    </div>
                    </div>    
                    @endif
                    
                    <div class="col-md-12">      
                        
                       
                    </div>

                    <div class="row flex-row">
                        @isset($transaction_dates)
                        <div class="col-md-6">
                            <table class='table view_transaction_table'>
                                <thead>
                                    <th scope='col'>Date</th>
                                    <th scope='col'>Sum of Costs</th>
                                </thead>
                            <tbody>
                            @foreach($transaction_dates as $transaction_date)
                                <tr>
                                    <td>{{date('d/m/Y', strtotime($transaction_date->dates))}}</td>
                                    <td>£{{$transaction_date->sum_price}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                            </table>
                        </div>
                        @endisset

                        @isset($transaction_dates)

                        <div class="col-md-6">
                            <div id="transaction_dates_graph" style="width:100%;height:100%;"></div>
                        </div>

                        @endisset
                    </div>
                @endisset
                </div>
            </div>

            <div class="col-sm">
                <div style="height: 500px; width: 100%; padding-bottom: 50px;">
                    
                    @isset($start_date, $end_date)
                        @php $start_date_display = date("d F Y", strtotime($start_date)); 
                            $end_date_display = date("d F Y", strtotime($end_date)); 
                        @endphp

                        @php echo "<h1 class='mt-3' style='text-align: center; font-weight: 800;'>$start_date_display to $end_date_display</h1>"; @endphp
                    @endisset

                    @isset($daily_graph_labels, $daily_graph_data)
                    <canvas id="spendingByDay"></canvas>
                    @endisset

                </div>

                <div style="height: 100%; width: 100%;">
                    <div class="col-md-12">      
                        
                        @isset($transactions)
                        <h2 class="mt-3" style="text-align: center;">Transaction Table</h2>
                        <table class='table view_transaction_table'>
                            <thead>
                                <tr>
                                    <th scope='col'>Name</th>
                                    <th scope='col'>Price</th>
                                    <th scope='col'>Date</th>
                                    <th scope='col'>Category</th>
                                    <th scope='col'>Subcategory</th>
                                    <!-- <th scope='col'>Description</th> -->
                                </tr>
                            </thead>
                            <tbody>
                            
                            @php
                                $TRANSACTION_SUM = 0;    
                                $INCOME_SUM = 0;
                            @endphp

                            @foreach($transactions as $transaction)

                                @if ($loop->odd) 
                                <tr>
                                    <td>{{$transaction->name}}</td>
                                    @if((int)$transaction->price_twodp < 1000)
                                    <td>£{{number_format($transaction->price_twodp, 2)}}</td>
                                    @else
                                    <td>£{{$transaction->price_twodp}}</td>
                                    @endif
                                    <td>{{date('d/m/Y', strtotime($transaction->created_at))}}</td>
                                    <td>{{$transaction->category_name}}</td>
                                    <td>{{$transaction->section_name}}</td>
                                    <!-- <td>{{-- $transaction->description --}}</td> -->
                                </tr>
                                @endif

                                @if ($loop->even)
                                    @if(isset($category_selected)) 
                                    <tr style="color: black; background: -moz-linear-gradient(90deg, orange, orange);">
                                    @else
                                    <tr style="background: -moz-linear-gradient(151deg, #FFFFFF, peachpuff);">
                                    @endif
                                    
                                    <td>{{$transaction->name}}</td>
                                    
                                    <!-- If Price is Below £1000, Show Price to Two decimal places -->
                                    
                                    @if((int)$transaction->price_twodp < 1000)
                                    <td>£{{number_format($transaction->price_twodp, 2)}}</td>
                                    @else
                                    <td>£{{$transaction->price_twodp}}</td>
                                    @endif
                                    
                                    <td>{{date('d/m/Y', strtotime($transaction->created_at))}}</td>
                                    
                                    <td>{{$transaction->category_name}}</td>
                                    

                                    <td>{{$transaction->section_name}}</td>

                                    <!-- <td>{{-- $transaction->description --}}</td> -->
                                </tr>
                                @endif

                                @if ($transaction->category_name != 'Income')
                                @php
                                $TRANSACTION_SUM += $transaction->price_twodp 
                                @endphp
                                @endif

                                @if ($transaction->category_name === 'Income')
                                @php
                                $INCOME_SUM += $transaction->price_twodp 
                                @endphp
                                @endif

                                @if($loop->last)
                                    <tr style="background-color: white;">
                                        <td colspan="5">TRANSACTION COUNT: {{$loop->count}}</td>
                                    </tr>

                                    
                                    <tr style="background-color: lime;">
                                    <td colspan="1">TOTAL</td>
                                    <td colspan="2">INCOME</td>
                                    <td colspan="2">SPENT</td>
                                    </tr>
                                    
                                    <tr>
                                        <td colspan="1"></td>
                                        <td colspan="2">£{{$INCOME_SUM}}</td>
                                        <td colspan="2">£{{$TRANSACTION_SUM}}</td>
                                    </tr>
                                        
                                @endif

                            @endforeach
                            </tbody>
                        </table>
                        @endisset
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>

    


<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
<script
			  src="https://code.jquery.com/jquery-3.6.0.js"
			  integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
			  crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
		
</body>

<script>   
    
    // SS.0.1. Random Placeholder Text //
    // PURPOSE: For cosmetic reasons, to make it so item inputs have varying placeholders.
    var placeholder_text_JSON = [
            {
            'name': 'Frozen Peas 1kg',
            'price': '0.79',
            'category': 'Groceries',
            'subcategory': 'Frozen Food',
            'source': 'Aldi',
            'description': 'Half the price of fresh peas!'
            },

            {
            'name': 'Gaming PC',
            'price': '749.99',
            'category': 'Shopping',
            'subcategory': 'Electronics',
            'source': 'Currys',
            'description': '16GB RAM, Decent GPU and CPU.'
            },

            {
            'name': 'Microwave',
            'price': '60',
            'category': 'Essentials',
            'subcategory': 'Cooking Equipment',
            'source': 'Tesco',
            'description': 'To cook ready meals'
            },

            {
            'name': 'Coca Cola Cans (x6)',
            'price': '2.99',
            'category': 'Groceries',
            'subcategory': 'Junk Food',
            'source': 'Tesco',
            'description': 'For a party'
            },

            {
            'name': 'Thai Eatout',
            'price': '43.45',
            'category': 'Eating Out',
            'subcategory': 'Thai',
            'source': 'Thai Land',
            'description': 'An occasional treat. 7/10.'
            }
        ]
    
    r = Math.floor(Math.random() * placeholder_text_JSON.length);
    
    function randomPlaceholderText() {
        r = Math.floor(Math.random() * placeholder_text_JSON.length);

        $('#transaction-name-1').prop('placeholder',placeholder_text_JSON[r]['name']);
        $('#transaction-price-1').prop('placeholder',placeholder_text_JSON[r]['price']);
        $('#transaction-category-1').prop('placeholder',placeholder_text_JSON[r]['category']);
        $('#transaction-subcategory-1').prop('placeholder',placeholder_text_JSON[r]['subcategory']);
        $('#transaction-source-1').prop('placeholder',placeholder_text_JSON[r]['source']);
        $('#transaction-date-1').prop('placeholder',placeholder_text_JSON[r]['date']);
        $('#transaction-description-1').prop('placeholder',placeholder_text_JSON[r]['description']);

        //$('#search').prop('placeholder',list[r]);
    }

    randomPlaceholderText()

    // SS.0.2. Add Transaction //

    // *Page Number Stuff* //

    /*

    pageNumber Variables Explained

    pageNumber - indicates what page you're on.
    pageNumber_index - 

    */
    var pageNumber = 1;
    var pageNumber_index = 0;
    
    //var pageNumber_display = pageNumber_index + 1;
    var noOfPages = 1;


    // The Page Balancer: Weird name, but basically ensures that the nextPage function does not go out of page range.
    var pageBalancer = 1;

    var page_numbers = [1]

    var page_content = {}

    function updatePageNumber() {
        pageNumber_index += 1
        $("#page-number-text").text("Page " + pageNumber_index + " out of " + page_numbers.length)
        pageNumber_index -= 1
    }

    function createNewPage() {

        var page_content_toupdate_name = `<div class="col m-3 transaction-${noOfPages}"><label for="transaction-name-${noOfPages}">Name</label><input class="form-control" id="transaction-${noOfPages}-name" name="transaction-name-${noOfPages}" placeholder="${placeholder_text_JSON[r]['name']}" required></input></div>`
        var page_content_toupdate_price = `<div class="col m-3 transaction-${noOfPages}"><label for="transaction-price-${noOfPages}">Price (£)</label><input class="form-control" id="transaction-${noOfPages}-price" name="transaction-price-${noOfPages}" placeholder="${placeholder_text_JSON[r]['price']}" required></input></div>`
        var page_content_toupdate_category = `<div class="col m-3 transaction-${noOfPages}"><label for="transaction-category-${noOfPages}">Category</label><input class="form-control" id="transaction-${noOfPages}-category" name="transaction-category-${noOfPages}" placeholder="${placeholder_text_JSON[r]['category']}" required></input></div>`
        var page_content_toupdate_subcategory = `<div class="col m-3 transaction-${noOfPages}"><label for="transaction-subcategory-${noOfPages}">Subcategory</label><input class="form-control" id="transaction-${noOfPages}-subcategory" name="transaction-subcategory-${noOfPages}" placeholder="${placeholder_text_JSON[r]['subcategory']}" required></input></div>`
        var page_content_toupdate_source = `<div class="col m-3 transaction-${noOfPages}"><label for="transaction-source-${noOfPages}">Source</label><input class="form-control" id=transaction-${noOfPages}-source" name="transaction-source-${noOfPages}" placeholder="${placeholder_text_JSON[r]['source']}" required></input></div>`
        var page_content_toupdate_date = `<div class="col m-3 transaction-${noOfPages}"><label for="transaction-date-${noOfPages}">Date</label><input class="form-control" type="date" id="transaction-${noOfPages}-date" name="transaction-date-${noOfPages}" placeholder="" required></input></div>`
        var page_content_toupdate_description = `<div class="col m-3 transaction-${noOfPages}"><label for="transaction-description-${noOfPages}">Description (optional)</label><input class="form-control" id="transaction-${noOfPages}-description" name="transaction-description-${noOfPages}" placeholder="${placeholder_text_JSON[r]['description']}" required></input></div>`

        //var baseStringArray = ['#transaction-name-', '#transaction-price-', '#transaction-category-', '#transaction-subcategory-', '#transaction-source-', 'transaction-date-', 'transaction-description-']
        

        //for (let i = 0; i < baseStringArray.length; i++) {
        //    $(baseStringArray[i] + pageNumber).text("Page " + pageNumber + " out of " + noOfPages)
        //} 
        
        // Name and Price
        $("#input-field-1").append(page_content_toupdate_name)
        $("#input-field-1").append(page_content_toupdate_price)

        // Category and Subcategory
        $("#input-field-2").append(page_content_toupdate_category)
        $("#input-field-2").append(page_content_toupdate_subcategory)

        // Source and Date
        $("#input-field-3").append(page_content_toupdate_source)
        $("#input-field-3").append(page_content_toupdate_date)

        // Description
        $("#input-field-4").append(page_content_toupdate_description)
        

        //var transaction_stuff = $(`[class^='transaction-']`).not(`[class^='transaction-${pageNumber}']`);

    }

    function storePageContent() {
        


    }

    function updatePageContents() {

        // FOR ALL Pages except the selected one, do not display them.
        var transaction_list = $(`div[class^="transaction-"],[class*="transaction-"]`).not(`.transaction-${pageNumber}`);
                
        for (let item of transaction_list) {
            $(item).addClass('d-none');
        }

        // Remove the display none class from the selected page.
        $(`.transaction-${pageNumber}`).removeClass('d-none');

    }

    function prevPage() {
        if (pageNumber_index > 0) {
         // If the page number basically isn't one, go to the previous page.
         pageNumber_index -= 1
         pageNumber = page_numbers[pageNumber_index]
       } else {
         // If Page Number is less than 1, go to the most recent page. THIS IS INTENDED so the user doesn't have to click a lot of times to get to a certain page.
         pageNumber_index = page_numbers.length-1 //page_numbers.slice(-1)[0]-1;
         pageNumber = page_numbers[pageNumber_index];
       }
      updatePageNumber()
      updatePageContents()
      
      console.log(page_numbers)
      console.log(pageNumber, pageNumber_index)
      console.log('Previous page.')

    }

    function updatePageLength() {
        //noOfPages = page_numbers.length;
    }

    function newPage() {
        
        noOfPages += 1;
        //pageNumber = noOfPages;
        //pageNumber_index = noOfPages;
        page_numbers.push(noOfPages)
        
        updatePageLength()

        console.log('NEW PAGE', page_numbers)

        updatePageNumber()
        createNewPage()
        updatePageContents()
        updatePagesList()
    }
 
    function nextPage() {
       if (pageNumber_index >= 0 && pageNumber_index < noOfPages-pageBalancer) {
         pageNumber_index += 1
         pageNumber = page_numbers[pageNumber_index]
       } else {
         pageNumber_index = 0;
         pageNumber = page_numbers[pageNumber_index]
       }
       updatePageNumber()
       updatePageContents()

       console.log(page_numbers)
       console.log(pageNumber, pageNumber_index, noOfPages-pageBalancer)
       console.log('Next page.')
    }

    function deletePage() {
        if (noOfPages == 1) {
            // You can't delete any more pages silly!
        } else {
            $(`.transaction-${pageNumber}`).remove()
            
            page_numbers.splice(pageNumber-1,1)

            updatePageLength()

            console.log(page_numbers)

            //noOfPages -= 1
            if (pageNumber != 1) {
                pageNumber -= 1
            }

            //pageNumber_index = pageNumber.length-1

            console.log(pageNumber, pageNumber_index, noOfPages-pageBalancer)

            pageBalancer += 1
            
            updatePageContents()
            updatePageNumber()
            updatePagesList()
            

            
        }
    }

    function updatePagesList() {
        document.getElementById('pages').value = page_numbers
    }

    function createNewSidebar() {

    }

    function viewCategory() {
        
    }

    ////////////////////////////////////////////

    $("#transaction-add-btn, #transaction-edit-btn, #transaction-delete-btn, #transaction-view-btn").click(function() {
        //console.log('Clicked')
        
        if($('#transaction-add-btn').is(':checked')) {
            $(".add_transaction_form").removeClass("d-none");
        //$("#transaction-add-btn").toggleClass("selected-orange");
        } else {
            $(".add_transaction_form").addClass("d-none");
        }

        if($('#transaction-edit-btn').is(':checked')) {
            $(".edit_transaction_form").removeClass("d-none");
        //$("#transaction-add-btn").toggleClass("selected-orange");
        } else {
            $(".edit_transaction_form").addClass("d-none");
        }

        if($('#transaction-delete-btn').is(':checked')) {
            $(".delete_transaction_form").removeClass("d-none");
        //$("#transaction-add-btn").toggleClass("selected-orange");
        } else {
            $(".delete_transaction_form").addClass("d-none");
        }

        if($('#transaction-view-btn').is(':checked')) {
            $(".view_transaction_form").removeClass("d-none");
        //$("#transaction-add-btn").toggleClass("selected-orange");
        } else {
            $(".view_transaction_form").addClass("d-none");
        }

        updateMethod()
    });

    // View Category Button
    $("#view-category-btn-add, #view-category-btn-edit").click(function() {
        if($('#transaction-add-btn').is(':checked')) {
            
            $(".add_transaction_form").addClass("d-none");
            
            $(".view_category_form").removeClass("d-none");
            
            // Modify Text Color
            var textColor_div = document.getElementById("sample-category-container");
            var textColor = $("#category-color-text-1").val(); 

            textColor_div.style.color = textColor;


            // Modify Category Color
            var categoryColor = document.getElementById("sample-category-container");

            var orientation = '151deg';
            var colorOne = '#ffffff';
            var colorTwo = $("#category-color-bg-1").val();  

            categoryColor.style.backgroundImage = `-moz-linear-gradient(${orientation}, ${colorOne}, ${colorTwo})`


            // Modify Icon Chosen
            var icon_div = document.getElementById('view-category-icon')
            
            //var iconChosen = $("#select-category-icon").val();

            //var iconChosen = document.getElementById("select-category-icon").getAttribute("icon");

            var iconChosen = $('#select-category-icon option:selected').attr('icon');

            $("#view-category-icon").removeClass("fa-money-bill-alt");

            $("#view-category-icon").text(iconChosen);

            // Modify Text Title
            var textValue = $('#category-name-1').val()

            $("#view-category-text").text(textValue);


        //$("#transaction-add-btn").toggleClass("selected-orange");
        } else {
            $(".add_transaction_form").addClass("d-none");
        }  

        // If Transaction Edit Mode Is Checked

        if($('#transaction-edit-btn').is(':checked')) {
            $(".edit_transaction_form").addClass("d-none");
            
            $(".view_category_form").removeClass("d-none");
            
            // Modify Text Color
            var textColor_div = document.getElementById("sample-category-container");
            var textColor = $("#category-color-text-1-edit").val(); 

            textColor_div.style.color = textColor;


            // Modify Category Color
            var categoryColor = document.getElementById("sample-category-container");

            var orientation = '151deg';
            var colorOne = '#ffffff';
            var colorTwo = $("#category-color-bg-1-edit").val();  

            categoryColor.style.backgroundImage = `-moz-linear-gradient(${orientation}, ${colorOne}, ${colorTwo})`


            // Modify Icon Chosen
            var icon_div = document.getElementById('view-category-icon')
            
            //var iconChosen = "&" + $("#select-category-icon-edit").val() + ";";

            var iconChosen = $('#select-category-icon-edit option:selected').attr('icon');
            $("#view-category-icon").removeClass("fa-money-bill-alt");

            $("#view-category-icon").text(iconChosen);

            // Modify Text Title
            var textValue = $('#category-name-1-edit').val()

            $("#view-category-text").text(textValue);

        }
    });


    $("#view-category-back-btn").click(function() {
        if($('#transaction-add-btn').is(':checked')) {
            
            $(".add_transaction_form").removeClass("d-none");
            
            $(".view_category_form").addClass("d-none");

        
            //$("#transaction-add-btn").toggleClass("selected-orange");
        } //else {
          //  $(".add_transaction_form").addClass("d-none");
        //}

        if($('#transaction-edit-btn').is(':checked')) {
            
            $(".edit_transaction_form").removeClass("d-none");
            
            $(".view_category_form").addClass("d-none");

        
            //$("#transaction-add-btn").toggleClass("selected-orange");
        } //else {
           // $(".add_transaction_form").addClass("d-none");
        //}
    });
    
    function updateMethod() {
        var AddCategoryRadio = document.getElementById("transaction-add-btn");

        var EditCategoryRadio = document.getElementById("transaction-edit-btn");

        if (AddCategoryRadio.checked) {
            console.log('Edit Category radio is checked!')

            document.getElementById("CATEGORY_METHOD").setAttribute("value", "POST")
            document.getElementById("THE-FORM").setAttribute("action", "/budgeting-app/app/categories")
        }

        

        if (EditCategoryRadio.checked) {
            console.log('Edit Category radio is checked!')

            document.getElementById("CATEGORY_METHOD").setAttribute("value", "PUT")
            //document.getElementById("THE-FORM").setAttribute("action", `/budgeting-app/app/categories/${category['id']}`)
        }

    }

    /*
    function editCategoryFields(id) {
        console.log('ECF ' + id);
        
        //document.getElementById('category-name-1-edit').setAttribute("value", "text");

        // Subtract id by 1 since JSON indexing starts at 0

        console.log(category);

        $('#category-name-1-edit').val(`${category['name']}`);
        
        $('#category-color-bg-1-edit').val(`${category['color-bg']}`);

        $('#category-color-text-1-edit').val(`${category['color-text']}`);

        var iconCode = category['icon-code']

        // The first and last characters are sliced so that the icon code can change.
        var _iconCode = iconCode.slice(0, -1) 
        _iconCode = _iconCode.slice(1)

        console.log(_iconCode);
        
        $('#select-category-icon-edit').val(`${_iconCode}`).change();

        // Prepare THE FORM to edit the appropriate category.

        document.getElementById("CATEGORY_METHOD").setAttribute("value", "PUT")
        document.getElementById("THE-FORM").setAttribute("action", `/budgeting-app/app/categories/${category['id']}`)

    }
    */
    function editFormAction(id) {
        //document.getElementById("CATEGORY_METHOD").setAttribute("value", "PUT")
        var start_date = $('#input-date-start').val();

        var end_date = $('#input-date-end').val();

        document.getElementById("THE-FORM").setAttribute("action", `/budgeting-app/app/statistics/${id}/${start_date}/${end_date}`)
    }

    

    TESTER = document.getElementById('transaction_dates_graph');

    var layout = {

    title:'Line and Scatter Plot'

    };

    var data = [

    {

        x: ['2013-10-04 22:23:00', '2013-11-04 22:23:00', '2013-12-04 22:23:00'],

        y: [1, 3, 6],

        type: 'scatter'

    }

    ];


    Plotly.newPlot(TESTER, data, layout);

    


</script>

@isset($daily_graph_labels, $daily_graph_data)

<script>
    const ctx = document.getElementById('spendingByDay').getContext('2d');
          
    if (document.getElementById('spendingByDay').style.width <= 600 || document.getElementById('spendingByDay').style.height <= 600) {
    ctx.canvas.width = document.getElementById('spendingByDay').style.width;
    ctx.canvas.height = document.getElementById('spendingByDay').style.height;
    } else {
    ctx.canvas.width = 600;
    ctx.canvas.height = 600;
    }

    var chartdata = {
                labels: {{ Js::from($daily_graph_labels) }},
                datasets: [
                    {
                        label: 'Money Spent (£)',
                        backgroundColor: "#008000",
                        borderColor: '#46d5f1',
                        hoverBackgroundColor: '#CCCCCC',
                        hoverBorderColor: '#666666',
                        data: {{ Js::from($daily_graph_data) }}
                    }
                ],
            };
    
    var graphTarget = $("#spendingByDay");

    var barGraph = new Chart(graphTarget, {
        type: 'bar',
        data: chartdata
    });
</script>

@endisset

</html>