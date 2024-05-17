

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
      <link href="{{ asset('css/mylifeline_comparison.css') }}" rel="stylesheet" type="text/css">
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

        <div class="container-fluid d-flex ultimate-container">
            <h1 class="versus">VS</h1>
            
            
            <div class="col-md-6 vh-100 d-flex alpha-container" style="/*background-color: navy;*/">
              
              <div class="alpha-icon">
                <h1>£</h1>
              </div>
              
              <div class="alpha-icon-decoration">
                 
              </div>
              
              <div class="comparison-alpha alpha-title">
                  
                  @isset($start_date_a, $end_date_a)
                  @php
                    $month_alpha = date("F", strtotime("$start_date_a"));
                    $year_alpha = date("Y", strtotime("$start_date_a"));

                    $starting_alpha = date("jS", strtotime("$start_date_a"));
                    $ending_alpha = date("jS", strtotime("$end_date_a"));

                  @endphp
                  <div class="alpha-month">{{$month_alpha}}
                    <p class="alpha-year">{{$starting_alpha}}-{{$ending_alpha}} {{$year_alpha}}</p>
                  </div>
                
                  <div class="alpha-month-break">
                      {{$month_alpha}}  
                  </div>
                  @endisset
              </div>
              
              <table id="alpha-table">
                    <thead>
                      <tr>
                      <th>CATEGORY</th>
                      <th>SPENT</th>
                      <th class="right-border-alpha">%</th>
                      </tr>
                      
                    </thead>
                      
                    <tbody>

                      <!--
                      <tr>
                        <td class="alpha-color">Overall</td>
                        <td>£180.00</td>
                        <td>45%</td>
                      </tr>
                      
                      <tr>
                       <td class="alpha-color">Eating Out</td>
                      <td>£60.00</td>
                      <td>60%</td>
                      </tr>
                      
                      <tr>
                        <td class="alpha-color">Bills</td>
                        <td>£120.00</td>
                        <td>40%</td>
                      </tr>
                      -->
                      
                      @isset($alpha_list)

                            @foreach($alpha_list as $alpha_table)
                                <tr>
                                <td class="alpha-color">{{$alpha_table->category_name}}</td>
                                <td>£{{$alpha_table->sum_price}}</td>
                                
                                @foreach($alpha_list_perc as $alpha_table_perc_key => $alpha_table_perc_value)
                                  @if($alpha_table->category_name == $alpha_table_perc_key)
                                  <td>{{number_format($alpha_table_perc_value*100, 1)}}%</td>
                                  </tr>
                                  @endif 
                                @endforeach

                            @endforeach

                      @endisset
                      
                    </tbody>
              </table>
              
            </div>
            
            <div class="col-md-6 vh-100 bravo-container" style="/*background-color: darkred;*/">
              
              <!-- <h1 class="bravo-month">May</h1> -->
              
              <div class="bravo-icon-decoration">
                 
              </div>
              
              <div class="bravo-icon">
                <h1>£</h1>
              </div>
              
              <div class="comparison-bravo bravo-title">

                @isset($start_date_b, $end_date_b)

                @php
                    $month_bravo = date("F", strtotime("$start_date_b"));
                    $year_bravo = date("Y", strtotime("$start_date_b"));

                    $starting_bravo = date("jS", strtotime("$start_date_b"));
                    $ending_bravo = date("jS", strtotime("$end_date_b"));

                  @endphp

                <div class="bravo-month">{{$month_bravo}}
                    <p class="bravo-year">{{$starting_bravo}}-{{$ending_bravo}} {{$year_bravo}}</p>
                </div>
                
                <div class="bravo-month-break">
                      {{$month_bravo}}
                </div>

                @endisset
              </div>
              
              <table id="bravo-table">
                    <thead>
                      <th>CATEGORY</th>
                      <th>SPENT</th>
                      <th class="left-border-bravo">%</th>
            
                      
                    </thead>
                      
                    <tbody>

                      <!--
                      <tr>
                        <td class="bravo-color">Overall</td>
                        <td>£220.00</td>
                        <td>55%</td>
                      </tr>
                      
                      <tr>
                        <td class="bravo-color">Eating Out</td>
                        <td>£40.00</td>
                        <td>40%</td>
                      </tr>
                      
                      <tr>
                        <td class="bravo-color">Bills</td>
                        <td>£180.00</td>
                        <td>60%</td>
                      </tr>

                      -->

                      @isset($bravo_list)

                            @foreach($bravo_list as $bravo_key => $bravo_value)
                                <tr>
                                <td class="bravo-color">{{$bravo_key}}</td>
                                <td>£{{$bravo_value}}</td>
                                
                                @foreach($bravo_list_perc as $bravo_table_perc_key => $bravo_table_perc_value)
                                  @if($bravo_key == $bravo_table_perc_key)
                                  <td>{{number_format($bravo_table_perc_value*100, 1)}}%</td>
                                  </tr>
                                  @endif 
                                @endforeach

                            @endforeach

                      @endisset
                      
                    </tbody>
              </table>
            </div>
            
          </div>
          

        </div>
      </div>
      <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
   </body>
</html>

