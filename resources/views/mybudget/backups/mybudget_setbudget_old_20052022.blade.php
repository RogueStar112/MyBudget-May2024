<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MyBudget - Statistics</title>

    <script src="https://kit.fontawesome.com/c36ba6cddf.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>

    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    

    <link href="{{ asset('css/mylifeline_home.css') }}" rel="stylesheet" type="text/css">
    <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>

</head>
<body>
    <div id="app">
        <x-navbar brandName="MyBudget" brandColor="green" >
            <x-slot name="items">
                <x-navbar-item url="/.." title="HOME" color="#198754" icon="home" />
                <div class="diagonal-divider"></div>
                <p style="color: white; margin-bottom: 0 !important;" class="skew10deg">APPS</p>
                <x-navbar-item url="/budgeting-app" title="BUDGET" color="green" icon="money-bill-alt" />
                <x-navbar-item url="/nutrition-app" title="HEALTH" color="orange" icon="dumbbell" />
                <x-navbar-item url="/journalling-app" title="WRITE" color="red" icon="pencil-alt" />
                <x-navbar-item url="/reviewing-app" title="REVIEW" color="blue" icon="star" />
                <div class="diagonal-divider"></div>
                <p style="color: white; margin-bottom: 0 !important;" class="skew10deg">USER</p>
                <x-navbar-item url="/login" title="LOGIN" color="lightblue" icon="user-alt"/>
                <x-navbar-item url="/register" title="REGISTER" color="skyblue" icon="user-plus"/>
                <x-navbar-item url="/settings" title="SETTINGS" color="grey" icon="cog"/>
                
            </x-slot>
        </x-navbar>
        
        @isset($success_message)
            <h1 class="success-message" style="text-align: center; background-color: green; color: white; padding: 20px;">Successfully added {{$success_message->name}} to budget!</h1>
        @endisset


        <div class="container budget-container">
            <div class="container-headings">
                <h1 style="color: blue; font-weight: 800;">BUDGET</h1>
                <i class="fas fa-chart-line statistics-icon"></i>
            </div>

            <div class="row budget_selection_buttons mx-3">
                <div class="col form-check"><input class="form-check-input" type="radio" id="budget-add-radio" name="transaction-mode-select"><label class="form-check-label" for="transaction-add-btn">Create Budget</label></div>
                <div class="col form-check"><input class="form-check-input" type="radio" id="budget-edit-radio" name="transaction-mode-select"><label class="form-check-label" for="transaction-view-btn">View Budget</label></div>
                <div class="col form-check"><input class="form-check-input" type="radio" id="transaction-edit-btn" name="transaction-mode-select" disabled><label class="form-check-label" for="transaction-edit-btn">Set Balance</label></div>
                <div class="col form-check"><input class="form-check-input" type="radio" id="transaction-delete-btn" name="transaction-mode-select" disabled><label class="form-check-label" for="transaction-delete-btn"></label></div>
            </div>

            <form class="create-budget-form" id="THE-FORM" method="POST" action="{{ config('app.url')}}/budgeting-app/app/budget">
                @csrf

                <div class="add-budget-section">

                <h1 class="text-center mt-3 fw-bold skew10deg">Add/Change Budget</h1>
                <p class="text-center" style="color: grey;">Note: If budget and date range already exist, it'll be updated instead.</p>
                <div class="col-md-12 setbudget-amount mt-3" >
                    <label for="setbudget_amount">Amount (£)</label>
                    <input name="setbudget_amount" class="form-control" required/>

                    
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <label for="setbudget_date_start">Date Start</label>
                        <input name="setbudget_date_start" type="date" class="form-control" required/>

                    </div>
                    
                    <div class="col-md-6">
                        <label for="setbudget_date_end">Date End</label>
                        <input name="setbudget_date_end" type="date" class="form-control" required/>

                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <label for="setbudget_category">Category</label>
                        
                        <select name="setbudget_category" id="setbudget_category" class="form-select" required>
                            @isset($categories)
                                @foreach($categories as $category)
                                    <option value={{$category->id}}>{{$category->name}}</option>
                                @endforeach
                            @endisset
                        </select>
                        
                    </div>

                    <div class="col-md-6">
                        <label for="setbudget_section">Subcategory </label>

                        <select name="setbudget_section" class="form-select" id="setbudget_section_select" required>

                        </select>
                        
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-12">
                        <button type="submit" style="width: 100%;" class="btn btn-success">SUBMIT</button>
                    </div>
                </div>
                </div>
            
            </form>

            <form class="view-budget-form d-none">
            <div class="view-budget-section"> <!-- d-none -->
                
                <h1 class="text-center mt-3 fw-bold skew10deg">View Budget</h1>

                <table class="table">
                    <tbody>
                        <tr>
                            <td style="font-weight: 800; text-align: center; margin-left: 30px;" colspan="2">Date Range</td>
                            <!-- <td style="font-weight: 800; text-align: center; margin-left: 30px;">Date End</td> -->
                            <td style="font-weight: 800; text-align: center; margin-left: 30px;">Actions</td>
                        </tr>
                        
                        @isset($date_ranges)
                        @foreach($date_ranges as $date_range)
                        <tr>
                            
                            <td>{{date('D jS M Y', strtotime($date_range->date_start))}}</td>
                            <td>{{date('D jS M Y', strtotime($date_range->date_end))}}</td>
                            <td>
                                <!-- More Details Button -->
                                <a class="btn btn-primary" href="{{ config('app.url')}}/budgeting-app/app/budget/view/{{$date_range->date_start}}/{{$date_range->date_end}}" type="submit"><i class="fas fa-plus"></i> VIEW</a>
                            </td>
                        </tr>
                        @endforeach
                        @endisset


                    </tbody>
                </table>

            </div>
            </form>
            

            <div class="row flex-row">

            </div>

        </div>
    </div>

    


<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
<script
			  src="https://code.jquery.com/jquery-3.6.0.js"
			  integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
			  crossorigin="anonymous"></script>
		
</body>

<script>   

    // Load Subcategories for the appropriate Category
    $(document).ready(function() {
    $('#setbudget_category').on('click', function(){
      
      var id = this.value;
      var url=`/budgeting-app/app/budget/${id}`;

      console.log(url);


      $('#setbudget_section_select').load(url);
        });
    });


    $("#budget-add-radio, #budget-edit-radio").click(function() {
        console.log('Clicked')
        
        if($('#budget-add-radio').is(':checked')) {
            $(".create-budget-form").removeClass("d-none");
        //$("#transaction-add-btn").toggleClass("selected-orange");
        } else {
            $(".create-budget-form").addClass("d-none");
        }

        if($('#budget-edit-radio').is(':checked')) {
            $(".view-budget-form").removeClass("d-none");
        //$("#transaction-add-btn").toggleClass("selected-orange");
        } else {
            $(".view-budget-form").addClass("d-none");
        
        }


    });

</script>

</html>