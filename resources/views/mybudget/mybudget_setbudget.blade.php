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
    <link href="{{ asset('css/mylifeline_section.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/mybudget_setbudget.css') }}" rel="stylesheet" type="text/css">

    <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>

    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">


    
</head>
<body>
    @inject('sum_cost', 'App\Http\Controllers\MyBudgetSetBudgetController')

    <div id="app" class="font-MontserratRegular">
        <x-navbar-complete brandName='MyBudget' />
        
        @isset($success_message)
            <h1 class="success-message" style="text-align: center; background-color: green; color: white; padding: 20px;">Successfully added {{$success_message->name}} to budget!</h1>
        @endisset


        <div class="container mt-3" id="SETBUDGET-HEADER">
            
            <div id="SETBUDGET-HEADER-TITLE">
                SET BUDGET   
                </div>
                
                <div id="SETBUDGET-HEADER-ICON"><i class="fas fa-cash-register"></i>
                
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

    $("#setbudget_date_end").change(function(e) {
    e.preventDefault();
            
        var column_select_val = $('#setbudget_date_start').val();

        var column_search_val = $('#setbudget_date_end').val();

        $.ajax({
        
        type: "GET",

        url: `/budgeting-app/app/budget/${column_select_val}/${column_search_val}`,
        success: function (data) {
                    $("#THE-BUDGET-CONTAINER").html(data);
                    console.log('success!')
                }
        });

    });

    $(document).ready(function() {

        var setbudget_array = [];
        
        var input_budgets = document.querySelectorAll('*[id^="input-budget-"]');

        for (let i = 0; i < input_budgets.length; i++) {
            setbudget_array.push(input_budgets[i].getAttribute('unique_identifier'))
        }

        console.log(setbudget_array);

        document.getElementById('pages').value = setbudget_array;

    })

    /*
    $(document).ready(function() {
    if ($('input#report-checkbox').is(':checked')) {
        console.log('This works just fine! Antarctica')
        }
    });
    */

</script>

</html>