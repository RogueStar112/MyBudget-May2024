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
    <link href="{{ asset('css/mybudget_viewhistory.css') }}" rel="stylesheet" type="text/css">
    <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>

    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
 
</head>
<body>
    @php
      use Carbon\Carbon;
      
    @endphp
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
    
        <div class="container">

          <h1 class="text-center">HISTORY MEDIA BUTTONS</h1>

          <div class="history_table_mediabuttons">
            <div class="view-media-container"><div class="view-text">VIEW</div>
            <button class="btn btn-primary" onClick="viewSpendingHistory()">SPENDING HISTORY</button>
            <button class="btn btn-success" onClick="viewBudgetHistory()">BUDGET HISTORY</button>
            <button class="btn btn-danger" onClick="viewPercentageHistory()">BUDGET PERCENTAGES</button>
            </div>
          </div>

          <div class="table" id="THE-HISTORY-TABLE">
            
            <style type="text/css">
                .tg  {border-collapse:collapse;border-spacing:0;font-family:Montserrat;}
                .tg td{border-color:black;border-style:solid;border-width:1px;font-family:Montserrat; sans-serif;font-size:14px;
                  overflow:hidden;padding:10px 5px;word-break:normal;}
                .tg th{border-color:black;border-style:solid;border-width:1px;font-family:Montserrat; sans-serif;font-size:14px;
                  font-weight:normal;overflow:hidden;padding:10px 5px;word-break:normal;}
                .tg .tg-c3ow{border-color:inherit;text-align:center;vertical-align:top}
                .tg .tg-gnml{border-color:inherit;font-family:serif !important;font-size:100%;text-align:center;vertical-align:middle}
                .tg .tg-0pky{border-color:inherit;text-align:left;vertical-align:top}
                </style>

                <h1>SPENDING HISTORY TABLE</h1>

                <div class="color-legend d-flex">
                  <ul class="d-flex" style="margin: 10px; width: 100%; justify-content: space-around; font-size: 25px;">
                    
                    <!-- <li style="width: 100%;">SPENDING LEGEND</li><br> -->
                    <li style="background-color: hsl(150, 100%, 50%);"><£25</li>
                    <li style="background-color: hsl(80, 100%, 50%);">>£25 - £75</li>
                    <li style="background-color: hsl(45, 100%, 50%);">>£75 - £199</li>
                    <li style="background-color: hsl(25, 100%, 50%);">>£200 - £499</li>
                    <li style="background-color: hsl(0, 100%, 30%); color: white; font-weight: 800;">>£500</li>

                  </ul>
                </div>

                <table class="tg">
                <thead>
                  <tr class="table_labels">

                    @php
                    $CELLS_LEN = count($month_range);
                    //echo 'CELLS LEN: ' . $CELLS_LEN;
                    $sum_total = 0;

                    @endphp

                    <th class="tg-gnml" rowspan="2">CATEGORIES</th>
                    <th class="tg-c3ow" colspan="{{$CELLS_LEN}}">WEEK STARTING</th>
                  </tr>
                  <tr class="table_dates">
                
                    @foreach($month_range as $months)
                    <th class="tg-c3ow">{{date('d/m/Y', strtotime($months))}}<br></th>

                    <!--
                    <th class="tg-c3ow">8th May 2022</th>
                    <th class="tg-c3ow">15th May 2022</th>
                    <th class="tg-c3ow">22nd May 2022</th>
                    <th class="tg-c3ow">29th May 2022</th>
                    <th class="tg-c3ow">5th June 2022</th>
                    <th class="tg-c3ow">12th June 2022</th>
                    <th class="tg-c3ow">19th June 2022</th>
                    <th class="tg-c3ow">26th June 2022</th>
                    <th class="tg-c3ow">3rd July 2022</th>
                    <th class="tg-c3ow">10th July 2022</th>
                    -->
                    @endforeach
                  </tr>
                </thead>
                <tbody>
                
                    @foreach($all_categories as $category_selected)
                    @php
                    $SELECT_SECTIONS_FROM_CATEGORY = DB::table('mybudget_section')
                                                        ->select('id', 'name')
                                                        ->where('category_id', '=', $category_selected->id)
                                                        ->get();
                    
                    //$custom_rowspan = $SELECT_SECTIONS_FROM_CATEGORY->count();
                    //$remaining_rows = (13 - $custom_rowspan);


                    @endphp


                    @foreach($SELECT_SECTIONS_FROM_CATEGORY as $section_selected)
                    <tr>
                        
                   
                        <td class="tg-c3ow icon-cell" style="background-color: {{$category_selected['color-bg']}}; color: {{$category_selected['color-text']}}; position: relative; padding-right: 25px;">{{$section_selected->name}}
                            <i class="fas" style="height: 100%; line-height: 50%; position: absolute; right: 0; top: 100%; opacity: 0.5; scale: 2.4;">{{html_entity_decode($category_selected['icon-code'])}}</i>
                        </td>
                        
                        @foreach($month_range as $months)
                        @php


                          $months_Carbon = new Carbon("$months");

                          $months_Carbon_addweek = $months_Carbon->copy()->subSecond()->addWeek(1);

                          $section_id = $section_selected->id;

                          $section_name = $section_selected->name;

                          $months_Carbon_idformat = date('Ymd', strtotime($months_Carbon));
                          
                          $DATERANGE_SUM = DB::table('mybudget_item')
                                    ->join('mybudget_category', 'mybudget_item.category_id', '=', 'mybudget_category.id')
                                    ->join('mybudget_section', 'mybudget_item.section_id', '=', 'mybudget_section.id')
                                    ->join('mybudget_source', 'mybudget_item.source_id', '=', 'mybudget_source.id')
                                    ->select('REPLACE(mybudget_item.price, ",", "") as sum_price')
                                    //->selectRaw("SUM(REPLACE(mybudget_item.price, ',', '')) as price_twodp")
                                    ->where('mybudget_section.name', '=', "$section_name")
                                    ->where('mybudget_item.has_subtransactions', '=', 0)
                                    //->where('mybudget_section.name', '!=', 'Income')
                                    ->whereNull('deleted_at')
                                    ->whereBetween("mybudget_item.created_at", [$months_Carbon, $months_Carbon->copy()->subSecond()->addWeek(1)])
                                    //->groupBy('mybudget_item.created_at')
                                    //->orderBy('mybudget_item.created_at', "asc")
                                    ->sum('mybudget_item.price');

                          $DATERANGE_SUM_SUBTRANSACTIONS = DB::table('mybudget_subtransactions')
                                    ->join('mybudget_section', 'mybudget_subtransactions.section_id', '=', 'mybudget_section.id')
                                    //->select('mybudget_item.created_at')
                                    //->selectRaw("SUM(REPLACE(mybudget_item.price, ',', '')) as price_twodp")
                                    ->where('mybudget_subtransactions.section_id', '=', "$section_id")
                                    //->where('mybudget_section.name', '!=', 'Income')
                                    ->whereBetween("mybudget_subtransactions.created_at", [$months_Carbon, $months_Carbon->copy()->subSecond()->addWeek(1)])
                                    //->groupBy('mybudget_item.created_at')
                                    //->orderBy('mybudget_item.created_at', "asc")
                                    ->sum('mybudget_subtransactions.price');

                          $DATERANGE_SUM_BUDGET = DB::table('mybudget_sectionbudget')
                                    ->select('budget')
                                    //->where('date_start', '<', $months_Carbon)
                                    //->where('date_end', '>', $months_Carbon_addweek)
                                    ->whereBetween('date_start', [$months_Carbon, $months_Carbon_addweek])
                                    ->where('date_end', '>', $months_Carbon_addweek)
                                    ->where('category_id', '=', $category_selected->id)
                                    ->where('section_id', '=', $section_id)
                                    ->sum('budget');

                          $TOTAL_SUM = $DATERANGE_SUM + $DATERANGE_SUM_SUBTRANSACTIONS;

                           
                        @endphp
                              
                              @if($DATERANGE_SUM != 0 xor $DATERANGE_SUM_SUBTRANSACTIONS != 0)
                                
                                @if($TOTAL_SUM < 25)

                                <td style="background-color: hsl(150, 100%, 50%);" class="custom-tooltip">

                                @endif

                                @if($TOTAL_SUM >= 25 and $TOTAL_SUM <= 75)
                                
                                <td style="background-color: hsl(80, 100%, 50%);" class="custom-tooltip">
                                
                                @endif

                                @if($TOTAL_SUM > 75 and $TOTAL_SUM <= 199)
                                <td style="background-color: hsl(45, 100%, 50%);" class="custom-tooltip">

                                @endif

                                @if($TOTAL_SUM > 199 and $TOTAL_SUM <= 500)
                                <td style="background-color: hsl(25, 100%, 50%); font-weight: 600;" class="custom-tooltip">

                                @endif

                                @if($TOTAL_SUM > 500)
                                <td style="background-color: hsl(0, 100%, 30%); color: white; font-weight: 800;" class="custom-tooltip">

                                @endif
                                
                                <a href="/budgeting-app/app/transactions/show/{{$section_id}}/{{$months_Carbon}}/{{$months_Carbon_addweek}}">
                                  £{{number_format($TOTAL_SUM, 2)}} 
                                  <span class="custom-tooltip-span" id="custom-tooltip-span-{{$section_id}}-{{$months_Carbon_idformat}}">
                                    <div class="color-strip" style="background-color: {{$category_selected['color-bg']}};">
                                    </div>{{$section_name}}
                                    <br>{{date('M j Y', strtotime($months_Carbon))}} - {{date('M j Y', strtotime($months_Carbon_addweek))}}
                                    <br>Money spent: £{{number_format($TOTAL_SUM, 2)}}
                                    @if ($DATERANGE_SUM_BUDGET != 0)
                                    <br>Budget: £{{number_format($DATERANGE_SUM_BUDGET, 2)}}
                                    <br>Percentage spent: {{number_format($TOTAL_SUM/$DATERANGE_SUM_BUDGET, 2)*100}}%</br>
                                      @if(($TOTAL_SUM/$DATERANGE_SUM_BUDGET)*100 >= 0 && ($TOTAL_SUM/$DATERANGE_SUM_BUDGET)*100 < 25)
                                      <br>Status: Well Within Budget
                                      @endif

                                      @if(($TOTAL_SUM/$DATERANGE_SUM_BUDGET)*100 > 25 && ($TOTAL_SUM/$DATERANGE_SUM_BUDGET)*100 <= 75)
                                      <br>Status: Within Budget
                                      @endif

                                      @if(($TOTAL_SUM/$DATERANGE_SUM_BUDGET)*100 > 75 && ($TOTAL_SUM/$DATERANGE_SUM_BUDGET)*100 <= 100)
                                      <br>Status: Suitable Budget
                                      @endif

                                      @if(($TOTAL_SUM/$DATERANGE_SUM_BUDGET)*100 > 100 && ($TOTAL_SUM/$DATERANGE_SUM_BUDGET)*100 <= 200)
                                      <br>Status: Overspent
                                      @endif

                                      @if(($TOTAL_SUM/$DATERANGE_SUM_BUDGET)*100 > 200)
                                    <br>Status: Grossly Overspent (>200%)
                                      @endif

                                    @else
                                    <br>Budget: N/A</br>
                                    @endif


                                    <i class="fas" style="height: 100%; line-height: 50%; position: absolute; right: 20px; top: 100%; opacity: 0.25; scale: 2.4;">{{html_entity_decode($category_selected['icon-code'])}}</i>
                                  </span>
                                    
                                 </a>
                                 
                                </td>

                              @endif

                              @if($DATERANGE_SUM_SUBTRANSACTIONS != 0 and $DATERANGE_SUM != 0)
                              
                                @if($TOTAL_SUM < 25)

                                <td style="background-color: hsl(150, 100%, 50%);" class="custom-tooltip">

                                @endif

                                @if($TOTAL_SUM >= 25 and $TOTAL_SUM <= 75)
                                
                                <td style="background-color: hsl(80, 100%, 50%);" class="custom-tooltip">
                                
                                @endif

                                @if($TOTAL_SUM > 75 and $TOTAL_SUM <= 199)
                                <td style="background-color: hsl(45, 100%, 50%);" class="custom-tooltip">
                                @endif

                                @if($TOTAL_SUM > 199 and $TOTAL_SUM <= 500)
                                <td style="background-color: hsl(25, 100%, 50%); font-weight: 600;" class="custom-tooltip">
                                @endif

                                @if($TOTAL_SUM > 500)
                                <td style="background-color: hsl(0, 100%, 30%); color: white; font-weight: 800;" class="custom-tooltip">
                                @endif
                                  
                                <a href="/budgeting-app/app/transactions/show/{{$section_id}}/{{$months_Carbon}}/{{$months_Carbon_addweek}}">
                                  £{{number_format($TOTAL_SUM, 2)}} 
                                  <span class="custom-tooltip-span" id="custom-tooltip-span-{{$section_id}}-{{$months_Carbon_idformat}}">
                                    <div class="color-strip" style="background-color: {{$category_selected['color-bg']}};">
                                    </div>{{$section_name}}
                                    <br>{{date('M j Y', strtotime($months_Carbon))}} - {{date('M j Y', strtotime($months_Carbon_addweek))}}
                                    <br>Money spent: £{{number_format($TOTAL_SUM, 2)}}
                                    @if ($DATERANGE_SUM_BUDGET != 0)
                                    <br>Budget: £{{number_format($DATERANGE_SUM_BUDGET, 2)}}
                                    <br>Percentage spent: {{number_format($TOTAL_SUM/$DATERANGE_SUM_BUDGET, 2)*100}}%</br>
                                      @if(($TOTAL_SUM/$DATERANGE_SUM_BUDGET)*100 >= 0 && ($TOTAL_SUM/$DATERANGE_SUM_BUDGET)*100 < 25)
                                      <br>Status: Well Within Budget
                                      @endif

                                      @if(($TOTAL_SUM/$DATERANGE_SUM_BUDGET)*100 > 25 && ($TOTAL_SUM/$DATERANGE_SUM_BUDGET)*100 <= 75)
                                      <br>Status: Within Budget
                                      @endif

                                      @if(($TOTAL_SUM/$DATERANGE_SUM_BUDGET)*100 > 75 && ($TOTAL_SUM/$DATERANGE_SUM_BUDGET)*100 <= 100)
                                      <br>Status: Suitable Budget
                                      @endif

                                      @if(($TOTAL_SUM/$DATERANGE_SUM_BUDGET)*100 > 100 && ($TOTAL_SUM/$DATERANGE_SUM_BUDGET)*100 <= 200)
                                      <br>Status: Overspent
                                      @endif

                                      @if(($TOTAL_SUM/$DATERANGE_SUM_BUDGET)*100 > 200)
                                     <br>Status: Grossly Overspent (>200%)
                                      @endif

                                    @else
                                    <br>Budget: N/A</br>
                                    @endif


                                    <i class="fas" style="height: 100%; line-height: 50%; position: absolute; right: 20px; top: 100%; opacity: 0.25; scale: 2.4;">{{html_entity_decode($category_selected['icon-code'])}}</i>
                                  </span>
                                 </a>
                              
                                </td>
                              @endif

                              {{-- 
                              @if( $section_name == 'Income')
                                <td style="background-color: lime; color: black; font-weight: 800;"><a href="/budgeting-app/app/transactions/show/{{$section_id}}/{{$months_Carbon}}/{{$months_Carbon_addweek}}">£{{number_format($TOTAL_SUM, 2)}}</a></td>
                              @endif
                              --}}

                              @if($TOTAL_SUM == 0)
                                  <td style="background-color: hsl(170, 100%, 50%);">£0.00</td>
                              @endif

                        @endforeach

      
                   </tr>
                        

                    
                   @endforeach

                   @if($loop->last)
                     <tr>
                       <td>TOTAL COSTS</td> 
                       @foreach($month_range as $months)
                       
                       @php
                           $months_Carbon = new Carbon("$months");

                           $DATERANGE_SUM_ii = DB::table('mybudget_item')
                                    ->join('mybudget_section', 'mybudget_section.id', '=', 'mybudget_item.section_id')
                                    ->select('*')
                                    //->selectRaw("SUM(REPLACE(mybudget_item.price, ',', '')) as price_twodp")
                                    //->where('mybudget_section.name', '=', "$section_name")
                                    ->where('mybudget_section.name', '!=', 'Income')
                                    ->whereNull('deleted_at')
                                    ->whereBetween("mybudget_item.created_at", [$months_Carbon, $months_Carbon->copy()->subSecond()->addWeek(1)])
                                    //->groupBy('mybudget_item.created_at')
                                    //->orderBy('mybudget_item.created_at', "asc")
                                    ->sum('mybudget_item.price');

                            //echo $DATERANGE_SUM_ii;
                       @endphp
                        <td>£{{number_format($DATERANGE_SUM_ii, 2)}}</td>
                       @endforeach
                     </tr>
                   @endif

                   @endforeach

                   <!--
                  <tr>
                    <td class="tg-c3ow"></td>
                    <td class="tg-c3ow"></td>
                    <td class="tg-c3ow"></td>
                    <td class="tg-c3ow"></td>
                    <td class="tg-c3ow"></td>
                    <td class="tg-c3ow"></td>
                    <td class="tg-c3ow"></td>
                    <td class="tg-c3ow"></td>
                    <td class="tg-c3ow"></td>
                    <td class="tg-c3ow"></td>
                    <td class="tg-c3ow"></td>
                    <td class="tg-c3ow"></td>
                  </tr>

                  <tr>
                    <td class="tg-c3ow"></td>
                    <td class="tg-c3ow"></td>
                    <td class="tg-c3ow"></td>
                    <td class="tg-c3ow"></td>
                    <td class="tg-c3ow"></td>
                    <td class="tg-c3ow"></td>
                    <td class="tg-c3ow"></td>
                    <td class="tg-c3ow"></td>
                    <td class="tg-c3ow"></td>
                    <td class="tg-c3ow"></td>
                    <td class="tg-c3ow"></td>
                    <td class="tg-c3ow"></td>
                  </tr>
                  <tr>
                    <td class="tg-c3ow"></td>
                    <td class="tg-c3ow"></td>
                    <td class="tg-c3ow"></td>
                    <td class="tg-c3ow"></td>
                    <td class="tg-c3ow"></td>
                    <td class="tg-c3ow"></td>
                    <td class="tg-c3ow"></td>
                    <td class="tg-c3ow"></td>
                    <td class="tg-c3ow"></td>
                    <td class="tg-c3ow"></td>
                    <td class="tg-c3ow"></td>
                    <td class="tg-c3ow"></td>
                  </tr>
                  <tr>
                    <td class="tg-c3ow"></td>
                    <td class="tg-c3ow"></td>
                    <td class="tg-c3ow"></td>
                    <td class="tg-c3ow"></td>
                    <td class="tg-c3ow"></td>
                    <td class="tg-c3ow"></td>
                    <td class="tg-c3ow"></td>
                    <td class="tg-c3ow"></td>
                    <td class="tg-c3ow"></td>
                    <td class="tg-c3ow"></td>
                    <td class="tg-c3ow"></td>
                    <td class="tg-c3ow"></td>
                  </tr>
                  <tr>
                    <td class="tg-c3ow"></td>
                    <td class="tg-c3ow"></td>
                    <td class="tg-c3ow"></td>
                    <td class="tg-c3ow"></td>
                    <td class="tg-c3ow"></td>
                    <td class="tg-c3ow"></td>
                    <td class="tg-c3ow"></td>
                    <td class="tg-c3ow"></td>
                    <td class="tg-c3ow"></td>
                    <td class="tg-c3ow"></td>
                    <td class="tg-c3ow"></td>
                    <td class="tg-c3ow"></td>
                  </tr>
                  -->
                </tbody>
                </table>
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
  function viewSpendingHistory() {
    //var div_target = document.getElementById('THE-HISTORY-TABLE');

    var url=`/budgeting-app/app/budget/spending_history`;

    $("#THE-HISTORY-TABLE").load(url);
    
  }

  function viewBudgetHistory() {
    var url=`/budgeting-app/app/budget/budget_history`;

    $("#THE-HISTORY-TABLE").load(url);
  }

  function viewPercentageHistory() {
    var url = '/budgeting-app/app/budget/budget_history_percentages'

    $("#THE-HISTORY-TABLE").load(url);
  }

  /*
  var tooltipSpan = document.getElementsByClassName('custom-tooltip-span');

  for (var i = 0; i < tooltipSpan.length; i++) {
    window.onmousemove = function (e) {
        var x = e.clientX,
            y = e.clientY;
        
        console.log(tooltipSpan[i].style);
        //tooltipSpan[i].style.top = (y + 20) + 'px';
        //tooltipSpan[i].style.left = (x + 20) + 'px';

        
    };
  }
  */

  $(document).ready(function() {

        $(`.custom-tooltip`).on('mousemove', function(e){
          
          $('span', this).css({left: (e.clientX + 20), top: (e.clientY + 20)});
          
        });

        /*
        $(`[id^="custom-tooltip-span-"]`).on('mouseover', function(){
          
          console.log('TESTOSTERONE');

        });
        */
    });

</script>

</html>