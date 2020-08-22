<?php

namespace Bulkly\Http\Controllers;

use Bulkly\BufferPosting;
use Bulkly\SocialPostGroups;
use Yajra\DataTables\DataTables;

class HistoryController extends Controller
{
    public function showHistory()
    {
        $groups = SocialPostGroups::all();

        return view('pages.history')->with('groups', $groups);
    }

    public function getPosts()
    {
        $and = "";
        if (request()->has('post_date') && request('post_date') != null) {
            $and .= " AND DATE(created_at) = '" . request('post_date') . "'";
        }

        if (request()->has('group_id') && request('group_id') != "") {
            $and .= " AND group_id = " . request('group_id');
        }
        $posts = BufferPosting::selectRaw(" * ")->whereRaw(1 . $and)->with("groupInfo")->with('accountInfo')->get();
        return Datatables::of($posts)->make(true);
    }

}
