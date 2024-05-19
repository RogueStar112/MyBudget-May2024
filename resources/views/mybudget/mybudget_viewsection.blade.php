

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
      <link href="{{ asset('css/mylifeline_section.css') }}" rel="stylesheet" type="text/css">
      
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
    
      @include('functions.hex_to_rgba')
      
      <div class="container">

            <h1 class="mt-3" style="font-variant: small-caps; font-weight: 800;">Sections</h1>

            @isset($all_categories_selected)
            
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
                            <th class="col-md-8 text-center">Actions</th>
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
                                    <a class="btn btn-primary" href="/budgeting-app/app/view/section/{{$SECTION->id}}"><i class="fas fa-eye"></i></a>
                                    <a class="btn btn-warning"><i class="fas fa-pencil-alt"></i></a> 
                                    <a class="btn btn-danger"><i class="fas fa-trash-alt"></i></a>
                                </td>
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

            @endisset

            @isset($section_selected, $section_items, $category_selected)
            
            <div class="row" >
            <div class="col-sm" style="margin-right: 10px; border-right: 2px solid black;">

                <div class="section-container-alt">
                    @php
                        $bg_gradient_color = hex2rgba($category_selected['color-bg']);
                    @endphp

                    <div class="row" style=" background: rgb(255,255,255);
                    background: linear-gradient(180deg, rgba(255,255,255,1) 67%, {{$bg_gradient_color}} 100%); ">
                        
                        <div class="col-md-10">
                            
                            @foreach($section_selected as $section)
                            <h1 style="color: {{$category_selected['color-bg']}}; text-transform: uppercase; font-variant: small-caps; font-weight: 800;">{{$section->name}}</h1>
                            @endforeach
                            
                        </div>
                        
                        <div class="col-md-2 d-flex" style="align-items: center; justify-content: center;">
                            <i class="fas upscale-icon-2x" style="color: {{$category_selected['color-bg']}}; opacity: 0.7; line-height: 1;">{{html_entity_decode($category_selected['icon-code'])}}</i>
                        </div>
                    </div>

                    {{-- 
                    <div class="section-custom" style="background-color: {{$category_selected['color-bg']}}; ">
                        
                        @php
                            
                        @endphp
                        <div class="section-icon">
                            <i class="fas upscale-icon-2x" style="color: {{$category_selected['color-text']}};"id="">{{html_entity_decode($category_selected['icon-code'])}}</i>
                        </div>
                    
                    </div>


                    <div class="section-wrapper-dark">

                        <!--
                        <div class="section-remover">

                        </div>
                        -->

                        <div class="section-title">
                            @foreach($section_selected as $section)
                                {{$section->name}}
                            @endforeach
                        </div>
                    </div>
                    --}}

                </div>
                
                {{-- 
                <div class="section-container">
                        
                    <div class="section-custom" style="background-color: {{$category_selected['color-bg']}}; ">
                        
                        @php
                            
                        @endphp
                        <div class="section-icon">
                            <i class="fas upscale-icon-2x" style="color: {{$category_selected['color-text']}};"id="">{{html_entity_decode($category_selected['icon-code'])}}</i>
                        </div>
                    
                    </div>


                    <div class="section-wrapper-dark">

                        <!--
                        <div class="section-remover">

                        </div>
                        -->

                        <div class="section-title">
                            @foreach($section_selected as $section)
                                {{$section->name}}
                            @endforeach
                        </div>
                    </div>
                    
                </div>
                --}}
                
                <div class="section-details">
                    <table class="table">

                        <thead>
                            
                            <tr class="text-center">
                            <th class="col-md-1 text-center">#</th>
                            <th class="col-md-3 text-center">Item</th>
                            <th class="col-md-3 text-center">Price</th>
                            <th class="col-md-3 text-center">Date</th>
                            <th class="col-md-2 text-center">Source</th>
                            </tr>
                        </thead>

                        <tbody>
                            
                            @Foreach($section_items as $items)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$items->name}}</td>
                                <td>£{{number_format($items->price_twodp, 2)}}</td>
                                <td>{{date('d/m/Y', strtotime($items->created_at))}}</td>
                                <td>{{$items->source_name}}</td>
                            </tr>
                            @endforeach

                            @foreach($section_selected as $section)
                            
                            @php
                            $GET_SUBTRANSACTIONS_FROM_ITEM = DB::table('mybudget_subtransactions')
                                                        ->join('mybudget_category', 'mybudget_subtransactions.category_id', '=', 'mybudget_category.id')
                                                        ->join('mybudget_section', 'mybudget_subtransactions.section_id', '=', 'mybudget_section.id')
                                                        ->join('mybudget_source', 'mybudget_subtransactions.source_id', '=', 'mybudget_source.id')
                                                        ->select('mybudget_subtransactions.*', 'mybudget_category.name as category_name', 'mybudget_section.name as section_name', 'mybudget_source.name as source_name')
                                                        //->select('mybudget_section.name as section_name')
                                                        ->selectRaw('REPLACE(price, ",", "") as sum_price')
                                                        ->where("section_id", $section->id)
                                                        //->where("section_id", $SECTION_ID)
                                                        //->distinct()
                                                        ->get();
                                                        
                            @endphp
                            
                            <tr>
                                <th colspan="5" style="background-color: orange;">SUBTRANSACTIONS</td>
                            </tr>

                            @Foreach($GET_SUBTRANSACTIONS_FROM_ITEM as $subtransaction) 

                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$subtransaction->name}}</td>
                                <td>£{{number_format($subtransaction->price, 2)}}</td>
                                <td>{{date('d/m/Y', strtotime($subtransaction->created_at))}}</td>
                                <td>{{$subtransaction->source_name}}</td>
                            </tr>
                            @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>

            <div class="col-sm d-flex" style="border-left: 2px solid black;">
                <div style="height: 50%; width: 50%; max-height: 600px; border-bottom: 2px solid black;">
                    <canvas id="myBarChart" width="500" height="500"></canvas>
                </div>  

                <div style="height: 25%; width: 50%; max-height: 600px;">
                    <canvas id="myPieChart" width="100%" height="100%"></canvas>
                </div>

                <div class="height: 25%">
                
                </div>
            </div>

            @else

        
            @endisset

        </div>
        
       
      </div>
      <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
      <script
			  src="https://code.jquery.com/jquery-3.6.0.js"
			  integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
			  crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>

      @isset($labels, $bar_data, $pie_data)
      <script>
          const ctx = document.getElementById('myBarChart').getContext('2d');
          
          if (document.getElementById('myBarChart').style.width <= 600 || document.getElementById('myBarChart').style.height <= 600) {
            ctx.canvas.width = document.getElementById('myBarChart').style.width;
            ctx.canvas.height = document.getElementById('myBarChart').style.height;
          } else {
            ctx.canvas.width = 600;
            ctx.canvas.height = 600;
          }
          
          //ctx.style.backgroundColor = {{ Js::from($bg_color) }};

          var chartdata = {
                        labels: {{ Js::from($labels) }},
                        datasets: [
                            {
                                label: 'Money Spent (£)',
                                backgroundColor: {{ Js::from($bar_color) }},
                                borderColor: '#46d5f1',
                                hoverBackgroundColor: '#CCCCCC',
                                hoverBorderColor: '#666666',
                                data: {{ Js::from($bar_data) }}
                            }
                        ],
                    };
            
         var graphTarget = $("#myBarChart");

         var barGraph = new Chart(graphTarget, {
                type: 'bar',
                data: chartdata
         });

         const ctx_ii = document.getElementById('myPieChart').getContext('2d');
          
          if (document.getElementById('myPieChart').style.width <= 600 || document.getElementById('myPieChart').style.height <= 600) {
            ctx.canvas.width = document.getElementById('myPieChart').style.width;
            ctx.canvas.height = document.getElementById('myPieChart').style.height;
          } else {
            ctx.canvas.width = 600;
            ctx.canvas.height = 600;
          }
          
          //ctx.style.backgroundColor = {{ Js::from($bg_color) }};

          var chartdata_ii = {
                        plugins: [ChartDataLabels],
                        options: {
                            datalabels: {
                                color: '#FFFFFF'
                            }
                        },
                        labels: {{ Js::from($pie_labels) }},
                        datasets: [
                            {
                                label: 'Money Spent (£)',
                                backgroundColor: ['#fee101', '#d6af36', '#d7d7d7', '#a7a7ad', '#a77044', '#824a02', '#824a02', '#824a02', '#824a02', '#824a02'],
                                borderColor: '#46d5f1',
                                hoverBackgroundColor: '#CCCCCC',
                                hoverBorderColor: '#666666',
                                data: {{ Js::from($pie_data) }}
                            }
                        ],
                        data: {
                            datasets: [{
                            // Change options only for labels of THIS DATASET
                            datalabels: {
                                color: '#FFFFFF'
                            }
                            }],
                        }
                    };
            
         var graphTarget_ii = $("#myPieChart");

         var barGraph = new Chart(graphTarget_ii, {
                type: 'pie',
                data: chartdata_ii
         });

         
         /*
          const myChart = (ctx, {
                type: 'bar',
                data: {
                    labels: {{ Js::from($labels) }},;
                    datasets: [{
                        label: '# of Votes',
                        data: {{ Js::from($bar_data) }}
                        borderWidth: 1
                    }]
                },
                
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
          */
      </script>
      @endisset


   </body>
</html>

