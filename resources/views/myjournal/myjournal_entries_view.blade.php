<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MyJournal - Entries</title>

    <script src="https://kit.fontawesome.com/c36ba6cddf.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>

    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    

    <link href="{{ asset('css/mylifeline_home.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/myjournal_home.css') }}" rel="stylesheet" type="text/css">
    <link href="http://fonts.cdnfonts.com/css/luna-2" rel="stylesheet">
</head>
<body>
    <div id="app">
        <x-navbar brandName="MyJournal" brandColor="red">
            <x-slot name="items">
                <x-navbar-item url="/.." title="HOME" color="red" icon="home" />
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
                <form id="logout-form" action="{{ url('logout') }}" method="POST">
                    {{ csrf_field() }}
                    <li class="nav-item m-1" style="background-color: red">
                        <button class="nav-link" type="submit"><i class="fas fa-sign-out-alt"></i><p></p><div class="label-bottom">LOGOUT</div></button>
                    </li>
                </form>

                @isset($userName)

                <div class="diagonal-divider"></div>
                
                <p class="m-3" style="text-align: right; color: white; font-family: Montserrat;">Welcome, {{$userName}}.</p>

                @endisset
            </x-slot>
        </x-navbar>

        @isset($success_message)

            <h1 class="success-message" style="text-align: center; background-color: green; color: white; padding: 20px;"><i class="fas fa-check-circle"></i> Entry added: {{$success_message}}!</h1>

        @endisset

        <div class="row">
            
            <div class="col-md-6" style="transform: skew(-10deg); margin: 0 auto;">
            <h1 class="journal-entries-header" style="">JOURNAL ENTRIES</h1>
            </div>
        </div>

        <div class="container">

            <div class="row">
            <div class="row col-md-8" id="ENTRIES-CONTAINER">

                @foreach($userEntries as $entry)

                        
                <div class="row mt-3 ">
                
                <div class="col-md-12 col-xs-12 MYJOURNAL-CONTAINER" style="border: 4px solid maroon;">
                    
                    <div class="row remove-row-margins-sides">
                    
                        <div class="col-md-10">
                            <h1 class="remove-margins" style="text-align: left; padding: 20px; border-bottom: 4px solid black; background-color: maroon; color: white; font-weight: 700;">{{$entry->title}}</h1>
                        </div>
                        
                        @php

                        @endphp
                        <div class="col-md-2 d-flex">
                            <div class="col-md-6">
                                <a href="{{ config('app.url')}}/journalling-app/entries/edit/{{$entry->user_id}}/{{$entry->id}}" class="btn btn-warning" style="width: 100%; height: 80%; border-radius: 0;"><i class="fas fa-pencil-alt" style="scale: 2;"></i></a>
                                <p style="text-align: center; font-size: 0.7rem;">EDIT</p>
                            </div>
                            <div class="col-md-6">
                                <a href="{{ config('app.url')}}/journalling-app/entries/delete/{{$entry->user_id}}/{{$entry->id}}" class="btn btn-danger" style="width: 100%; height: 80%; border-radius: 0;"><i class="fas fa-trash-alt" style="scale: 2;"></i></a>
                                <p style="text-align: center; font-size: 0.7rem;">DELETE</p>
                            </div>
                        </div>

                    </div>

                    <p style="text-align: left;" class="m-3">{{date('d/m/Y h:iA', strtotime($entry->created_at))}}</p>
                    <ul style="padding: 20px; background-color: beige;" class="d-flex tags-list">
                        @php
                    
                            $GET_JOURNAL_TAGS = DB::table('myjournal_entries_tags')
                                            ->join('myjournal_entries', 'myjournal_entries_tags.entry_id', '=', 'myjournal_entries.id')
                                            ->join('myjournal_tags', 'myjournal_entries_tags.tag_id', '=', 'myjournal_tags.id')
                                            ->select('myjournal_tags.name as tag_name', 'myjournal_entries_tags.entry_id')
                                            ->where('myjournal_entries_tags.entry_id', '=', $entry->id)
                                            ->where('myjournal_entries.user_id', '=', Auth::id())
                                            ->orderBy('tag_name', 'asc')
                                            ->get();

                        @endphp 

                        @foreach($GET_JOURNAL_TAGS as $tag) 
                            <li>{{$tag->tag_name}}</li>
                        
                        @endforeach
                    </ul>
                    <p style="white-space: pre-wrap; word-wrap: break-word; text-align: left; padding: 20px;">{{Crypt::decryptString($entry->content)}}</p>
                </div>
                
                @if($loop->first) 

                    {{-- 
                    <div class="col-md-3" style="border: 4px solid maroon; margin-left: 10px;" id="tag-filter">
                        <h1 class="mt-3">Tag Filter</h1>

                        <form id="TAG-FILTER-FORM">
                            
                            @foreach($userTags as $tag)

                            <div class="form-check m-3">
                                <input class="form-check-input" type="checkbox" value="{{$tag->id}}" id="flexCheckDefault-{{$tag->id}}">
                                <label class="form-check-label" for="flexCheckDefault-{{$tag->id}}">
                                    {{$tag->name}}
                                </label>
                            </div>

                            @endforeach

                        </form>
                    </div> 
                    --}}
                @else


                @endif

                </div>

                @endforeach

            </div>

            <div class="col-md-3 mt-3" style="border: 4px solid maroon; margin-left: 10px;" id="tag-filter">
                <h1 class="p-3" style="background-color: maroon; color: white;">Tag Filter</h1>

                <form id="TAG-FILTER-FORM">
                
                    @csrf

                    @foreach($userTags as $tag)

                    <div class="form-check m-3">
                        <input class="form-check-input" type="checkbox" value="{{$tag->id}}" id="flexCheckDefault-{{$tag->id}}">
                        <label class="form-check-label" for="flexCheckDefault-{{$tag->id}}">
                            {{$tag->name}}
                        </label>
                    </div>

                    @endforeach

                </form>
            </div> 
            </div>

            
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <script
                  src="https://code.jquery.com/jquery-3.6.0.js"
                  integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
                  crossorigin="anonymous"></script>

<script>
    //credit to: https://stackoverflow.com/questions/590018/getting-all-selected-checkboxes-in-an-array

    $("input[type=checkbox]").click(function () {
        var array = []
        var checkboxes = document.querySelectorAll('input[type=checkbox]:checked')

        for (var i = 0; i < checkboxes.length; i++) {
        array.push(checkboxes[i].value)
        }

        console.log(array);

        $.ajax({
        
        type: "GET",
        url: `/journalling-app/entries/select/${array}`,
        success: function (data) {
                    $("#ENTRIES-CONTAINER").html(data);
                    console.log('success!')
                }
        });
    });



</script>
</body>