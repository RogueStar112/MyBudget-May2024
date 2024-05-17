

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
   </head>
   <body>
      <div id="app">
         <x-navbar brandName="MyBudget" brandColor="green" >
            <x-slot name="items">
                <x-navbar-item url="/.." title="HOME" color="#198754" icon="home" />
                <div class="diagonal-divider"></div>
                <p style="color: white; margin-bottom: 0 !important;" class="skew10deg">APPS</p>
                <x-navbar-item url="/budgeting-app" title="BUDGET" color="green" icon="money-bill-alt" selected/>
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
      
      <div class="container vh-100">

        <div class="row">

            <div class="col-md-4 vh-100">
                <div class="col-md-12 m-3 vh-100" style="background-color: white; height: 100%; position: relative;">
                    
                    <div class="mx-3" style="border: 10px solid red; height: 80%; position: absolute; top: 50%;
                    transform: translate(0, -50%); width: 90%; border-radius: 15px;">

                        <div class="bg-dark">
                            <h1 class="text-white" style="font-family: Montserrat; font-weight: 800;">DATE RANGE A</h1>
                        </div>
                        
                        <div class="date-range-A-start">

                            <label for="transaction-date-A-start">FROM</label>
                            <input type="date" class="form-control text-center" id="transaction-date-1" name="transaction-date-A-start" placeholder="23-01-2022" />

                            <label for="transaction-date-A-end">TO</label>
                            <input type="date" class="form-control text-center" id="transaction-date-1" name="transaction-date-A-end" placeholder="23-01-2022" />

                        </div>

                        <p style="font-style: italic; font-family: Montserrat; font-weight: 400; color: red; font-size: 24px;"></p>
                        <i class="fas fa-balance-scale-left balance-scale-comparison"></i>

                    </div>

                </div>
            </div>

            <div class="col-md-4 vh-100">
                <div class="col-md-12 m-3 vh-100" style="background-color: white; height: 100%; position: relative;">
                    
                    <div class="mx-3" style="border: 10px solid orange; height: 80%; position: absolute; top: 50%;
                    transform: translate(0, -50%); width: 90%; border-radius: 15px;">

                        <h1 class="mt-3" style="color: orange; font-family: Montserrat; font-weight: 800;">DIFFERENCES</h1>

                        <p style="font-style: italic; font-family: Montserrat; font-weight: 400; color: orange; font-size: 24px;"></p>
                        <i class="fas fa-balance-scale balance-scale-comparison"></i>

                    </div>

                </div>
            </div>

            <div class="col-md-4 vh-100">
                <div class="col-md-12 m-3 vh-100" style="background-color: white; height: 100%; position: relative;">
                    
                    <div class="mx-3" style="border: 10px solid blue; height: 80%; position: absolute; top: 50%;
                    transform: translate(0, -50%); width: 90%; border-radius: 15px;">

                        <div class="bg-dark">
                            <h1 class="mt-3" style="color: white; font-family: Montserrat; font-weight: 800;">DATE RANGE B</h1>
                        </div>


                        <div class="date-range-B-start row">

                            <div class="bg-success">
                                <label for="transaction-date-B-start" class="" style="color: white; font-weight: 800; font-style: italic;">FROM</label>
                                <input type="date" class="form-control text-center col-md-10" id="transaction-date-1" name="transaction-date-B-start" placeholder="23-01-2022" />
                            </div>

                            <div class="bg-danger">
                                <label for="transaction-date-B-end" class="" style="color: white; font-weight: 800; font-style: italic;">TO</label>
                                <input type="date"  class="form-control text-center col-md-10" id="transaction-date-1" name="transaction-date-B-end" placeholder="23-01-2022" />
                            </div>

                        </div>

                        <p style="font-style: italic; font-family: Montserrat; font-weight: 400; color: blue; font-size: 24px;"></p>
                        <i class="fas fa-balance-scale-right balance-scale-comparison"></i>

                    </div>

                </div>
            </div>

        </div>
      </div>
      <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
   </body>
</html>

