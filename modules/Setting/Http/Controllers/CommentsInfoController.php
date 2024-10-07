<?php

namespace Modules\Setting\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\CommentsInfo;
use Illuminate\Support\Facades\DB;
use Brian2694\Toastr\Facades\Toastr;

class CommentsInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {

        $dbData = DB::table('comments_infos')
            ->join('users', 'users.id', '=', 'comments_infos.com_user_id')
            ->select('comments_infos.*', 'users.full_name as name', 'users.profile_image as photo', 'users.email')
            ->where('comments_infos.deleted_at', Null)
            ->orderBy('comments_infos.com_id', 'DESC')
            ->get();

        return view('setting::comments.index', compact('dbData'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('setting::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('setting::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('setting::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update($com_id)
    {
        $comments_info = CommentsInfo::where('com_id', $com_id)->first();
        if($comments_info->com_status == 0){
            $res_up = CommentsInfo::where('com_id', $com_id)->update(['com_status' => 1]);
            if($res_up){
                return redirect()->route('comments.comments_manage')->with('success', localize('data_updated_successfully'));
            }else{
                return redirect()->route('comments.comments_manage')->with('fail', localize('something_wen_wrong'));
            }
        }else{
            $res_up = CommentsInfo::where('com_id', $com_id)->update(['com_status' => 0]);
            if($res_up){
                return redirect()->route('comments.comments_manage')->with('success', localize('data_updated_successfully'));
            }else{
                return redirect()->route('comments.comments_manage')->with('fail', localize('something_wen_wrong'));
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(CommentsInfo $comment)
    {
        CommentsInfo::where('id', $comment->id)->forceDelete();
        Toastr::success('Comments Deleted successfully :)', 'Success');
        return response()->json(['success' => 'success']);
    }
}
