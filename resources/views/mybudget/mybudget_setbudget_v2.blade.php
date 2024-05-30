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
    <link href="{{ asset('css/mybudget_setbudget_v2.css') }}" rel="stylesheet" type="text/css">

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


        <div class="flex gap-3">
        <div class="container m-6">
        <h1 class="mb-2 text-center text-2xl font-extrabold md:w-1/2">Budget Planner</h1>

            <div>
            <form class="" id="THE-INCOME-FORM">

            <div id="step-one" class="w-1/2 flex flex-col justify-center gap-3 mb-2 font-extrabold border-b-4 border-green-500 mb-4"> 
                STEP 1. CALCULATE INCOME
            </div>

        <!--      <div id="income-container-labels" class="w-1/2 flex flex-col justify-center gap-3 mb-2"> 
                <div class="labels-group flex justify-around text-center">
                <p class= grow">Income Source</p>
                <p class= grow">Amount Earned</p>
                <p class= grow">Date Received</p>
                </div>

            </div> -->
                <div class="flex flex-col justify-between">
                <button type="button" id="add-income-btn" class="text-white bg-green-500 w-1/2 p-4">ADD NEW INCOME</button>
        <!--        <button type="submit" id="submit-income-btn" class="text-white bg-green-600 w-1/2 p-4">SUBMIT</button> -->
            </div>    

            <div id="income-container" class="w-1/2 flex flex-col justify-center gap-3 mb-2">
                <div class="income-group flex justify-center" id="income-group-1"> 
                    <input type="text" class="text-center   grow" name="income_source_1" id="income_source_1" placeholder="Name of Income Source">
                    <input type="text" class="text-center  grow" name="amount_earned_1" id="amount_earned_1" placeholder="Amount Earned">
                    <input type="date" class="text-center grow" name="date_received_1" id="date_received_1" placeholder="Date Received">
                    <button type="button" class="delete-income-btn text-red-500 p-2">X</button> 
                </div>
            </div>

        <!--      <div class="text-center flex flex-col" id="income-name-inputs">
                <label id="income-name-label-1" for="income-name-1">Name of Income Source</label>
                <input id="income-name-1" name="income-name-1" class="border-4 border-blue-500" type="text"/>
            </div>

            <div class="text-center flex flex-col" id="income-earned-inputs">
                <label id="income-earned-label-1" for="income-earned-1">Amount Earned</label>
                <input id="income-earned-1" class="border-4 border-blue-500" name="income-earned-1" type="text" /> 
            </div>

            <div class="text-center flex flex-col" id="income-received-inputs">

                <label id="income-date-label-1" for="income-date-1">Date Received</label>
                <input id="income-date-1" class="border-4 border-blue-500 text-center" name="income-date-1" type="date">

            </div> -->


        </form>

        <form class="" id="THE-EXPENSES-FORM">

            <div id="step-two" class="w-1/2 flex flex-col justify-center gap-3 mb-2 font-extrabold border-b-4 border-red-600 mb-4 mt-4"> 
                STEP 2. DISTRIBUTE BUDGET
            </div>

        <!--      <div id="income-container-labels" class="w-1/2 flex flex-col justify-center gap-3 mb-2"> 
                <div class="labels-group flex justify-around text-center">
                <p class= grow">Spending Name</p>
                <p class= grow">Amount To Spend</p>
                <p class= grow">For Category</p>
                </div>

            </div> -->
            <div class="flex flex-col justify-between">
                <button type="button" id="add-expenses-btn" class="text-white bg-red-600 w-1/2 p-4">ADD NEW EXPENSE</button>
        <!--        <button type="submit" id="submit-income-btn" class="text-white bg-red-700 w-1/2 p-4">SUBMIT</button> -->
            </div>

            <div id="expenses-container" class="w-1/2 flex flex-col justify-center gap-3 my-2">
                <div class="expenses-group flex justify-center" id="expenses-group-1"> 
                    <input type="text" class="text-center   grow" name="spending_name_1" id="spending_name_1" placeholder="Spending Name">
                    <input type="text" class="text-center  grow" name="amount_spent_1" id="amount_spent_1" placeholder="Amount To Spend">
                    <select class="form-select grow text-center" id="expenses_category_1" name="expenses_category_1" index="1" placeholder="Groceries">
                                    @foreach ($groupedData as $key => $value)
                                        @foreach($value as $key_ii => $category)
                                            <optgroup label="{{ $category[0]->category_name }}">
                                                @foreach ($category as $section)
                                                    <option value="{{ $section->section_id }}">{{ $section->section_name }}</option>
                                                @endforeach
                                            </optgroup>
                                        @endforeach
                                    @endforeach
                    </select>

                    <button type="button" class="delete-expenses-btn text-red-500 p-2">X</button> 
                </div>
            </div>

        <!--      <div class="text-center flex flex-col" id="income-name-inputs">
                <label id="income-name-label-1" for="income-name-1">Name of Income Source</label>
                <input id="income-name-1" name="income-name-1" class="border-4 border-blue-500" type="text"/>
            </div>

            <div class="text-center flex flex-col" id="income-earned-inputs">
                <label id="income-earned-label-1" for="income-earned-1">Amount Earned</label>
                <input id="income-earned-1" class="border-4 border-blue-500" name="income-earned-1" type="text" /> 
            </div>

            <div class="text-center flex flex-col" id="income-received-inputs">

                <label id="income-date-label-1" for="income-date-1">Date Received</label>
                <input id="income-date-1" class="border-4 border-blue-500 text-center" name="income-date-1" type="date">

            </div> -->


        </form>  
        </div>
            
        <div id="RECEIPT-LIST">
            
            
            
            
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

