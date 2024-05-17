<link href="{{ asset('css/mylifeline_home.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('css/mybudget_viewhistory.css') }}" rel="stylesheet" type="text/css">

@php
      use Carbon\Carbon;
      
@endphp
            
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

                <h1>BUDGET HISTORY TABLE</h1>
                <p>The budget you've allocated historically</p>

                <div class="color-legend d-flex">
                  <ul class="d-flex" style="margin: 10px; width: 100%; justify-content: space-around; font-size: 25px;">
                    
                    <!-- <li style="width: 100%;">SPENDING LEGEND</li><br> -->
                    <li style="background-color: hsl(150, 100%, 50%);"><£25<br>Miniscule Budget</li>
                    <li style="background-color: hsl(80, 100%, 50%);">>£25 - £75<br>Minor Budget</li>
                    <li style="background-color: hsl(45, 100%, 50%);">>£75 - £199<br>Major Budget</li>
                    <li style="background-color: hsl(25, 100%, 50%);">>£200 - £499<br>Large Budget</li>
                    <li style="background-color: hsl(0, 100%, 30%); color: white; font-weight: 800;">>£500<br>Huge Budget</li>

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
                          
                          $DATERANGE_SUM = DB::table('mybudget_sectionbudget')
                                              ->select('budget')
                                              //->where('date_start', '<', $months_Carbon)
                                              //->where('date_end', '>', $months_Carbon_addweek)
                                              ->whereBetween('date_start', [$months_Carbon, $months_Carbon_addweek])
                                              ->where('date_end', '>', $months_Carbon_addweek)
                                              ->where('category_id', '=', $category_selected->id)
                                              ->where('section_id', '=', $section_id)
                                              ->sum('budget');

                          $TOTAL_SUM = $DATERANGE_SUM;

                          $DATERANGE_SUM_TRANSACTIONS = $TOTAL_SUM;

                          /*
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

                          $TOTAL_SUM = $DATERANGE_SUM + $DATERANGE_SUM_SUBTRANSACTIONS;

                          */

                           
                        @endphp
                              
                              @if($TOTAL_SUM != 0)
                                
                                @if($TOTAL_SUM < 25)

                                <td style="background-color: hsl(150, 100%, 50%);"><a href="{{ config('app.url')}}/budgeting-app/app/transactions/show/{{$section_id}}/{{$months_Carbon}}/{{$months_Carbon_addweek}}">£{{number_format($TOTAL_SUM, 2)}}</a></td>

                                @endif

                                @if($TOTAL_SUM >= 25 and $TOTAL_SUM <= 75)
                                
                                <td style="background-color: hsl(80, 100%, 50%);"><a href="{{ config('app.url')}}/budgeting-app/app/transactions/show/{{$section_id}}/{{$months_Carbon}}/{{$months_Carbon_addweek}}">£{{number_format($TOTAL_SUM, 2)}}</a></td>
                                
                                @endif

                                @if($TOTAL_SUM > 75 and $TOTAL_SUM <= 199)
                                <td style="background-color: hsl(45, 100%, 50%);"><a href="{{ config('app.url')}}/budgeting-app/app/transactions/show/{{$section_id}}/{{$months_Carbon}}/{{$months_Carbon_addweek}}">£{{number_format($TOTAL_SUM, 2)}}</a></td>
                                @endif

                                @if($TOTAL_SUM > 199 and $TOTAL_SUM <= 500)
                                <td style="background-color: hsl(25, 100%, 50%); font-weight: 600;"><a href="{{ config('app.url')}}/budgeting-app/app/transactions/show/{{$section_id}}/{{$months_Carbon}}/{{$months_Carbon_addweek}}">£{{number_format($TOTAL_SUM, 2)}}</a></td>
                                @endif

                                @if($TOTAL_SUM > 500)
                                <td style="background-color: hsl(0, 100%, 30%); color: white; font-weight: 800;"><a href="{{ config('app.url')}}/budgeting-app/app/transactions/show/{{$section_id}}/{{$months_Carbon}}/{{$months_Carbon_addweek}}">£{{number_format($TOTAL_SUM, 2)}}</a></td>
                                @endif

                              @endif

                              {{-- 
                              @if( $section_name == 'Income')
                                <td style="background-color: lime; color: black; font-weight: 800;"><a href="{{ config('app.url')}}/budgeting-app/app/transactions/show/{{$section_id}}/{{$months_Carbon}}/{{$months_Carbon_addweek}}">£{{number_format($TOTAL_SUM, 2)}}</a></td>
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
