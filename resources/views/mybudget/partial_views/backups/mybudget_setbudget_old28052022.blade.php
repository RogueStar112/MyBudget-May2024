<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MyBudget - Statistics</title>

    <script src="https://kit.fontawesome.com/c36ba6cddf.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>

    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    

    <link href="{{ asset('css/mylifeline_home.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/mylifeline_section.css') }}" rel="stylesheet" type="text/css">

    <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>

</head>
<body>
    @inject('sum_cost', 'App\Http\Controllers\MyBudgetSetBudgetController')

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
        
        @isset($success_message)
            <h1 class="success-message" style="text-align: center; background-color: green; color: white; padding: 20px;">Successfully added {{$success_message->name}} to budget!</h1>
        @endisset


        <div class="container">
            @isset($all_categories_selected)
            
            <form method="POST" action="{{ config('app.url')}}/budgeting-app/app/budget">

            @csrf

            <div class="row mt-3">
                <div class="col-md-6">
                    <label for="setbudget_date_start">Date Start</label>
                    <input id="setbudget_date_start" name="setbudget_date_start" type="date" class="form-control text-center" default="" required/>

                </div>
                
                <div class="col-md-6">
                    <label for="setbudget_date_end">Date End</label>
                    <input id="setbudget_date_end" name="setbudget_date_end" type="date" class="form-control text-center" default="" required/>

                </div>
            </div>

            <div id="THE-BUDGET-CONTAINER">
                {{--
                @foreach($all_categories_selected as $category_selected)
                

                @if($loop->index % 3 == 0 or $loop->iteration == 1)
                    <div class="row">
                @endif

                <div class="col-sm">

                    <div class="section-container">
                        
                            
                        <div class="section-custom" style="background-color: {{$category_selected['color-bg']}}; ">
                            
                            @php
                                
                            @endphp
                            <div class="section-icon">
                                <i class="fas upscale-icon-2x" style="color: {{$category_selected['color-text']}};"id="">{{html_entity_decode($category_selected['icon-code'])}}</i>
                            </div>
                        
                        </div>


                        <div class="section-wrapper-dark">

                            <!-- <div class="section-remover">

                            </div>
                            -->
                            
                            <div class="section-title">
                                {{$category_selected->name}}
                            </div>
                        </div>
                        
                    </div>
                    
                    <div class="section-details">
                        <table class="table">

                            <thead>
                                
                                <tr class="text-center">
                                <th class="col-md-4 text-center">Section</th>
                                <th class="col-md-4 text-center">Actions</th>
                                <th class="col-md-2">Cost</th>
                                <th class="col-md-2">%</th>
                                </tr>
                            </thead>

                            <tbody>
                                @php
                                
                                $GET_SECTIONS = DB::table('mybudget_section')
                                ->select('*')
                                ->where('category_id', '=', $category_selected->id)
                                ->get();
                                
                                @endphp

                                @foreach($GET_SECTIONS as $SECTION)
                                
                                <tr class="text-center">
                                    <td class="col-md-4 text-center">{{$SECTION->name}}</th>
                                    <td class="d-flex justify-content-around">

                                        @isset($start_date, $end_date)
                                        @php
                                        
                                            $GET_SECTION_BUDGET_FROM_SECTION = DB::table('mybudget_sectionbudget')
                                                                                ->select('budget')
                                                                                ->where('section_id', '=', $SECTION->id)
                                                                                ->where("date_start", "=", $start_date)
                                                                                ->where("date_end", "=", $end_date)
                                                                                ->get();
                                            
                                        @endphp

                                        @foreach($GET_SECTION_BUDGET_FROM_SECTION as $SECTION_BUDGET)
                                        <input class="form-control" placeholder="Budget" value="{{(float)$SECTION_BUDGET->budget}}" unique_category="{{$category_selected['id']}}" unique_identifier="{{$SECTION->id}}" id="input-budget-{{$SECTION->id}}" name="input-budget-{{$SECTION->id}}" /> 
                                        
                                        @endforeach
                                        
                                        @if($GET_SECTION_BUDGET_FROM_SECTION->count() == 0)
                                        
                                        <input class="form-control" placeholder="Budget" value="" unique_category="{{$category_selected['id']}}" unique_identifier="{{$SECTION->id}}" id="input-budget-{{$SECTION->id}}" name="input-budget-{{$SECTION->id}}" /> 
                                        
                                        

                                        @endif

                                        @endisset
                                        
                                    
                                    </td>

                                    
                                    <td></td>
                                    <td></td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>

                </div>

                @if($loop->iteration % 3 == 0)
                    <!-- Close the Row Div -->
                    </div>
                @endif 
                @endforeach
                
                <div class="row">
                
                <input type="hidden" id="pages" name="setbudget-pages" value="1"/>
                <button type="submit" style="width: 100%;" class="btn btn-success">SUBMIT</button>
                
                </div>

                </form>

                @endisset
            </div>

            --}}
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


    // Load Subcategories for the appropriate Category
    $(document).ready(function() {
    $('#setbudget_category').on('click', function(){
      
      var id = this.value;
      var url=`/budgeting-app/app/budget/${id}`;

      console.log(url);


      $('#setbudget_section_select').load(url);
        });
    });


    $("#budget-add-radio, #budget-edit-radio").click(function() {
        console.log('Clicked')
        
        if($('#budget-add-radio').is(':checked')) {
            $(".create-budget-form").removeClass("d-none");
        //$("#transaction-add-btn").toggleClass("selected-orange");
        } else {
            $(".create-budget-form").addClass("d-none");
        }

        if($('#budget-edit-radio').is(':checked')) {
            $(".view-budget-form").removeClass("d-none");
        //$("#transaction-add-btn").toggleClass("selected-orange");
        } else {
            $(".view-budget-form").addClass("d-none");
        
        }


    });

    $("#setbudget_date_end").change(function(e) {
    e.preventDefault();
            
        var column_select_val = $('#setbudget_date_start').val();

        var column_search_val = $('#setbudget_date_end').val();

        $.ajax({
        
        type: "GET",

        url: `/budgeting-app/app/budget/${column_select_val}/${column_search_val}`,
        success: function (data) {
                    $("#THE-BUDGET-CONTAINER").html(data);
                    console.log('success!')
                }
        });

    });

    $(document).ready(function() {

        var setbudget_array = [];
        
        var input_budgets = document.querySelectorAll('*[id^="input-budget-"]');

        for (let i = 0; i < input_budgets.length; i++) {
            setbudget_array.push(input_budgets[i].getAttribute('unique_identifier'))
        }

        console.log(setbudget_array);

        document.getElementById('pages').value = setbudget_array;

    })

    

</script>

</html>