import $ from "https://esm.sh/jquery";

document.getElementById('add-income-btn').addEventListener('click', function() {
            const incomeContainer = document.getElementById('income-container');
            const lastGroup = incomeContainer.lastElementChild;
            const newGroupId = parseInt(lastGroup.id.split('-')[2]) + 1;

            const newGroup = lastGroup.cloneNode(true);
            newGroup.id = `income-group-${newGroupId}`;

            newGroup.querySelectorAll('input, select').forEach((input) => {
                const nameParts = input.name.split('_');
                const idParts = input.id.split('_');
                nameParts[nameParts.length - 1] = newGroupId;
                idParts[idParts.length - 1] = newGroupId;
                input.name = nameParts.join('_');
                input.id = idParts.join('_');
                input.value = ''; // Clear the value
            });

            // Add event listener for the delete button
            newGroup.querySelector('.delete-income-btn').addEventListener('click', function() {
                newGroup.remove();
                reorderGroups();
            });

            incomeContainer.appendChild(newGroup);
        });

        // Reorder the groups after deletion
        function reorderGroups() {
            const incomeContainer = document.getElementById('income-container');
            const groups = incomeContainer.getElementsByClassName('income-group');
            Array.from(groups).forEach((group, index) => {
                const newGroupId = index + 1;
                group.id = `income-group-${newGroupId}`;
                group.querySelectorAll('input, select').forEach((input) => {
                    const nameParts = input.name.split('_');
                    const idParts = input.id.split('_');
                    nameParts[nameParts.length - 1] = newGroupId;
                    idParts[idParts.length - 1] = newGroupId;
                    input.name = nameParts.join('_');
                    input.id = idParts.join('_');
                });
            });
        }

        // Add event listener for the initial delete button
        document.querySelectorAll('.delete-income-btn').forEach(button => {
            button.addEventListener('click', function() {
                if(document.querySelectorAll('.delete-income-btn').length > 1) {
                  
                 button.closest('.income-group').remove();
                 reorderGroups();
                     
                }
           
            });
        });

