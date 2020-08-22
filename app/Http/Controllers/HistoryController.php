<?php

namespace Bulkly\Http\Controllers;

use Bulkly\BufferPosting;
use Bulkly\SocialPostGroups;
use Illuminate\Support\Facades\Session;
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

    public function showPosts()
    {
        $and = "";

        if (isset($_GET['date']) && $_GET['date'] != "") {
            $date = $_GET['date'];
            Session::put('date', $date);
            $and .= " AND DATE(created_at) = '" . $date . "'";
        } else {
            Session::put('date', "");
            $and .= "";
        }

        if (isset($_GET['group_id']) && $_GET['group_id'] != "") {
            $group_id = $_GET['group_id'];
            Session::put('group_id', $group_id);
            $and .= " AND group_id = " . $group_id;
        } else {
            Session::put('group_id', "");
            $and .= "";
        }

        $groups = SocialPostGroups::all();
        $posts = BufferPosting::selectRaw(" * ")->whereRaw(1 . $and)->with("groupInfo")->with('accountInfo')->paginate(10);

        return view('pages.history2')->with('groups', $groups)->with('posts', $posts);
    }

}

