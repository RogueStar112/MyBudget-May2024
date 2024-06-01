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
        <x-navbar-complete brandName='MyBudget' /> @isset($success_message)
        <h1 class="success-message" style="text-align: center; background-color: green; color: white; padding: 20px;">Successfully added {{$success_message->name}} to budget!</h1> @endisset


        <div class="flex gap-3">
            <div class="container m-6">
                <h1 class="mb-2 text-center text-2xl font-extrabold md:w-1/2">Budget Planner</h1>

                <div>
                    <form class="" id="THE-INCOME-FORM">

                        <div id="step-one" class="w-1/2 flex flex-col justify-center gap-3 mb-2 font-extrabold border-b-4 border-green-500 mb-4">
                            STEP 1. CALCULATE INCOME
                        </div>

                     
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

                

                    </form>

                    <form class="" id="THE-EXPENSES-FORM">

                        <div id="step-two" class="w-1/2 flex flex-col justify-center gap-3 mb-2 font-extrabold border-b-4 border-red-600 mb-4 mt-4">
                            STEP 2. DISTRIBUTE BUDGET
                        </div>

               
                        <div class="flex flex-col justify-between">
                            <button type="button" id="add-expenses-btn" class="text-white bg-red-600 w-1/2 p-4">ADD NEW EXPENSE</button>
                            <!--        <button type="submit" id="submit-income-btn" class="text-white bg-red-700 w-1/2 p-4">SUBMIT</button> -->
                        </div>

                        <div id="expenses-container" class="w-1/2 flex flex-col justify-center gap-3 my-2">
                            <div class="expenses-group flex justify-center" id="expenses-group-1">
                                <input type="text" class="text-center   grow" name="spending_name_1" id="spending_name_1" placeholder="Spending Name">
                                <input type="text" class="text-center  grow" name="amount_spent_1" id="amount_spent_1" placeholder="Amount To Spend">

                                <select class="form-select grow text-center" id="expenses_category_1" name="expenses_category_1" index="1" placeholder="Groceries">
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
                                        <option value="Error">Error</option>
                                    @endisset
                                </select>

                                <button type="button" class="delete-expenses-btn text-red-500 p-2">X</button>
                            </div>
                        </div>

                   

                    </form>
                </div>

              
                </div>

                  <form id="RECEIPT-LIST" class="flex flex-col text-center">
                    <div id="receipt-list-header">
                        <h2 class="font-extrabold text-2xl">BUDGET BREAKDOWN</h2>
                        <p class="text-center text-red-500">PLEASE SPECIFY DATE RANGE.</p>
                        <div class="flex justify-between">
                            <input type="date" name="start-date" />
                            <span class="m-4">to</span>
                            <input type="date" name="end-date" />

                        </div>

                        <div id="receipt-income" class="text-left">
                            <h3 class="text-2xl text-right bg-gradient-to-r from-transparent via-green-600 to-green-400 p-4">INCOME</h3>
                            <ul id="receipt-income-list" class="">
                                <div id="income-transaction-1" class="flex justify-between income">
                                    <li>INCOME 1</li>
                                    <li>N/A</li>
                                </div>




                            </ul>

                            <div id="income-total" class="text-right flex justify-between items-center border-t-4 border-green-500">
                                <h3 class="font-2xl" id="total-income">TOTAL EARNT</h3>
                                <p class="text-2xl" id="total-income-amount"></p>
                            </div>

                        </div>

                        <div id="receipt-expenses" class="text-left">
                            <h3 class="text-2xl bg-gradient-to-r from-transparent via-red-600 to-red-400 p-4 text-right">EXPENSES</h3>
                            <ul id="receipt-expenses-list" class="receipt-expenses-list">
                                <div id="expense-transaction-1" class="flex justify-between expense">
                                    <li>EXPENSE 1</li>
                                    <li>N/A</li>
                                </div>



                            </ul>

                            <div id="expenses-total" class="flex justify-between items-center border-t-4 border-red-500">
                                <h3 class="font-2xl" id="total-spent">TOTAL SPENT</h3>
                                <p class="text-2xl" id="total-spent-amount"></p>
                            </div>

                            <div id="subtotal" class="mt-3 text-right">
                                <h3 class="font-2xl border-t-4 border-yellow-500" id="total-remaining">TOTAL REMAINING</h3>
                                <p class="text-2xl" id="total-remaining-amount"></p>
                            </div>

                        </div>
                </form>
            </div>




            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
            <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

