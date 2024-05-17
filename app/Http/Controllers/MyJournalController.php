<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class MyJournalController extends Controller
{
    public function entries_page()
    {   
        
        return view('myjournal/myjournal_entries')->with('userName', Auth::user()->name);
    }

    public function entries_view() {

        $SELECT_JOURNAL_ENTRIES = DB::table('myjournal_entries')
                                    ->select('*')
                                    ->where('user_id', '=', Auth::id())
                                    ->orderBy('id', 'desc')
                                    ->get();

        $GET_TAGS = DB::table('myjournal_tags')
                        ->select('*')
                        ->where('user_id', '=', Auth::id())
                        ->orderBy('name', 'asc')
                        ->get();

        return view('myjournal/myjournal_entries_view')->with('userName', Auth::user()->name)
                                                       ->with('userEntries', $SELECT_JOURNAL_ENTRIES)
                                                       ->with('userTags', $GET_TAGS);

                                    
        
    }   

    public function entries_store(Request $request) {
        
        // CONSTANTS
        $current_datetime = date('Y-m-d H:i:s');
        $insert_userid = Auth::id();
        //

        // INPUT VARIABLES FOR MYJOURNAL_ENTRIES
            $insert_title = $request->input('title-form');
            $insert_content = Crypt::encryptString($request->input('content-form'));

        //

        $INSERT_ENTRY = DB::table('myjournal_entries')->insert([
            'created_at' => "$current_datetime",
            'updated_at' => "$current_datetime",
            'user_id' => $insert_userid, 
            'content' => $insert_content,
            'is_bookmarked' => 0,
            'title' => $insert_title
        ]);

        $GET_LATEST_ENTRY_ID = DB::table('myjournal_entries')->select('id')->where('user_id', '=', $insert_userid)->orderBy('id', 'desc')->first();

        // INPUT VARIABLES FOR MYBUDGET_TAGS AND MORE


            // String_replace removes any spaces from the tags
            $insert_tags = strtolower(str_replace(' ', '', $request->input('tags-form')));
            $insert_tags_array = explode(",", $insert_tags);
        //

        for ($i = 0; $i < count($insert_tags_array); $i++) {
        
        $insert_tag_element = $insert_tags_array[$i];
        $CHECK_IF_TAG_ALREADY_EXISTS = DB::select("SELECT id from myjournal_tags where name = ? and user_id = ?", [$insert_tag_element, $insert_userid]);
        
            if (count($CHECK_IF_TAG_ALREADY_EXISTS) < 1) {
                $INSERT_TAG = DB::insert('insert into myjournal_tags (user_id, name) values (?, ?)', [$insert_userid, $insert_tag_element]);

                $SELECT_TAG_ID = DB::select("SELECT id from myjournal_tags where name = ?", [$insert_tag_element]);

                foreach($SELECT_TAG_ID as $TAG_SELECTED) {
                    $TAG_ID = $TAG_SELECTED->id;
                }


                foreach($GET_LATEST_ENTRY_ID as $ENTRY_ID_SELECTED) {
                    $ENTRY_ID = $ENTRY_ID_SELECTED;
                }

                $INSERT_TAG_INTO_LOG = DB::insert('insert into myjournal_entries_tags (user_id, tag_id, entry_id) values (?, ?, ?)', [$insert_userid, $TAG_ID, $ENTRY_ID]);



            } else {
                
                foreach($CHECK_IF_TAG_ALREADY_EXISTS as $TAG_SELECTED) {
                    $TAG_ID = $TAG_SELECTED->id;
                }

                foreach($GET_LATEST_ENTRY_ID as $ENTRY_ID_SELECTED) {
                    $ENTRY_ID = $ENTRY_ID_SELECTED;
                }


                $INSERT_TAG_INTO_LOG = DB::insert('insert into myjournal_entries_tags (user_id, tag_id, entry_id) values (?, ?, ?)', [$insert_userid, $TAG_ID, $ENTRY_ID]);

                

            }
        }
                        
        
        return view('myjournal/myjournal_entries')->with('userName', Auth::user()->name)
                                                  ->with('success_message', $insert_title);
    }

    public function entries_select_array($array) {
        
        $array = explode(",", $array);



        $tag_array = [];

        $SELECT_JOURNAL_ENTRIES_WITH_TAG = DB::table('myjournal_entries_tags')
                                            ->select('entry_id')
                                            ->whereIn('tag_id', [$array])
                                            ->where('user_id', '=', Auth::id())
                                            ->orderBy('id', 'asc')
                                            ->pluck('entry_id');

        foreach ($SELECT_JOURNAL_ENTRIES_WITH_TAG as $journal_tag) {
            array_push($tag_array, $journal_tag);
        }
 
        //echo $tag_array;

                                            
        $SELECT_JOURNAL_ENTRIES = DB::table('myjournal_entries')
                                    ->select('*')
                                    ->whereIn('id', $tag_array)
                                    ->where('user_id', '=', Auth::id())
                                    ->orderBy('id', 'desc')
                                    ->get();

        /*
        $GET_TAGS = DB::table('myjournal_tags')
                        ->select('*')
                        ->where('user_id', '=', Auth::id())
                        ->orderBy('id', 'desc')
                        ->get();
    
        
        //return $SELECT_JOURNAL_ENTRIES_WITH_TAG;

        $SELECT_JOURNAL_ENTRIES_THROUGH_ENTRY = DB::table('myjournal_entries')
                                                   ->select('content', 'title')
                                                   ->where('user_id', '=', Auth::id())
                                                   ->get();    
        */

        if ($array == '') {
            $SELECT_JOURNAL_ENTRIES = DB::table('myjournal_entries')
                ->select('*')
                ->where('user_id', '=', Auth::id())
                ->orderBy('id', 'desc')
                ->get();
        }

        return view('myjournal/partial_views/myjournal_entries_filter')->with('userName', Auth::user()->name)
                                                                       ->with('userEntries', $SELECT_JOURNAL_ENTRIES)
                                                                       //->with('userTags', $GET_TAGS)
                                                                       ->render();
                                                                       

    }

    public function edit_entry_form($user_id, $id) {

        $validation = False;


        if ($user_id == Auth::id()) {
            $validation = True;
        }



        if ($validation == True) {

            $SELECT_JOURNAL_ENTRY_TO_EDIT = DB::table('myjournal_entries')
                                                ->select('*')
                                                ->where('user_id', '=', Auth::id())
                                                ->where('id', '=', $id)
                                                ->get();

            return view('myjournal/myjournal_entries_edit')->with('userName', Auth::user()->name)
                                                           ->with('userEntries', $SELECT_JOURNAL_ENTRY_TO_EDIT);

            


        } else {



        }


    }
    
    public function myjournal_error_page() {

    }

    public function ratings_page() {
        return view('myjournal/myjournal_ratings')->with('userName', Auth::user()->name);



        
    }



}
