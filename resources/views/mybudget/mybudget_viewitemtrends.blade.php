

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
      <link href="{{ asset('css/mylifeline_itemhistory.css') }}" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">


    @vite('resources/css/app.css')
    
   </head>
   <body>
      <div id="app">
         <x-navbar-complete brandName='MyBudget' />
      
      <div class="container" id="mybudget-item-container">
        <div class="row col-xs-12 col-md-8 mt-3" id="mybudget-item-title">

            <h1 style="color: maroon; font-weight: 800;">ITEM HISTORY  <i class="fas fa-history" style="color: maroon; scale: 1;"></i></h1>
            <p>View an item's price trends</p>

            <form class="form-horizontal" id="VIEW-ITEM-HISTORY-FORM">
                <div class="row mb-3">

                    <!--
                    <div class="col-md-3">
                    <label for="item-search" class=""><i class="fas fa-search"></i></label>
                    </div>
                    -->
                    
                    <div class="col-md-12 d-flex">

                        <input type="text" id="item-search-input" name="item-search" class="form-control" placeholder="Search item here..."/>
                        <button type="button" id="item-search-button" class="btn btn-primary"><i class="fas fa-search"></i></button>
                        
                    </div>
                </div>
            </form>

            <div class="items-list" id="ITEMS-LIST-OUTPUT">

            </div>

            <!--
            <div class="col-md-8" style="text-align: center; padding: 20px; border: 4px solid aqua;" id="mybudget-graph-featured">
                <p>Featured Item</p>
            </div>
            
            <div class="col-md-4" style="text-align: center; padding: 20px; border: 4px solid blue;">
                <p>Pie Chart</p>
            </div>
            -->
            
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
       $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });

        $("#item-search-button").click(function(e) {
        e.preventDefault();
                
            var search_query = $('#item-search-input').val();

            $.ajax({
            
            type: "GET",
            url: `/budgeting-app/app/items/history/${search_query}`,
            success: function (data) {
                        $("#ITEMS-LIST-OUTPUT").html(data);
                        console.log('success!')
                    }
            });

        });
   </script>
</html>