document.getElementById('add-expenses-btn').addEventListener('click', function() {
            const expensesContainer = document.getElementById('expenses-container');
            const lastGroup = expensesContainer.lastElementChild;
            const newGroupId = parseInt(lastGroup.id.split('-')[2]) + 1;

            const newGroup = lastGroup.cloneNode(true);
            newGroup.id = `expenses-group-${newGroupId}`;

            newGroup.querySelectorAll('input, select').forEach((input) => {
                const nameParts = input.name.split('_');
                const idParts = input.id.split('_');
                nameParts[nameParts.length - 1] = newGroupId;
                idParts[idParts.length - 1] = newGroupId;
                input.name = nameParts.join('_');
                input.id = idParts.join('_');
                input.value = ''; // Clear the value
            });

            // Add event listener for the delete button
            newGroup.querySelector('.delete-expenses-btn').addEventListener('click', function() {
                newGroup.remove();
                reorderGroups_expenses();
            });

            expensesContainer.appendChild(newGroup);
        });

        // Reorder the groups after deletion
        function reorderGroups_expenses() {
            const expensesContainer = document.getElementById('expenses-container');
            const groups = expensesContainer.getElementsByClassName('expenses-group');
            Array.from(groups).forEach((group, index) => {
                const newGroupId = index + 1;
                group.id = `expenses-group-${newGroupId}`;
                group.querySelectorAll('input, select').forEach((input) => {
                    const nameParts = input.name.split('_');
                    const idParts = input.id.split('_');
                    nameParts[nameParts.length - 1] = newGroupId;
                    idParts[idParts.length - 1] = newGroupId;
                    input.name = nameParts.join('_');
                    input.id = idParts.join('_');
                });
                
            });
        }

        // Add event listener for the initial delete button
        document.querySelectorAll('.delete-expenses-btn').forEach(button => {
            button.addEventListener('click', function() {
                if(document.querySelectorAll('.delete-income-btn').length > 1) {
                  
                 button.closest('.expenses-group').remove();
                 reorderGroups_expenses();
                     
                }
           
            });
        });

    // Load Subcategories for the appropriate Category
    // $(document).ready(function() {
    // $('#setbudget_category').on('click', function(){
      
    //   var id = this.value;
    //   var url=`/budgeting-app/app/budget/${id}`;

    //   console.log(url);


    //   $('#setbudget_section_select').load(url);
    //     });
    // });


    // $("#budget-add-radio, #budget-edit-radio").click(function() {
    //     console.log('Clicked')
        
    //     if($('#budget-add-radio').is(':checked')) {
    //         $(".create-budget-form").removeClass("d-none");
    //     //$("#transaction-add-btn").toggleClass("selected-orange");
    //     } else {
    //         $(".create-budget-form").addClass("d-none");
    //     }

    //     if($('#budget-edit-radio').is(':checked')) {
    //         $(".view-budget-form").removeClass("d-none");
    //     //$("#transaction-add-btn").toggleClass("selected-orange");
    //     } else {
    //         $(".view-budget-form").addClass("d-none");
        
    //     }


    // });

    // $("#setbudget_date_end").change(function(e) {
    // e.preventDefault();
            
    //     var column_select_val = $('#setbudget_date_start').val();

    //     var column_search_val = $('#setbudget_date_end').val();

    //     $.ajax({
        
    //     type: "GET",

    //     url: `/budgeting-app/app/budget/${column_select_val}/${column_search_val}`,
    //     success: function (data) {
    //                 $("#THE-BUDGET-CONTAINER").html(data);
    //                 console.log('success!')
    //             }
    //     });

    // });

    // $(document).ready(function() {

    //     var setbudget_array = [];
        
    //     var input_budgets = document.querySelectorAll('*[id^="input-budget-"]');

    //     for (let i = 0; i < input_budgets.length; i++) {
    //         setbudget_array.push(input_budgets[i].getAttribute('unique_identifier'))
    //     }

    //     console.log(setbudget_array);

    //     document.getElementById('pages').value = setbudget_array;

    // })

    /*
    $(document).ready(function() {
    if ($('input#report-checkbox').is(':checked')) {
        console.log('This works just fine! Antarctica')
        }
    });
    */

</script>

</html>