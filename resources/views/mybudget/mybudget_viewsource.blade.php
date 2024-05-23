

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
      <link href="{{ asset('css/mylifeline_source.css') }}" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">

    
   </head>
   <body>
      <div id="app">
         <x-navbar-complete brandName='MyBudget' />
      
      <div class="container">   
            <h1 class="mt-3" style="font-variant: small-caps; font-weight: 800;">Sources</h1>

            @isset($all_categories_selected)
            
            @foreach($all_categories_selected as $category_selected)

            @if($loop->index % 3 == 0 or $loop->iteration == 1)
                <div class="row">
            @endif

            <div class="col-sm">

                <div class="section-container">
                    
                        
                    <div class="section-custom" style="background-color: {{$category_selected->color_bg}}; ">
                        
                        @php
                            
                        @endphp
                        <div class="section-icon">
                            <i class="fas upscale-icon-2x" style="color: {{$category_selected->color_text}};"id="">{{html_entity_decode($category_selected->icon_code)}}</i>
                        </div>
                    
                    </div>


                    <div class="section-wrapper-dark">

                        <!--
                        <div class="section-remover">

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
                            <th class="col-md-4 text-center">Source</th>
                            <th class="col-md-8 text-center">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @php
                            $insert_userid = Auth::id();

                            $GET_SOURCES = DB::table('mybudget_item')
                            ->join('mybudget_source', 'mybudget_item.source_id', '=', 'mybudget_source.id')
                            ->select('mybudget_item.*', 'mybudget_source.name as source_name')
                            ->where('mybudget_item.category_id', '=', $category_selected->id)
                            ->where('mybudget_item.user_id', "=", "$insert_userid")
                            ->groupBy('mybudget_item.id', 'source_name')
                            ->orderBy('id', 'asc')
                            ->distinct()
                            ->get();
                            
                            @endphp

                            @foreach($GET_SOURCES as $SOURCE)
                            
                            <tr class="text-center">
                                <td class="col-md-4 text-center">{{$SOURCE->source_name}}
                                
                                <td class="d-flex justify-content-around">
                                    <a class="btn btn-primary" href="/budgeting-app/app/view/sources/{{$SOURCE->source_id}}"><i class="fas fa-eye"></i></a>
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

            @isset($source_selected)

            @foreach($source_selected as $source)

            @if($loop->iteration == 1)
            <div class="source_title">
                    <h1>{{$source->source_name}}</h1>
            </div>

            
            <div class="sections-covered">
                <h1>Sections Covered</h1>
            
            @endif

            <p>{{$source->section_name}}<p>
            
            @if($loop->last)
            </div>
            @endif
            
            @endforeach


            @endisset

            @isset($section_selected, $section_items, $category_selected)
            
            
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
                                <td>£{{number_format($items->price, 2)}}</td>
                                <td>{{date('d/m/Y', strtotime($items->created_at))}}</td>
                                <td>{{$items->source_name}}</td>
                            </tr>
                            @endforeach

                            @foreach($section_selected as $section)
                            
                            @php
                            $insert_userid = Auth::id();

                            $GET_SUBTRANSACTIONS_FROM_ITEM = DB::table('mybudget_subtransactions')
                                                        ->join('mybudget_category', 'mybudget_subtransactions.category_id', '=', 'mybudget_category.id')
                                                        ->join('mybudget_section', 'mybudget_subtransactions.section_id', '=', 'mybudget_section.id')
                                                        ->join('mybudget_source', 'mybudget_subtransactions.source_id', '=', 'mybudget_source.id')
                                                        ->select('mybudget_subtransactions.*', 'mybudget_category.name as category_name', 'mybudget_section.name as section_name', 'mybudget_source.name as source_name')
                                                        //->select('mybudget_section.name as section_name')
                                                        ->selectRaw('REPLACE(price, ",", "") as sum_price')
                                                        ->where("section_id", $section->id)
                                                        ->where('mybudget_category.user_id', "=", "$insert_userid")
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
                                <td>£{{number_format($subtransaction->sum_price, 2)}}</td>
                                <td>{{date('d/m/Y', strtotime($subtransaction->created_at))}}</td>
                                <td>{{$subtransaction->source_name}}</td>
                            </tr>
                            @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>

            <div class="col-sm">

            </div>

            <div class="col-sm">

            </div>

            @else

        
            @endisset

        </div>
            
       
      </div>
      <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
   </body>
</html>


