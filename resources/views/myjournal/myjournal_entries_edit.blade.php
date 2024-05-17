<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MyJournal - Entry Create</title>

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


        <div class="container">



            <div class="row mt-3">
            
            <div class="col-md-8 col-xs-12 d" id="MYJOURNAL-CONTAINER">
                <h1 class="col-md-12 col-xs-12" style="font-family: Montserrat;">Edit a journal entry<i class="ml-3 fas fa-pen-fancy" style="scale: 1;"></i>
                    <p class="mt-3" style="font-size: 16px; font-family: Luna; ">Rewrite your story</p>
                </h1>

                <form method="POST" action="{{ config('app.url')}}/journalling-app/entries/">
                    @csrf
                    
                    @foreach($userEntries as $entry)
                        <div class="row">
                        <div class="mb-3 row" style="align-items: center;">
                            <div class="col-md-2">
                            <label for="content-form" class="form-label" style="text-align: left;">Title</label>
                            </div>
    
                            <div class="col-md-10">
                            <input maxlength="50" id="title-form" class="form-control" name="title-form" aria-describedby="titleHelp" style="background-color: lightyellow;" value="{{$entry->title}}" required/>
                            <!--<div id="titleHelp" class="form-text">Make your title memorable</div> -->
                            </div>
                        </div>

                        <div class="mb-3 row" style="align-items: center;">
                        <div class="col-md-2">
                        <label for="content-form" class="form-label" style="text-align: left;">Content</label>
                        </div>

                        <div class="col-md-10">
                        <textarea maxlength="10000" id="content-form" class="form-control" name="content-form" aria-describedby="contentHelp" style="height: 25vh; background-color: lightyellow;" required>{{Crypt::decryptString($entry->content)}}</textarea>
                        <div id="contentHelp" class="form-text">Your words are encrypted so people cannot see what you've written directly.<br>Please note there's a 10000 Character Limit.</div>
                        </div>
                        </div>
                        </div>


                        @php
                            $TAG_ARRAY = [];

                            $SELECT_TAGS_FROM_ENTRY = DB::table('myjournal_entries_tags')
                                                        ->join('myjournal_tags', 'myjournal_entries_tags.tag_id', '=', 'myjournal_tags.id')
                                                        ->select('*')
                                                        ->select('myjournal_tags.name as tag_name')
                                                        ->where('myjournal_entries_tags.user_id', '=', Auth::id())
                                                        ->where('myjournal_entries_tags.entry_id', '=', $entry->id)
                                                        ->orderBy('tag_name', 'asc')
                                                        ->get();
                                                        

                            foreach($SELECT_TAGS_FROM_ENTRY as $entry_tag) {
                                array_push($TAG_ARRAY, $entry_tag->tag_name);
                            }
                            

                            // PURPOSE OF LEN ARRAY AND ARRAY COUNTER: To ensure that the last element of the array leaves no comma.
                            $LEN_ARRAY = count($TAG_ARRAY);
                            $ARRAY_COUNTER = 1;
                            
                            foreach($TAG_ARRAY as $element) {
                                
                                echo $element;
                                
                                if ($ARRAY_COUNTER != $LEN_ARRAY) {
                                    echo ", ";
                                } else {

                                }

                                $ARRAY_COUNTER++;



                            }

                        @endphp


                        <div class="mb-3 row">
                            <div class="col-md-2">
                                <label for="tags-form" class="form-label" style="text-align: left;">Tags</label>
                            </div>

                            <div class="col-md-10">
                                <input type="text" id="tags-form" name="tags-form" class="form-control" placeholder="mental-health, introspection, reflection" aria-describedby="tagsHelp" />
                                <div id="tagsHelp" class="form-text">Separate each tag with a comma.</div>
                            </div>

                            <div class="col-md-12 d-flex">
                                <button type="button" class="btn btn-primary mx-3 mt-3" style="width: 49%;">View <i class="fas fa-eye"></i></button>
                                <button type="submit" class="btn btn-success mx-3 mt-3" style="width: 49%;">Submit <i class="fas fa-check"></i></button>
                            </div>
                        </div>
                    @endforeach

                </form>
            </div>


        </div>

    </div>



