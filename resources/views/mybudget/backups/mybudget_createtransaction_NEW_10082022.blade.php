<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MyLifeline - Create Transaction</title>

    <script src="https://kit.fontawesome.com/c36ba6cddf.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>

    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    

    <link href="{{ asset('css/mylifeline_home.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/mybudget_transactions.css') }}" rel="stylesheet" type="text/css">

    <!-- Mobile Media Queries -->
    <link href="{{ asset('css/mybudget_transactions_MOBILE.css') }}" rel="stylesheet" type="text/css">
    
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

        <div id="TRANSACTIONS-CONTAINER" class="container-fluid mt-3">

            <div id="TRANSACTIONS-HEADER">

                <div id="TRANSACTIONS-HEADER-TITLE">
                TRANSACTIONS          
                </div>
                
                <div id="TRANSACTIONS-HEADER-ICON"><i class="fas fa-cash-register"></i>
                
                </div>

            </div>


            <form method="POST" id="TRANSACTIONS-FORM-CHOOSE-1" action="{{ config('app.url')}}/budgeting-app/app/" class="form-transaction mt-3">
                
                <div id="CHOOSE-1-HEADER">1. SELECT AN ACTION</div>
                
                <div id="TRANSACTIONS-FORM-CHOOSE-1-FIELDS">

                    <div>
                    <input type="radio" id="transaction_radio_1"
                     name="transactions_form_radio" value="CREATE" />
                    <label for="transaction_radio_1">CREATE</label>
                    
                    <i class="fas fa-cart-plus"></i>
                    </div>

                    <div>
                    <input type="radio" id="transaction_radio_2"
                     name="transactions_form_radio" value="EDIT" />
                    <label for="transaction_radio_2">EDIT</label>

                    <i class="fas fa-pencil-alt"></i>
                    </div>

                    <div>
                    <input type="radio" id="transaction_radio_3"
                     name="transactions_form_radio" value="VIEW" />
                    <label for="transaction_radio_3">VIEW</label>

                    <i class="fas fa-search"></i>
                    </div>
                    
                </div>


            </form>

            <div id="TRANSACTION-DIVS">
                <div class="transaction-selection mt-3" id="TRANSACTIONS-FORM-CREATE">

                    CREATE TRANSACTIONS

                </div>

                <div class="transaction-selection mt-3" id="TRANSACTIONS-FORM-EDIT">

                    EDIT TRANSACTIONS

                </div>

                <div class="transaction-selection mt-3" id="TRANSACTIONS-FORM-VIEW">
                    
                    VIEW TRANSACTIONS

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
		
</body>

<script>   

$(document).ready(function() {
    $("input[name$='transactions_form_radio']").click(function() {
        var test = $(this).val();
        
        console.log(test);

        
        $(".transaction-selection").removeClass('TRANSACTION-DIV-SHOW');

        $("#TRANSACTIONS-FORM-" + test).addClass('TRANSACTION-DIV-SHOW');
    });
});

</script>

</html>