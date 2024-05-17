

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
         <nav class="navbar navbar-expand-sm navbar-dark bg-dark" aria-label="Third navbar example">
            <div class="container-fluid">
               <a class="navbar-brand ms-2 bg-success skew10deg fw-bolder" href="#">MyBudget</a>
               <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample03" aria-controls="navbarsExample03" aria-expanded="false" aria-label="Toggle navigation">
               <span class="navbar-toggler-icon"></span>
               </button>
               <div class="collapse navbar-collapse" id="navbarsExample03">
                  <ul class="navbar-nav me-auto mb-2 mb-sm-0">
                     <div class="diagonal-divider"></div>
                     <!-- budgeting -->
                     <li class="nav-item bg-orange-skew-np m-1">
                        <a class="nav-link" aria-current="page" href="/..">
                           <i class="fas fa-home"></i>
                           <p> | Budgeting</p>
                           <div class="label-bottom">HOME</div>
                        </a>
                     </li>
                     <!-- fitness/dieting -->
                     <li class="nav-item bg-warning m-1">
                        <a class="nav-link" href="/fitness-app">
                           <i class="fas fa-dumbbell"></i>
                           <p> | Fitness</p>
                           <div class="label-bottom">FITNESS</div>
                        </a>
                     </li>
                     <!-- journalling -->
                     <li class="nav-item bg-danger m-1">
                        <a class="nav-link" href="/journalling-app" tabindex="-1" aria-disabled="true">
                           <i class="fas fa-pencil-alt"></i>
                           <p> | Journalling</p>
                           <div class="label-bottom">JOURNAL</div>
                        </a>
                     </li>
                     <!-- reviews -->
                     <li class="nav-item bg-info m-1">
                        <a class="nav-link" href="/reviewing-app" tabindex="-1" aria-disabled="true">
                           <i class="fas fa-star"></i>
                           <p> | Reviewing</p>
                           <div class="label-bottom">REVIEWS</div>
                        </a>
                     </li>
                     <div class="diagonal-divider"></div>
                     <!-- login -->
                     <li class="nav-item bg-primary m-1 item-square flex-row-reverse">
                        <a class="nav-link" href="#" tabindex="-1" aria-disabled="true">
                           <i class="fas fa-user-alt"></i>
                           <p> | Settings</p>
                           <div class="label-bottom">LOGIN</div>
                        </a>
                     </li>
                     <!-- settings -->
                     <li class="nav-item bg-secondary m-1 item-square flex-row-reverse">
                        <a class="nav-link" href="#" tabindex="-1" aria-disabled="true">
                           <i class="fas fa-cog"></i>
                           <p> | Settings</p>
                           <div class="label-bottom">SETTINGS</div>
                        </a>
                     </li>
                     <!--
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="dropdown03" data-bs-toggle="dropdown" aria-expanded="false">Dropdown</a>
                            <ul class="dropdown-menu" aria-labelledby="dropdown03">
                            <li><a class="dropdown-item" href="#">Action</a></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                            </ul>
                        </li>
                        -->
                  </ul>
                  <!--
                     <form>
                     <input class="form-control" type="text" placeholder="Search" aria-label="Search">
                     </form>
                      -->
               </div>
            </div>
         </nav>

         <!--
         <main class="banner-container">
            <image id="banner" src="https://www.freeimageslive.co.uk/files/images006/hands_at_keyboard.preview.jpg">
            </image>
            <div id="minor-container">
               <div class="slogan">The ultimate budgeting app.</div>
               <div class="slogan-button-container">
                  <div class="diagonal-button">START BUDGETING</div>
               </div>
            </div>
            <router-view></router-view>
         </main>
          -->
      </div>
      <div class="container d-flex justify-content-center position-ref full-height text-center">
        <div class="row">
            <div class="content bg-light">
                <div class="links">
                <p>TRANSACTIONS</p>
                <div class="grey-box">
                    <a href="{{ config('app.url')}}/budgeting-app/app/create"><i class="fas fa-plus bg-success"></i><p>ADD</p></a>
                    <a href="{{ config('app.url')}}/budgeting-app/app"><i class="fas fa-eye bg-primary"></i><p>VIEW</p></a>
                    </div>
                </div>
            </div>

        </div>
        <div class="row">

            <div class="content bg-light">
                <div class="links">
                <p>INCOME</p>
                <div class="grey-box">
                    <a href="{{ config('app.url')}}/budgeting-app/app/create"><i class="fas fa-plus bg-success"></i><p>ADD</p></a>
                    <a href="{{ config('app.url')}}/budgeting-app/app"><i class="fas fa-eye bg-primary"></i><p>VIEW</p></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">

            <div class="content bg-light">
                <div class="links">
                <p>TEST</p>
                <div class="grey-box">
                    <a href="{{ config('app.url')}}/budgeting-app/app/create"><i class="fas fa-plus bg-success"></i><p>ADD</p></a>
                    <a href="{{ config('app.url')}}/budgeting-app/app"><i class="fas fa-eye bg-primary"></i><p>VIEW</p></a>
                    </div>
                </div>
            </div>
        </div>
      </div>
      <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
   </body>
</html>
