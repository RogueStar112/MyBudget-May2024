<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MyLifeline - Spending Reports</title>

    <script src="https://kit.fontawesome.com/c36ba6cddf.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>

    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    

    <link href="{{ asset('css/mylifeline_home.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/mylifeline_report.css') }}" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">



</head>
<body>
    <div id="app">
        <x-navbar-complete brandName='MyBudget' />

  </div>

  <div id="THE-REPORT-CONTAINER" class="container report-container" style="position: relative;">
    
    <h1 class="spending-report-text">SPENDING REPORTS
        <p class="spending-report-subtext">Get a word-friendly version of your spending history</p>
    </h1>

    <div class="custom-icon"><i class="fas fa-scroll"></i></div>

    <div id="REPORTS" class="container-fluid">
         <!-- form template taken from https://mdbootstrap.com/docs/standard/forms/overview/ -->
        <form id="THE-REPORT-FORM" action="" method="GET">
            @csrf
            <!-- Email input -->
            <div class="form-outline mb-4">
            
              <div class="row d-flex" style="justify-content: center;">
              <div class="col-md-5">
              <input type="date" id="report-date-start" name="report-date-start" class="form-control" />
              <label class="form-label" for="report-date-start">Date Start</label>
              </div>

              <div class="col-md-2"></div>

              <div class="col-md-5">
              <input type="date" id="report-date-end" name="report-date-end" class="form-control" />
              <label class="form-label" for="report-date-end">Date End</label>
              </div>
             </div>

            </div>
          
            <!-- Password input -->
            <div class="form-outline mb-4">
            
            </div>
          
            <!-- 2 column grid layout for inline styling -->
            <div class="row mb-4">
              <div class="col d-flex justify-content-center">
                <!-- Checkbox -->
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="" id="report-checkbox" required />
                  <label class="form-check-label" for="report-checkbox"> I agree not to take the spending report as my own work </label>
                </div>
              </div>
              
              {{--
              <div class="col">
                <!-- Simple link -->
                <a href="#!">Forgot password?</a>
              </div>

              --}}
            </div>
          
            <!-- Submit button -->
            <button type="submit" class="btn btn-primary btn-block">Generate Report</button>
          </form>

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
        $('#report-checkbox').removeAttr('checked');
    });

    $(document).ready(function() {
        if ($('#report-checkbox').change(function() {
            if(this.checked) {
                console.log('This works just fine! Antarctica');

                var start_date = $('#report-date-start').val();

                var end_date = $('#report-date-end').val();

                //document.getElementById("CATEGORY_METHOD").setAttribute("value", "GET")
                document.getElementById("THE-REPORT-FORM").setAttribute("action", `/budgeting-app/app/reports/generate/${start_date}/${end_date}`)
            }
        }));
    });

</script>

</html>