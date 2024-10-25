<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MyLifeline - Create Transaction</title>

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
    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">

    
</head>
<body>
    <div class="bg-green-50 h-screen font-MontserratRegular" id="app">
        <x-navbar-complete brandName='MyBudget' />

        @isset($success_message_delete)

            <h1 class="success-message" style="text-align: center; background-color: green; color: white; padding: 20px;"><i class="fas fa-check-circle"></i> Successfully deleted {{$success_message_delete->name}}!</h1>

        @endisset

        @isset($success_message_undo)

        <h1 class="success-message" style="text-align: center; background-color: green; color: white; padding: 20px;"><i class="fas fa-check-circle"></i> Undo deletion: {{$success_message_delete->name}} Successful!</h1>

        @endisset
    
        
        @isset($data)

            @for($i = 0; $i < count($data['names']); $i++)

               <!-- If First Iteration -->
               @if($i == 0)
                <h1 style='text-align: center; background-color: green; color: white; padding: 20px;'><i class="fas fa-check-circle"></i>Transactions Successfully Added!</h1>
                    <table class='table success-transactions-table'>
                        <thead>
                            <tr>
                                <th scope='col'>#</th>
                                <th scope='col'>Name</th>
                                <th scope='col'>Price</th>
                                <th scope='col'>Category</th>
                                <th scope='col'>Subcategory</th>
                                <th scope='col'>Date</th>
                                <th scope='col'>Source</th>
                                <th scope='col'>Description</th>
                            </tr>
                        </thead>
                        <tbody>

               @endif
               
               <tr>
                <th scope='row'>{{$i+1}}</th>
                <td>{{$data['names'][$i]}}</td>
                <td>£{{number_format($data['prices'][$i], 2)}}</td>
                <td>{{$data['categories'][$i]}}</td>
                <td>{{$data['subcategories'][$i]}}</td>
                <td>{{date('d/m/Y', strtotime($data['dates'][$i]))}}</td>
                <td>{{$data['sources'][$i]}}</td>
                <td>{{$data['descriptions'][$i]}}</td>
               </tr>

            @endfor
                
            </tbody>
        </table>

        @endisset

        <div class="container-fluid h-full">
            {{-- <div class="transactions-sidebar hidden" id="transactions-sidebar-id"></div> --}}
            
            <form method="POST" action="{{ config('app.url')}}/budgeting-app/app/" class="form-transaction my-3 flex flex-col justify-between max-h-[600px] overflow-y-scroll" id="THE-FORM">
                @csrf
                <div class="form container m-3">
                    <div class="row transactions-title">
                        <div class="col-9 text-left">
                            <h3 class="form-transaction_title">TRANSACTIONS</h3>
                        </div>

                        <div class="col text-center">
                            <i class="fas fa-cash-register"></i>
                        </div>
                    </div>
                    
                    <div class="row transaction_descriptor">
                        <div class="col text-left"><p>1. What do you want to do? (Select One)</p></div>
                    </div>

                    <div class="row flex-col md:flex-row transaction_selection_buttons">
                        <div class="col"><input type="radio" id="transaction-add-btn" name="transaction-mode-select"><label for="transaction-add-btn">Add Transaction</label></div>
                        <!--<div class="col"><input type="radio" id="transaction-edit-btn" name="transaction-mode-select" disabled><label for="transaction-edit-btn">Edit</label></div>-->
                        <!--<div class="col"><input type="radio" id="transaction-delete-btn" name="transaction-mode-select" disabled><label for="transaction-delete-btn">Delete</label></div>-->
                        <div class="col"><input type="radio" id="transaction-view-btn" name="transaction-mode-select"><label for="transaction-view-btn">View/Edit/Delete</label></div>
                    </div>
                </div>

                <div class="add_transaction_form d-none [&>div]:gap-2">
                    
                    <div class="transactions-list hidden flex flex-col gap-3 md:w-1/2 mx-auto" id="transactions-list"></div>

                    <!-- Text Title --> 
                    {{-- <div class="row text-center"><p>Add Transaction</p></div> --}}


                    <div class="flex flex-col md:hidden" id="transactions-list">
            
                        <!--
                        <div id="transaction-sb-1" class="sb-selected">
                            <p class="transactions-sb-name">Baked Beans</p>
                            <div class="transaction-sb-subtitles-1">
                                <p class="transactions-sb-number" style="text-align: left;">#1</p>
                                <p class="transactions-sb-price" style="text-align: right;">£0.49</p>
                            </div>
                        </div>

                        <div id="transaction-sb-2">
                            <p class="transactions-sb-name">Gaming PC</p>
                            <div class="transaction-sb-subtitles-1">
                                <p class="transactions-sb-number" style="text-align: left;">#2</p>
                                <p class="transactions-sb-price" style="text-align: right;">£750.00</p>
                            </div>
                        </div>
                        -->

                        
                    </div>
                    

                    <div id="add-input-container" class="flex flex-col">
                        <!-- Transaction To Add -->
                        <div class="row flex-col md:flex-row md:gap-3" id="input-field-1">
                            <div class="col transaction-1"><label for="transaction-name-1">Name</label><input class="form-control" id="transaction-name-1" name="transaction-name-1" placeholder="Frozen Peas" ></div>
                            <div class="col transaction-1"><label for="transaction-price-1">Price (£)</label><br><span class="pound-sign form-control">£<input class="" style="width: 90%;" id="transaction-price-1" name="transaction-price-1" placeholder="0.79" /></span></div>
                        </div>
                        <div class="row flex-col md:flex-row md:gap-3" id="input-field-2">


                            <div class="col transaction-1"><label for="transaction-category-1">Category</label>
                            <select class="form-select" id="transaction-category-1" name="transaction-category-1" index="1" placeholder="Groceries">
                            
                                    {{-- @isset($categories)
                                        @foreach($categories as $category)
                                            <option value={{$category->id}}>{{$category->name}}</option>
                                        @endforeach
                                    @endisset --}}

                                    {{-- @php

                                    echo $groupedData;

                                    @endphp --}}

                                    @isset($groupedData)

                                        @foreach ($groupedData as $key => $value)
                                            @foreach($value as $key_ii => $category)
                                                <optgroup label="{{ $category[0]->category_name }}">
                                                    @foreach ($category as $section)
                                                        <option value="{{ $section->section_id }}">{{ $section->section_name }}</option>
                                                    @endforeach
                                                </optgroup>
                                            @endforeach
                                        @endforeach

                                    @else

                                        <option value="NO GroupedData Found">Error</option>

                                    @endisset
                            </select>

                            
                            </div>
                            <div class="col transaction-1">

                            <label for="transaction-source-1">Source</label><input class="form-control" id="transaction-source-1" name="transaction-source-1" placeholder="Aldi" ></input></label>          
                                <!--
                                <label for="transaction-subcategory-1">Subcategory</label>
                                <input class="form-control" id="transaction-subcategory-1" name="transaction-subcategory-1" placeholder="Frozen Food" >
                                -->
                                {{-- 
                                <label for="transaction-subcategory-1">Subcategory</label>

                                <select name="transaction-subcategory-1" class="form-select" id="transaction-subcategory-1" index="1" required>

                                </select> --}}
                            </div>
                        </div>
                        <div class="row flex-col md:flex-row md:gap-3" id="input-field-3">
                            <div class="col transaction-1"><label for="transaction-date-1">Date</label><input type="date" class="form-control" id="transaction-date-1" name="transaction-date-1" placeholder="23-01-2022" ></input></div>
                            <div class="col transaction-1"><label for="transaction-description-1">Description</label><input class="form-control" id="transaction-description-1" name="transaction-description-1" placeholder="Worth half the price of fresh peas!"></input></div>
                        </div>

                        {{-- <div class="row" id="input-field-4">
                            <div class="col m-3 transaction-1"><label for="transaction-description-1">Description</label><input class="form-control" id="transaction-description-1" name="transaction-description-1" placeholder="Worth half the price of fresh peas!"></input></div>
                        </div> --}}
                    </div>
                        

                     
                    <div class="control-buttons flex flex-col gap-3">
                            {{-- <div class="col text-center clear-btn">
                                <input type="reset" class="btn btn-danger" value="CLEAR">
                                <button type="button" class="btn btn-danger" id="delete-page-btn" onclick="deletePage()"><i class="fas fa-trash-alt" aria-hidden="true"></i></button>
                            </div> --}}
                            <button class="bg-blue-500 text-white text-center p-3 mt-3 mx-auto rounded-full" id="view-list-btn" onclick="goTo_mobileSidebar()" type="button">VIEW LIST</button>

                            <div class="col flex text-center control-advanced-buttons gap-2 justify-center">
                                <button type="button" class="btn btn-success" id="previous-page-btn" onclick="prevPage()"><i class="fas fa-arrow-left" aria-hidden="true"></i></button>
                                <button type="button" class="btn btn-success" id="add-transaction-btn" onclick="newPage()"><i class="fas fa-plus" aria-hidden="true"></i></button>
                                <button type="button" class="btn btn-success" id="next-page-btn" onclick="nextPage()"><i class="fas fa-arrow-right" aria-hidden="true"></i></button>
                            </div>

                            <div class="col flex-col md:flex-row text-center submit-btn">
                                <input type="hidden" id="pages" name="transaction-pages" value="1">
                                <input type="hidden" id="THE-FORM-DATA" name="THE-FORM-DATA" value="">                                <button type="submit" class="btn btn-success w-full">SUBMIT</button>
                            </div>
                    
                             <div class="row text-center">
                                <p style="font-style: italic" id="page-number-text">Page 1 out of 1</p>
                            </div>   
                    </div>       

                        
                </div>

               
            <div class="edit_transaction_form d-none">
                <p class="text-center">WIP</p>
            </div>

            <div class="delete_transaction_form d-none">
                <p class="text-center">WIP</p>
            </div>

            <div class="view_transaction_form d-none md:max-w-[900px] mx-auto overflow-y-scroll">

                    <div class="filter_transaction_form">

                        <label for="filter-transaction-select" class="text-center">Select column</label>

                        <select class="form-select" id="filter-transaction-select" name="filter-transaction-select">
                            <option value="mybudget_item.id">ID</option>
                            <option value="mybudget_item.name" selected>Name</option>
                            <option value="mybudget_item.price">Price</option>
                            <option value="category_name">Category</option>
                            <option value="section_name">Subcategory</option>
                            <option value="source_name">Source</option>
                        </select>


                        <label for="filter-transaction-search" class="text-center">Search within that column</label>
                        <input type="text" class="form-input" id="filter-transaction-search" name="filter-transaction-search"/>

                        <button type="submit" id="search-transaction-button" class="btn btn-primary"><i class="fas fa-search"></i> SEARCH</button>


                    </div>



                    <table class='table view_transaction_table' id="TRANSACTION_TABLE">
                        <thead>
                            <tr>
                                <th scope='col' class="mobile-none">#</th>
                                <th scope='col'>Name</th>
                                <th scope='col'>Price</th>
                                <th scope='col' class="mobile-none">Category</th>
                                <th scope='col' class="mobile-none">Subcategory</th>
                                <th scope='col'>Date</th>
                                <th scope='col' class="mobile-none">Source</th>
                                <th scope='col'>Action</th>
                                <!-- <th scope='col'>Description</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            
                    @foreach($transactions as $transaction)
                        <tr>
                            

                            @if (!empty($transaction->deleted_at))
                                <td colspan="1" style="opacity: 0.4">{{$transaction->id}}</td>
                                <td colspan="7" style="opacity: 0.4"> TRANSACTION {{$transaction->name}} DELETED. Click <a href="{{ config('app.url')}}/budgeting-app/app/transactions/delete_undo/{{$transaction->id}}">here</a> to undo. </td>

                            @else
                                <th class="mobile-none">{{$transaction->id}}</th>
                                
                                @if($transaction->has_subtransactions == 1 || $transaction->has_subtransactions == true)
                                <td class="mobile-viewable">{{$transaction->name}}*</td>
                                @else
                                <td class="mobile-viewable">{{$transaction->name}}</td>
                                @endif
                                
                                <!-- If Price is Below £1000, Show Price to Two decimal places -->
                                @if((int)$transaction->price < 1000)
                                <td class="mobile-viewable">£{{number_format($transaction->price, 2)}}</td>
                                @else
                                <td class="mobile-viewable">£{{$transaction->price}}</td>
                                @endif
                                
                                <td class="mobile-none">{{$transaction->category_name}}</td>
                                
                                <td class="mobile-none">{{$transaction->section_name}}</td>
                                
                                <td class="mobile-viewable">{{date('d/m/Y', strtotime($transaction->created_at))}}</td>
                                
                                <td class="mobile-none">{{$transaction->source_name}}</td>

                                <td>
                                    <!-- Edit Transaction Button -->
                                    <a class="btn btn-warning" href="{{ config('app.url')}}/budgeting-app/app/transactions/edit/{{$transaction->id}}" type="submit"><i class="fas fa-pencil-alt"></i></a>
                                    
                                    <!-- Delete Transaction Button -->
                                    <a class="btn btn-danger" href="{{ config('app.url')}}/budgeting-app/app/transactions/delete/{{$transaction->id}}" type="submit"><i class="fas fa-trash-alt"></i></a>
                                    
                                    <!-- More Details Button -->
                                    <a class="btn btn-primary" href="{{ config('app.url')}}/budgeting-app/app/transactions/show/{{$transaction->id}}" type="submit"><i class="fas fa-plus"></i></a>
                                </td>
                            <!-- <td>{{-- $transaction->description --}}</td> -->                 
                            @endif
                
                        </tr>

                        @endforeach
                    </tbody>
                    </table>

                    <div class="THE_PAGINATION" style="text-align: center;">

                        
                        {{$transactions->links()}}


                    </div>

                </div>

            </div>


        

            </div>    


            
            
        </form>


            <!--
            <div id="transaction-sb-1" class="sb-selected">
                <p class="transactions-sb-name">Baked Beans</p>
                <div class="transaction-sb-subtitles-1">
                    <p class="transactions-sb-number" style="text-align: left;">#1</p>
                    <p class="transactions-sb-price" style="text-align: right;">£0.49</p>
                </div>
            </div>

            <div id="transaction-sb-2">
                <p class="transactions-sb-name">Gaming PC</p>
                <div class="transaction-sb-subtitles-1">
                    <p class="transactions-sb-number" style="text-align: left;">#2</p>
                    <p class="transactions-sb-price" style="text-align: right;">£750.00</p>
                </div>
            </div>
            -->

        </div>

    </div>
    </div>
    
    <!-- ADVANCED: Create a sidebar which tracks your pages
    <div class="d-flex flex-column align-items-stretch flex-shrink-0 bg-white position-absolute top-0 end-0" style="width: 380px;">
    <a href="/" class="d-flex align-items-center flex-shrink-0 p-3 link-dark text-decoration-none border-bottom">
      <svg class="bi me-2" width="30" height="24"><use xlink:href="#bootstrap"></use></svg>
      <span class="fs-5 fw-semibold">List group</span>
    </a>
    <div class="list-group list-group-flush border-bottom scrollarea">
      <a href="#" class="list-group-item list-group-item-action active py-3 lh-tight" aria-current="true">
        <div class="d-flex w-100 align-items-center justify-content-between">
          <strong class="mb-1">List group item heading</strong>
          <small>Wed</small>
        </div>
        <div class="col-10 mb-1 small">Some placeholder content in a paragraph below the heading and date.</div>
      </a>
      <a href="#" class="list-group-item list-group-item-action py-3 lh-tight">
        <div class="d-flex w-100 align-items-center justify-content-between">
          <strong class="mb-1">List group item heading</strong>
          <small class="text-muted">Tues</small>
        </div>
        <div class="col-10 mb-1 small">Some placeholder content in a paragraph below the heading and date.</div>
      </a>
      <a href="#" class="list-group-item list-group-item-action py-3 lh-tight">
        <div class="d-flex w-100 align-items-center justify-content-between">
          <strong class="mb-1">List group item heading</strong>
          <small class="text-muted">Mon</small>
        </div>
        <div class="col-10 mb-1 small">Some placeholder content in a paragraph below the heading and date.</div>
      </a>

      <a href="#" class="list-group-item list-group-item-action py-3 lh-tight" aria-current="true">
        <div class="d-flex w-100 align-items-center justify-content-between">
          <strong class="mb-1">List group item heading</strong>
          <small class="text-muted">Wed</small>
        </div>
        <div class="col-10 mb-1 small">Some placeholder content in a paragraph below the heading and date.</div>
      </a>
      <a href="#" class="list-group-item list-group-item-action py-3 lh-tight">
        <div class="d-flex w-100 align-items-center justify-content-between">
          <strong class="mb-1">List group item heading</strong>
          <small class="text-muted">Tues</small>
        </div>
        <div class="col-10 mb-1 small">Some placeholder content in a paragraph below the heading and date.</div>
      </a>
      <a href="#" class="list-group-item list-group-item-action py-3 lh-tight">
        <div class="d-flex w-100 align-items-center justify-content-between">
          <strong class="mb-1">List group item heading</strong>
          <small class="text-muted">Mon</small>
        </div>
        <div class="col-10 mb-1 small">Some placeholder content in a paragraph below the heading and date.</div>
      </a>
      <a href="#" class="list-group-item list-group-item-action py-3 lh-tight" aria-current="true">
        <div class="d-flex w-100 align-items-center justify-content-between">
          <strong class="mb-1">List group item heading</strong>
          <small class="text-muted">Wed</small>
        </div>
        <div class="col-10 mb-1 small">Some placeholder content in a paragraph below the heading and date.</div>
      </a>
      <a href="#" class="list-group-item list-group-item-action py-3 lh-tight">
        <div class="d-flex w-100 align-items-center justify-content-between">
          <strong class="mb-1">List group item heading</strong>
          <small class="text-muted">Tues</small>
        </div>
        <div class="col-10 mb-1 small">Some placeholder content in a paragraph below the heading and date.</div>
      </a>
      <a href="#" class="list-group-item list-group-item-action py-3 lh-tight">
        <div class="d-flex w-100 align-items-center justify-content-between">
          <strong class="mb-1">List group item heading</strong>
          <small class="text-muted">Mon</small>
        </div>
        <div class="col-10 mb-1 small">Some placeholder content in a paragraph below the heading and date.</div>
      </a>
      <a href="#" class="list-group-item list-group-item-action py-3 lh-tight" aria-current="true">
        <div class="d-flex w-100 align-items-center justify-content-between">
          <strong class="mb-1">List group item heading</strong>
          <small class="text-muted">Wed</small>
        </div>
        <div class="col-10 mb-1 small">Some placeholder content in a paragraph below the heading and date.</div>
      </a>
      <a href="#" class="list-group-item list-group-item-action py-3 lh-tight">
        <div class="d-flex w-100 align-items-center justify-content-between">
          <strong class="mb-1">List group item heading</strong>
          <small class="text-muted">Tues</small>
        </div>
        <div class="col-10 mb-1 small">Some placeholder content in a paragraph below the heading and date.</div>
      </a>
      <a href="#" class="list-group-item list-group-item-action py-3 lh-tight">
        <div class="d-flex w-100 align-items-center justify-content-between">
          <strong class="mb-1">List group item heading</strong>
          <small class="text-muted">Mon</small>
        </div>
        <div class="col-10 mb-1 small">Some placeholder content in a paragraph below the heading and date.</div>
      </a>
    </div>
    -->
  </div>


