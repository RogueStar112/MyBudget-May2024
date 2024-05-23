

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <title>MyLifeline - Homepage</title>
      <script src="https://kit.fontawesome.com/c36ba6cddf.js" crossorigin="anonymous"></script>
      <script src="{{ asset('js/app.js') }}" defer></script>
      <link rel="dns-prefetch" href="//fonts.gstatic.com">
      <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
      <link href="{{ asset('css/app.css') }}" rel="stylesheet">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
      <link href="{{ asset('css/mylifeline_home.css') }}" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
    
    
   </head>
   <body>
      <div id="app">
         <x-navbar-complete brandName='MyBudget' />

      <div class="container">

        <!--
        <div class="row" style="text-align: center;">
            <div class="col-sm" style="color: #198754;">
                <h1 style="font-family: Montserrat; font-weight: 600; font-size: 32px;">BUDGETING MAIN MENU</h1>
            </div>
        </div>
        -->
        <div class="row">
            <div class="col-sm" style="color: #198754;">
                <a href="/budgeting-app/app/categories/create">
                <div class="top-left-title">Categories</div>
                <div class="description">Set/View Budget Categories, Budget Subcategories.</div>
                <div class="custom-icon"><i class="fas fa-book"></i></div>
                </a>
            </div>
            <div class="col-sm" style="color: #FF6A00;">
                <a href="/budgeting-app/app/create">
                <div class="top-left-title">Transactions</div>
                <div class="description">Create/Edit/Delete/View Transactions.</div>  
                <div class="custom-icon"><i class="fas fa-cash-register"></i></div>
                </a>  
            </div>

        </div>

        <div class="row">
            <div class="col-sm" style="color: #0094FF">
                <a href="/budgeting-app/app/sources">
                <div class="top-left-title">Sources</div>
                <div class="description">Know where your transactions come from</div>
                <div class="custom-icon"><i class="fas fa-shopping-cart"></i></div>
                </a>
            </div>

            <div class="col-sm" style="color: #0094FF">
                <div class="top-left-title">Categories and Sections</div>
                <div class="description">View category and section details</div>
                <div class="custom-icon"><i class="fas fa-question"></i></div>
            </div>

            <div class="col-sm" style="color: #0094FF">
                <div class="top-left-title">Subtransactions</div>
                <div class="description">View subtransaction details</div>
                <div class="custom-icon"><i class="fas fa-question"></i></div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm" style="color: #0026FF;">
                <a href="/budgeting-app/app/budget">
                <div class="top-left-title">Set Budget</div>
                <div class="description">Set Account Balance, Set Subcategory Budget</div>
                <div class="custom-icon"><i class="fas fa-wallet"></i></div>
                </a>
            </div>
            <div class="col-sm" style="color: red;">
                <div class="top-left-title">Items</div>
                <div class="description">Create/Edit/Delete/View Items.</div>
                <div class="custom-icon"><i class="fas fa-pizza-slice"></i></div>
            </div>
            
        </div>
        <div class="row">
            <div class="col-sm" style="color: #0094FF">
                <div class="top-left-title">Help</div>
                <div class="description">A walk-through tutorial.</div>
                <div class="custom-icon"><i class="fas fa-question"></i></div>
            </div>
            <div class="col-sm" style="color: #808080;">
                <div class="top-left-title">Settings</div>
                <div class="description">Change Currency, Date Format, or Time Zone.</div>
                <div class="custom-icon"><i class="fas fa-cog"></i></div>
            </div>
            
        </div>
        <div class="row">
            <div class="col-sm" style="color: #0094FF">
                <a href="/budgeting-app/app/statistics">
                <div class="top-left-title">Statistics</div>
                <div class="description">Budget Overview (Monthly)</div>
                <div class="custom-icon"><i class="fas fa-chart-line"></i></div>
                </a>
            </div>

            <div class="col-sm" style="color: #0094FF">
                <a href="/budgeting-app/app/compare">
                <div class="top-left-title">Comparisons</div>
                <div class="description">Compare spending between two dates.</div>
                <div class="custom-icon"><i class="fas fa-balance-scale"></i></div>
                </a>
            </div>
        </div>
      </div>
      <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
   </body>
</html>

