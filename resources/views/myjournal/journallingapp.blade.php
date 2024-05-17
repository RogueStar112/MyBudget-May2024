<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MyJournal - App Menu</title>

    <script src="https://kit.fontawesome.com/c36ba6cddf.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>

    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    

    <link href="{{ asset('css/mylifeline_home.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/myjournal_home.css') }}" rel="stylesheet" type="text/css">
</head>
<body>
    <div id="app">
        <x-navbar brandName="MyJournal" brandColor="red" >
            <x-slot name="items">
                <x-navbar-item url="/.." title="HOME" color="red" icon="home" />
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
                
                <form id="logout-form" action="{{ url('logout') }}" method="POST">
                    {{ csrf_field() }}
                    <li class="nav-item m-1" style="background-color: red">
                        <button class="nav-link" type="submit"><i class="fas fa-sign-out-alt"></i><p></p><div class="label-bottom">LOGOUT</div></button>
                    </li>
                </form>

                @isset($userName)

                <div class="diagonal-divider"></div>
                
                <p class="m-3" style="text-align: right; color: white; font-family: Montserrat;">Welcome, {{$userName}}.</p>

                @endisset
            </x-slot>
        </x-navbar>

        <div class="container">

            <div class="row">
                <div class="col-sm" style=" background-color: #940000; color: white;">
                    <a href="{{ config('app.url')}}/journalling-app/entries">
                    <div class="top-left-title">Write Journal Entry</div>
                    <div class="description">Write down what's on your mind</div>
                    <div class="custom-icon"><i class="fas fa-pen-nib"></i></div>
                    </a>
                </div>

                <div class="col-sm" style=" background-color: #940000; color: white;">
                    <a href="{{ config('app.url')}}/journalling-app/entries/view">
                    <div class="top-left-title">View Journal Entries</div>
                    <div class="description">Find posts with the relevant tag</div>
                    <div class="custom-icon"><i class="fas fa-eye"></i></div>
                    </a>
                </div>
                
            </div>

            <div class="row">
                <div class="col-sm" style=" background-color: #940000; color: white;">
                    <a href="{{ config('app.url')}}/journalling-app/ratings">
                    <div class="top-left-title">Ratings</div>
                    <div class="description">Rate your day on a scale of 1 to 5, with custom descriptions.</div>
                    <div class="custom-icon"><i class="fas fa-star"></i></div>
                    </a>
                </div>
            </div>
        </div>
    </div>