<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
<script
			  src="https://code.jquery.com/jquery-3.6.0.js"
			  integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
			  crossorigin="anonymous"></script>
		
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

    var lastPageSelected = 1;
    
    //var pageNumber_display = pageNumber_index + 1;
    var noOfPages = 1;


    // The Page Balancer: Weird name, but basically ensures that the nextPage function does not go out of page range.
    var pageBalancer = 1;

    var page_numbers = [1]

    var page_content = {}

    function updatePageNumber() {
        pageNumber_index += 1

        if (pageNumber_index > page_numbers.length) {
            pageNumber_index -= 1;
        }

        $("#page-number-text").text("Page " + pageNumber_index + " out of " + page_numbers.length)
        pageNumber_index -= 1
    }

    function createNewPage() {

        var page_content_toupdate_name = `<div class="col transaction-${noOfPages}"><label for="transaction-name-${noOfPages}">Name</label><input class="form-control" id="transaction-name-${noOfPages}" name="transaction-name-${noOfPages}" placeholder="${placeholder_text_JSON[r]['name']}" required /></div>`
        var page_content_toupdate_price = `<div class="col transaction-${noOfPages}"><label for="transaction-price-${noOfPages}">Price (£)</label><span class="pound-sign form-control">£<input style="width: 90%;" class="" id="transaction-price-${noOfPages}" name="transaction-price-${noOfPages}" placeholder="${placeholder_text_JSON[r]['price']}" required /></span></div>`
        //var page_content_toupdate_category = `<div class="col m-3 transaction-${noOfPages}"><label for="transaction-category-${noOfPages}">Category</label><input class="form-control" id="transaction-category-${noOfPages}" name="transaction-category-${noOfPages}" placeholder="${placeholder_text_JSON[r]['category']}" required></input></div>`


        /* 
        
        TO COPY THE CATEGORY AND SUBCATEGORIES, WE HAVE TO CLONE THE TRANSACTION AND SUBTRANSACTION SELECTORS WITH JAVASCRIPT.

        */

        var page_content_toupdate_category = document.querySelector('#transaction-category-1');

        var page_content_toupdate_category_clone = page_content_toupdate_category.cloneNode(true);

        page_content_toupdate_category_clone.id = `transaction-category-${noOfPages}`;

        page_content_toupdate_category_clone.setAttribute('name', `transaction-category-${noOfPages}`);

        page_content_toupdate_category_clone.setAttribute('index', `${noOfPages}`)

        page_content_toupdate_category_clone = `<div class="col transaction-${noOfPages}"><label for="transaction-category-${noOfPages}">Category</label>` + page_content_toupdate_category_clone.outerHTML + `</div>`;



        //page_content_toupdate_category_clone = `<div class="col m-3 transaction-${noOfPages}"><label for="transaction-category-${noOfPages}">Category</label> ` + page_content_toupdate_category_clone + `</div>`




        // var page_content_toupdate_subcategory = `<div class="col m-3 transaction-${noOfPages}"><label for="transaction-subcategory-${noOfPages}">Subcategory</label><input class="form-control" id="transaction-subcategory-${noOfPages}" index="${noOfPages}" name="transaction-subcategory-${noOfPages}" placeholder="${placeholder_text_JSON[r]['subcategory']}" required></input></div>`

        // var page_content_toupdate_subcategory = document.querySelector(`#transaction-subcategory-1`);

        // var page_content_toupdate_subcategory_clone = page_content_toupdate_subcategory.cloneNode(true);

        // page_content_toupdate_subcategory_clone.id = `transaction-subcategory-${noOfPages}`;

        // page_content_toupdate_subcategory_clone.setAttribute('name', `transaction-subcategory-${noOfPages}`);

        // page_content_toupdate_subcategory_clone.setAttribute('index', `${noOfPages}`)

        // page_content_toupdate_subcategory_clone = `<div class="col m-3 transaction-${noOfPages}"><label for="transaction-category-${noOfPages}">Subcategory</label>` + page_content_toupdate_subcategory_clone.outerHTML + `</div>`;




        var page_content_toupdate_source = `<div class="col transaction-${noOfPages}"><label for="transaction-source-${noOfPages}">Source</label><input class="form-control" id=transaction-source-${noOfPages}" name="transaction-source-${noOfPages}" placeholder="${placeholder_text_JSON[r]['source']}" required></input></div>`
        var page_content_toupdate_date = `<div class="col transaction-${noOfPages}"><label for="transaction-date-${noOfPages}">Date</label><input class="form-control" type="date" id="transaction-date-${noOfPages}" name="transaction-date-${noOfPages}" placeholder="" required></input></div>`
        var page_content_toupdate_description = `<div class="col transaction-${noOfPages}"><label for="transaction-description-${noOfPages}">Description</label><input class="form-control" id="transaction-description-${noOfPages}" name="transaction-description-${noOfPages}" placeholder="${placeholder_text_JSON[r]['description']}"></input></div>`

        //var baseStringArray = ['#transaction-name-', '#transaction-price-', '#transaction-category-', '#transaction-subcategory-', '#transaction-source-', 'transaction-date-', 'transaction-description-']
        

        //for (let i = 0; i < baseStringArray.length; i++) {
        //    $(baseStringArray[i] + pageNumber).text("Page " + pageNumber + " out of " + noOfPages)
        //} 
        
        // Name and Price
        $("#input-field-1").append(page_content_toupdate_name)
        $("#input-field-1").append(page_content_toupdate_price)

        // Category and Subcategory
        $("#input-field-2").append(page_content_toupdate_category_clone)
        $("#input-field-2").append(page_content_toupdate_source)

        // Source and Date
        $("#input-field-3").append(page_content_toupdate_date)
        $("#input-field-3").append(page_content_toupdate_description)

        // Description
        // $("#input-field-4").append(page_content_toupdate_description)
        

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

      updateSidebar()
      
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

        console.log('NO OF PAGES', noOfPages)

        updatePageNumber()
        createNewPage()
        updatePageContents()
        updatePagesList()
        createNewSidebar()
        createNewSidebar_mobile()

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

       updateSidebar()

       console.log(page_numbers)
       console.log(pageNumber, pageNumber_index, noOfPages-pageBalancer)
       console.log('Next page.')
    }

    function deletePage() {
        if (noOfPages == 1) {
            // You can't delete any more pages silly!
        } else {
            $(`.transaction-${pageNumber}`).remove()

            $(`#transaction-sb-${pageNumber}`).remove()
            
            page_numbers.splice(pageNumber-1,1)

            updatePageLength()

            console.log(page_numbers)

            //noOfPages -= 1
            if (pageNumber != 1) {
                pageNumber -= 1
            }

            //pageNumber_index = pageNumber.length-1

            console.log(pageNumber, pageNumber_index, noOfPages-pageBalancer, page_numbers)

            pageBalancer += 1
            
            updatePageContents()
            updatePageNumber()
            updatePagesList()
            

            
        }
    }

    function updatePagesList() {
        document.getElementById('pages').value = page_numbers
    }

    function updateSidebar() {

        $(`#transactions-sb-name-${lastPageSelected}`).text($(`#transaction-name-${lastPageSelected}`).val())
        $(`#transactions-sb-price-${lastPageSelected}`).text($('£' + `#transaction-price-${lastPageSelected}`).val())


        $(`#transaction-sb-${lastPageSelected}`).removeClass('sb-selected');
        
        lastPageSelected = pageNumber;

        $(`#transaction-sb-${pageNumber}`).addClass('sb-selected');


        //textToChange = $(`#transaction-name-${pageNumber}`).val()

        
        
        $(`#transactions-sb-name-${pageNumber}`).text($(`#transaction-name-${pageNumber}`).val())
        
        //$(`#transactions-sb-name-${pageNumber}`).text($(`#transaction-${pageNumber}-name`).val())

        $(`#transactions-sb-price-${pageNumber}`).text('£' + $(`#transaction-price-${pageNumber}`).val())

        //$(`#transactions-sb-price-${pageNumber}`).text('£' + $(`#transaction-${pageNumber}-price`).val())
    }

    function goToPage(page) {

        $(`#transaction-sb-${lastPageSelected}`).removeClass('sb-selected');

        pageNumber = page;
        pageNumber_index = page-1; 


        // essentially the same as UpdatePageNumber.
        $("#page-number-text").text("Page " + pageNumber + " out of " + page_numbers.length)

        $(`#transaction-sb-${pageNumber}`).addClass('sb-selected');
        
        lastPageSelected = pageNumber

        updatePageContents();

        updateSidebar();

    }

    function createNewSidebar() {
        var newSidebar = `<div class="mx-3" id="transaction-sb-${noOfPages}" onClick="goToPage(${noOfPages})">
                <p class="transactions-sb-name transactions-sb-name-${noOfPages}" id="transactions-sb-name-${noOfPages}">Number ${noOfPages}</p>
                <div class="transactions-sb-subtitles-${noOfPages}" id="transactions-sb-subtitles-${noOfPages}">
                    <p class="transactions-sb-number transactions-sb-number-${noOfPages}" id="transactions-sb-number-${noOfPages}">#${noOfPages}</p>
                    <p class="transactions-sb-price transactions-sb-price-${noOfPages} mr-3" id="transactions-sb-price-${noOfPages}">£0.00</p>
                </div>
            </div>
            `;
        
        // $('#transactions-sidebar-id').append(newSidebar);

        $('#transactions-list').append(newSidebar);
    }

    ////////////////////////////////////////////

    $("#transaction-add-btn, #transaction-edit-btn, #transaction-delete-btn, #transaction-view-btn").click(function() {
        console.log('Clicked')
        
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


    });

    function createNewSidebar_mobile() {
         console.log('Work in progress')
    }

    function goTo_mobileSidebar() {

        if($('#transactions-list').hasClass("hidden")) {

            $('#view-list-btn').text('BACK')

        } else {

            $('#view-list-btn').text('VIEW LIST')

        }



        // reason for invisible is to keep the container the same space as it was before toggling, so the back button's in the same spot. UX Experience.
        $('#add-input-container').toggleClass('invisible')
        $('#transactions-list').toggleClass('hidden')

        // $('#view-list-btn').toggleClass('hidden')

        
 

    }

    createNewSidebar()
    
    /*
    $("#transaction-add-btn").click(function() {
        document.getElementById("THE-FORM").setAttribute("action", "TESTOSTERONE2")
    });

    $("#transaction-view-btn").click(function() {
        document.getElementById("THE-FORM").setAttribute("action", "TESTOSTERONE")
    });
    */

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("#search-transaction-button").click(function(e) {
    e.preventDefault();
            
        var column_select_val = $('#filter-transaction-select').val();

        var column_search_val = $('#filter-transaction-search').val();

        $.ajax({
        
        type: "GET",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: `/budgeting-app/app/create/${column_select_val}/${column_search_val}`,
        
        success: function (data) {
                    $("#TRANSACTION_TABLE").html(data);
                    console.log('success!')
                }
        });

    });


    // $(document).ready(function() {
    // let debounceTimeout;
    // $(`[id^="transaction-category-"]`).on('click', function() {
    //         let debounceTimeout;
    //     clearTimeout(debounceTimeout);
    //     const button = this;
    //     debounceTimeout = setTimeout(function() {
    //         var id = button.value;
    //         var index = $(button).attr("index");
    //         var url = `/budgeting-app/app/getsubcategories/${id}`;

    //             $(`[id^="transaction-subcategory-${index}"]`).load(url);
    //         }, 300); // 300ms delay
    //     });
    // });

    $(document).ready(function() {

        $("#THE-FORM").on('submit', function(e) {

            e.preventDefault();

            var formDataArray = $(this).serializeArray();

            var formData = {};

            $.each(formDataArray, function() {
                formData[this.name] = this.value;
            });

            // Store JSON string in hidden input
            $('input[name="THE-FORM-DATA"]').val(JSON.stringify(formData));

            // Now allow the form to be submitted
            this.submit();
        });

        $

    });
    // $(document).ready(function() {
    //     $(`[id^="transaction-category-"]`).on('click', function(){
          
    //       var id = this.value;
    //       var index = $(this).attr("index");
    //       var url=`/budgeting-app/app/getsubcategories/${id}`;

    //       $(`[id^="transaction-subcategory-${index}"]`).load(url);
    //         });
    //     });

    
    
    // $(document).ready(function() {
    //  $('#add-transaction-btn').on('click', function() {
    //     $(`[id^="transaction-category-"]`).on('click', function(){
          
    //       var id = this.value;
    //       var index = $(this).attr("index");
    //       var url=`/budgeting-app/app/getsubcategories/${id}`;

    //       $(`[id^="transaction-subcategory-${index}"]`).load(url);
    //         });
    //     });
    // });
    

</script>

</html>