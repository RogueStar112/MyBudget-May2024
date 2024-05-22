<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MyLifeline - Welcome</title>

    <script src="https://kit.fontawesome.com/c36ba6cddf.js" crossorigin="anonymous"></script>

    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link href="{{ asset('css/mylifeline_home.css') }}" rel="stylesheet" type="text/css">

    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
    <x-navbar :brandName="MyLifeline" brandColor="green" >
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



        <div class="text-center text-black max-w-5xl">
            <h2>Welcome to MyLifeline</h2>
            <p>A series of practical daily-life apps.</p>

            <ul class="m-0 p-0">
                <li class="text-green-600">MyBudget - For personal finance</li>
                <li class="text-orange-600">MyNutrition - For physical health</li>
                <li class="text-red-600">MyJournal - For mental journalling</li>
                <li class="text-blue-600">MyReviews - To review anything, from food to places!</li>
            </ul>
        </div>

    </div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
<script src="{{ mix('js/app.js') }}" defer></script>

</body>


</html>