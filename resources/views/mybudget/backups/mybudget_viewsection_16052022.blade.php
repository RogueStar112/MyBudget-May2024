

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
      
      <div class="container">

        <div class="row">

            @isset($all_categories_selected)
            
            @foreach($all_categories_selected as $category_selected)
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

                        <div class="section-remover">

                        </div>

                        
                        <div class="section-title">
                            {{$category_selected->name}}
                        </div>
                    </div>
                    
                </div>
                
                <div class="section-details">
                    <table class="table">

                        <thead>
                            
                            <tr class="text-center">
                            <th class="col-md-4 text-center">Item</th>
                            <th class="col-md-8 text-center">Source</th>
                            </tr>
                        </thead>

                        <tbody>
                            
                        </tbody>
                    </table>
                </div>

            </div>

            <div class="col-sm">

            </div>

            <div class="col-sm">

            </div>
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

                        <div class="section-remover">

                        </div>


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
                            <th class="col-md-4 text-center">Item</th>
                            <th class="col-md-8 text-center">Source</th>
                            </tr>
                        </thead>

                        <tbody>
                            
                            @Foreach($section_items as $items)
                            <tr>
                                <th>{{$items->name}}</th>
                                <th>{{$items->source_name}}</th>
                            </tr>
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

            <!--
            <div class="col-sm">
                
                <div class="section-container">
                    
                    <div class="section-custom">

                        <div class="section-icon">
                            <i class="fas fa-shopping-cart upscale-icon-2x" id=""></i>
                        </div>
                    
                    </div>

                    <div class="section-wrapper-dark">

                        <div class="section-remover">

                        </div>


                        <div class="section-title">
                            SHOPPING
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

                    </table>
                </div>


            </div>

            <div class="col-sm">
                
                <div class="section-container">
                    
                    <div class="section-custom">

                        <div class="section-icon">
                            <i class="fas fa-shopping-cart upscale-icon-2x" id=""></i>
                        </div>
                    
                    </div>

                    <div class="section-wrapper-dark">

                        <div class="section-remover">

                        </div>


                        <div class="section-title">
                            ENTERTAINMENT
                        </div>
                    </div>

                    
                </div>

                <div class="section-details">
                    <table class="table">

                        <thead>
                            
                            <tr class="text-center">
                            <th class="col-md-4 text-center skew10deg">Section</th>
                            <th class="col-md-8 text-center skew10deg">Actions
                            </th>
                            </tr>
                        </thead>


                        <tbody>
                            <tr>
                                <th>Eating Out</th>
                                <!--  justify-content-between -->
                                <th class="d-flex justify-content-around">
                                    <a class="btn btn-primary"><i class="fas fa-eye"></i></a>
                                    <a class="btn btn-warning"><i class="fas fa-pencil-alt"></i></a> 
                                    <a class="btn btn-danger"><i class="fas fa-trash-alt"></i></a>
                                </th>
                            <tr> 
                                
                            <tr>
                                <th>Games</th>
                                <!--  justify-content-between -->
                                <th class="d-flex justify-content-around">
                                    <a class="btn btn-primary"><i class="fas fa-eye"></i></a>
                                    <a class="btn btn-warning"><i class="fas fa-pencil-alt"></i></a> 
                                    <a class="btn btn-danger"><i class="fas fa-trash-alt"></i></a>
                                </th>
                            <tr> 
                        </tbody>


                    </table>
                </div>

            -->


            </div>

            <div class="col-sm">

            </div>


            </div>
        
            @endisset

        </div>
            
       
      </div>
      <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
   </body>
</html>

