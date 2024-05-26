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
    <div id="app" class="font-MontserratRegular">
        <x-navbar-complete brandName='MyBudget' />

    </div>

    <div class="container view-transaction-container mt-3">
        <div class="container-headings">
            <h1 style="color: blue; font-weight: 800; transform: skew(-10deg);">VIEW TRANSACTION</h1>
            <i class="fas fa-chart-line statistics-icon"></i>
        </div>

        <table class='table view_transaction_table view_one'>
            <thead>
                <tr>
                    <th scope='col'>#</th>
                    <th scope='col'>Name</th>
                    <th scope='col'>Price</th>
                    <th scope='col'>Category</th>
                    <th scope='col'>Subcategory</th>
                    <th scope='col'>Date</th>
                    <th scope='col'>Source</th>
                    <!-- <th scope='col'>Description</th> -->
                </tr>
            </thead>
            <tbody>
        
        @isset($transactions)
            @foreach($transactions as $transaction)
            <tr>
                
                <th>{{$transaction->id}}</th>
                
                <td>{{$transaction->name}}</td>
                
                <!-- If Price is Below £1000, Show Price to Two decimal places -->
                @if((int)$transaction->price_twodp < 1000)
                <td>£{{number_format($transaction->price_twodp, 2)}}</td>
                @else
                <td>£{{$transaction->price_twodp}}</td>
                @endif
                
                <td>{{$transaction->category_name}}</td>
                
                <td>{{$transaction->section_name}}</td>
                
                <td>{{date('d/m/Y', strtotime($transaction->created_at))}}</td>
                
                <td>{{$transaction->source_name}}</td>
                
                DESCRIPTION: {{$transaction->description}}
                <!-- <td>{{-- $transaction->description --}}</td> -->
            </tr>
            @endforeach
        @endisset

        @isset($subtransactions)

            
            @foreach($subtransactions as $subtransaction)
            <tr>
                @if($loop->first)
                
                <th colspan="7" class="skew10deg" style="font-size:24px;">SUBTRANSACTIONS</th>

                </tr>

                <tr>
        
                @endif

                <th>{{$subtransaction->transaction_id}}.{{$loop->iteration}}</th>
                
                <td>{{$subtransaction->name}}</td>
                
                <!-- If Price is Below £1000, Show Price to Two decimal places -->
                @if((int)$subtransaction->price_twodp < 1000)
                <td>£{{number_format($subtransaction->price_twodp, 2)}}</td>
                @else
                <td>£{{$subtransaction->price_twodp}}</td>
                @endif
                
                <td>{{$subtransaction->category_name}}</td>
                
                <td>{{$subtransaction->section_name}}</td>
                
                <td>{{date('d/m/Y', strtotime($subtransaction->created_at))}}</td>
                
                <td>{{$subtransaction->source_name}}</td>
                
                <!-- <td>{{-- $transaction->description --}}</td> -->
            </tr>
            @endforeach
        
        @endisset


        </tbody>
        </table>

        <a href="/budgeting-app/app/create" class="btn btn-primary align-left"><i class="fas fa-angle-double-left"></i> BACK</a>

        
        <a href="/budgeting-app/app/create/subtransaction/{{$id}}" class="btn btn-success">MAKE SUBTRANSACTIONS</a>
    </div>

    <div class="container big-text-container">
        <h1 class="BIG-TEXT" style="font-size: 240px; opacity: 0.4; color: blue;"> VIEW </h1>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <script
                  src="https://code.jquery.com/jquery-3.6.0.js"
                  integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
                  crossorigin="anonymous"></script>
  
                  
</body>


