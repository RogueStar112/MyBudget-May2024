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

    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
    <link rel="stylesheet" href="{{ mix('/css/app-combine.css') }}">

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
    </div>

    @isset($success_message)
        <h1 class="success-message" style="text-align: center; background-color: green; color: white; padding: 20px;"><i class="fas fa-check-circle"></i> Successfully edited {{$success_message}}!</h1>
    @endisset


    <div class="container view-transaction-container mt-3">
        <div class="container-headings">
            <h1 style="color: orange; font-weight: 800; transform: skew(-10deg);">EDIT TRANSACTION</h1>
            <i class="fas fa-pencil-alt statistics-icon"></i>
        </div>

        <form class="mt-3 edit-transaction-form-specific" id="THE-FORM" method="POST" action="/budgeting-app/app/transactions/edit/{{$id}}">
            @csrf

            @foreach ($transactions as $transaction)


            <div class="row mt-3">
                <div class="col-md-3">
                    <label for="name_input">Name</label> 
                </div>

                <div class="col-md-9">
                    <input class="form-control" name="name_input" type="text" value="{{$transaction->name}}"/>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-3">
                    <label for="price_input">Price</label> 
                </div>

                <div class="col-md-9">
                    <input class="form-control" name="price_input" type="text" value="{{$transaction->price}}"/>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-3">
                    <label for="category_input">Category</label> 
                </div>

                <div class="col-md-9">
                    <input class="form-control" name="category_input" type="text" value="{{$transaction->category_name}}"/>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-3">
                    <label for="subcategory_input">Subcategory</label> 
                </div>

                <div class="col-md-9">
                    <input class="form-control" name="subcategory_input" type="text" value="{{$transaction->section_name}}"/>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-3">
                    <label for="subcategory_input">Date</label> 
                </div>

                <div class="col-md-9">
                    <input class="form-control" name="date_input" type="date" value="{{ date('Y-m-d', strtotime($transaction->created_at)) }}"/>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-3">
                    <label for="source_input">Source</label> 
                </div>

                <div class="col-md-9">
                    <input class="form-control" name="source_input" type="text" value="{{$transaction->source_name}}"/>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-3">
                    <label for="description_input">Description</label> 
                </div>

                <div class="col-md-9">
                    <input type="hidden" name="_method" value="PUT">
                    <input class="form-control" name="description_input" type="textarea" value="{{$transaction->description}}"/>
                </div>
            </div>
            @endforeach
            
            <div class="row mt-3">
                <div class="col-md-6">
                    <a href="/budgeting-app/app/create" class="btn btn-primary align-left"><i class="fas fa-angle-double-left"></i> BACK</a>
                </div>

                <div class="col-md-6">
                    <button type="submit" class="btn btn-success">SUBMIT EDIT</button>
                </div>
            </div>
        </form>

    </div>

    <div class="container big-text-container">
        <h1 class="BIG-TEXT" style="font-size: 288px; opacity: 0.4; color: orange;"> EDIT </h1>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <script
                  src="https://code.jquery.com/jquery-3.6.0.js"
                  integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
                  crossorigin="anonymous"></script>
  
                  
</body>