</body>

<script>
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

document.getElementById('income-container').addEventListener('change', function() {
  // console.log('CHANGE!!')
  
  let incomeContainer = document.getElementById('income-container');
  const incomeGroups = incomeContainer.getElementsByClassName('income-group');
  
  let receiptIncomeList = document.getElementById('receipt-income-list');
  
  // sanitize innerHTML before processing
  receiptIncomeList.innerHTML = "";
  
  let incomeTotal = 0;
  
  Array.from(incomeGroups).forEach((group, index) => {
    
    const newGroupId = index + 1;
    
    const incomeSource = document.getElementById(`income_source_${newGroupId}`).value;
    const amountEarned = document.getElementById(`amount_earned_${newGroupId}`).value;
    
    const newIncomeTransaction = document.createElement('div');
    newIncomeTransaction.id = `income-transaction-${newGroupId}`;
    newIncomeTransaction.classList.add(`flex`)
    newIncomeTransaction.classList.add(`justify-between`)
    newIncomeTransaction.classList.add(`income`);
      
    const newIncomeName = document.createElement('li');
    newIncomeName.textContent = incomeSource;
    
    const newIncomeAmount = document.createElement('li');
    
    newIncomeAmount.textContent = `£` + parseFloat(amountEarned).toFixed(2); // Corrected the typo here
    

    
    
    
    receiptIncomeList.appendChild(newIncomeTransaction);
    newIncomeTransaction.appendChild(newIncomeName);
    newIncomeTransaction.appendChild(newIncomeAmount);

    incomeTotal += parseFloat(amountEarned);
    
  });
  
  document.getElementById('total-income-amount').textContent = `£` + incomeTotal.toFixed(2);
  
});

document.getElementById('expenses-container').addEventListener('change', function() {
  // console.log('CHANGE!!')
  
  let expensesContainer = document.getElementById('expenses-container');
  const expensesGroups = expensesContainer.getElementsByClassName('expenses-group');
  
  let receiptExpensesList = document.getElementById('receipt-expenses-list');
  
  // sanitize innerHTML before processing
  receiptExpensesList.innerHTML = "";
  
  let spentTotal = 0;
  
  Array.from(expensesGroups).forEach((group, index) => {
    
    const newGroupId = index + 1;
    
    const expenseSource = document.getElementById(`spending_name_${newGroupId}`).value;
    const expenseAmount = document.getElementById(`amount_spent_${newGroupId}`).value;
    
    const newExpenseTransaction = document.createElement('div');
    newExpenseTransaction.id = `expense-transaction-${newGroupId}`;
    newExpenseTransaction.classList.add(`flex`)
    newExpenseTransaction.classList.add(`justify-between`)
    newExpenseTransaction.classList.add(`income`);
      
    const newExpenseName = document.createElement('li');
    newExpenseName.textContent = expenseSource;
    
    const newExpenseAmount = document.createElement('li');
    newExpenseAmount.textContent = `£` + expenseAmount; // Corrected the typo here
    
    receiptExpensesList.appendChild(newExpenseTransaction);
    newExpenseTransaction.appendChild(newExpenseName);
    newExpenseTransaction.appendChild(newExpenseAmount);
    
    spentTotal += parseFloat(expenseAmount);
  });
  
  let totalAmountSpent = document.getElementById('total-spent-amount');
  
totalAmountSpent.textContent = `£` + spentTotal.toFixed(2);

let totalAmountEarned = document.getElementById('total-income-amount');

// Remove the currency symbol and parse the remaining text as a float
let earnedAmount = parseFloat(totalAmountEarned.textContent.replace('£', ''));
let spentAmount = parseFloat(totalAmountSpent.textContent.replace('£', ''));

let remainingAmount = earnedAmount - spentAmount;

document.getElementById('total-remaining-amount').textContent = `£` + remainingAmount.toFixed(2);  // toFixed(2) ensures two decimal places

    
    
  
});
</script>

</html>