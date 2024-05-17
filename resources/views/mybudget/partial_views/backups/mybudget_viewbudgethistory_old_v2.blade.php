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

</head>
<body>

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


            <style type="text/css">
                .tg  {border-collapse:collapse;border-spacing:0;}
                .tg td{border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;
                  overflow:hidden;padding:10px 5px;word-break:normal;}
                .tg th{border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;
                  font-weight:normal;overflow:hidden;padding:10px 5px;word-break:normal;}
                .tg .tg-c3ow{border-color:inherit;text-align:center;vertical-align:top}
                .tg .tg-gnml{border-color:inherit;font-family:serif !important;font-size:100%;text-align:center;vertical-align:middle}
                .tg .tg-0pky{border-color:inherit;text-align:left;vertical-align:top}
                </style>
                <table class="tg">
                <thead>
                  <tr class="table_labels">
                    <th class="tg-gnml" rowspan="2">SPENDING HISTORY</th>
                    <th class="tg-c3ow" colspan="12">WEEK STARTING</th>
                  </tr>
                  <tr class="table_dates">
                    <th></th>
                    <th class="tg-c3ow">1st May 2022<br></th>
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
                  </tr>
                </thead>
                <tbody>
                
                    @foreach($all_categories as $category_selected)
                    @php
                    $SELECT_SECTIONS_FROM_CATEGORY = DB::table('mybudget_section')
                                                        ->select('name')
                                                        ->where('category_id', '=', $category_selected->id)
                                                        ->get();
                    
                    $custom_rowspan = $SELECT_SECTIONS_FROM_CATEGORY->count();
                    $remaining_rows = (13 - $custom_rowspan);
                    @endphp

                   <tr>
                        
                        <th class="tg-c3ow icon-cell" rowspan="{{$custom_rowspan}}" style="background-color: {{$category_selected['color-bg']}}; color: {{$category_selected['color-text']}}; position: relative; padding-right: 25px;">{{$category_selected->name}}
                            <i class="fas" style="height: 100%; line-height: 50%; position: absolute; right: -25%; top: 50%; opacity: 0.5; scale: 2.4; transform: rotate(-45deg);">{{html_entity_decode($category_selected['icon-code'])}}</i>

                        </th>

                        @foreach($SELECT_SECTIONS_FROM_CATEGORY as $section_selected)
                   
                        <td>{{$section_selected->name}}</td>
                    
                        @endforeach
                        
                        <tr>


                        @for($i=0; $i<$remaining_rows; $i++)
                            <td>&nbsp;</td>
                        @endfor
                        
                   </tr>

                    
                   @endforeach

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
                </tbody>
                </table>
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

</script>

</html>