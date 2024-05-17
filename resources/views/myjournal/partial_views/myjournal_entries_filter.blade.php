
@foreach($userEntries as $entry)

                            
    <div class="row mt-3 ">

    <div class="col-md-12 col-xs-12 MYJOURNAL-CONTAINER" style="border: 4px solid maroon;">
        
        <div class="row remove-row-margins-sides">
        
            <div class="col-md-10">
                <h1 class="remove-margins" style="text-align: left; padding: 20px; border-bottom: 4px solid black; background-color: maroon; color: white; font-weight: 700;">{{$entry->title}}</h1>
            </div>

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