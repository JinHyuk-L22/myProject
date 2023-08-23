<?php

namespace App\Http\Controllers\Bbs;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;

use App\Http\Requests\Bbs\StoreRequest;

use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\Bbs_tbl;
use App\Models\Schedule;

use RealRashid\SweetAlert\Facades\Alert;

class BbsController extends Controller
{

    public function __construct()
    {
        $this->middleware('check_post_permission');
    }

    public function list( $bbs_name, Request $request )
    {

        // 상단
        $notice_posts = Bbs_tbl::scopes([
            'BbsName'               => $bbs_name
            , 'IsNotice'            => 'Y'
            , 'OrderbyCreatedAt'    => 'DESC'
        ])
        ->get();

        // 게시글
        $posts = Bbs_tbl::scopes([
            'BbsName'               => $bbs_name
            , 'IsNotice'            => 'N'
            , 'OrderbyCreatedAt'    => 'DESC'
        ]);

        // 검색 처리
        foreach( $request->all() as $key => $val ){
            if( ( $val ) && $val == 'content' || $val == 'title' ){
                $posts->scopes([
                    'Like'.$val => $request->get('keyword') ?? ''
                ]);
            }
        }

        // 페이징
        $posts = $posts->paginate(config('site.bbs.' . $bbs_name . '.pageView'))->appends($request->query());
        
        $viewData = [
            'notice_posts'  => $notice_posts
            , 'posts'       => $posts
        ];

        view()->share($viewData);
        return view('bbs.' . config('site.bbs.' . $bbs_name . '.skin').'.list');
    }

    public function show($bbs_name, Request $request)
    {

        if( $bbs_name == 'schedule' ){
            $bbsTbl = Schedule::find($request->sid);
        } else {
            $bbsTbl = Bbs_tbl::find($request->sid);
        }

        if( !$bbsTbl ){
            return redirect()->back()->with('alert', '잘못된 접근입니다.');
        }

        $bbsTbl->read_count = $bbsTbl->read_count+1;
        $bbsTbl->timestamps  = false;
        $bbsTbl->save();

        $viewData = [
            'bbsTbl' => $bbsTbl
        ];
        view()->share($viewData);
        return view('bbs.' . config('site.bbs.' . $bbs_name . '.skin').".show");
    }

    public function create($bbs_name)
    {

        return view('bbs.' . config('site.bbs.' . $bbs_name . '.skin').".create");

    }

    public function edit($bbs_name, Request $request)
    {

        if( $bbs_name == 'schedule' ){
            $bbsTbl = Schedule::find($request->sid);
        } else {
            $bbsTbl = Bbs_tbl::find($request->sid);
        }

        $viewData = [
            'bbsTbl' => $bbsTbl
        ];

        view()->share($viewData);
        return view('bbs.' . config('site.bbs.' . $bbs_name . '.skin') . '.edit');
    }

    public function store($bbs_name, StoreRequest $request)
    {

        // validation이 자동으로 진행되는데 이유는 모르겠음,,

        if( $bbs_name == 'schedule' ){
            $return = Schedule::createBbs( $request->post() );
        } else {
            $return = Bbs_tbl::createBbs( $request->post(), $bbs_name );
        }

        if( $return['status'] == 201 ){
            Alert::success('저장', $return['msg']);
            //  Alert::alert('Title', 'Message', 'Type');
            //  Alert::success('Success Title', 'Success Message');
            //  Alert::info('Info Title', 'Info Message');
            //  Alert::warning('Warning Title', 'Warning Message');
            //  Alert::error('Error Title', 'Error Message');
            //  Alert::question('Question Title', 'Question Message');
            //  Alert::image('Image Title!','Image Description','Image URL','Image Width','Image Height');
            //  Alert::html('Html Title', 'Html Code', 'Type');
            //  Alert::toast('Toast Message', 'Toast Type');
            return redirect()->route( config('site.bbs.'.$bbs_name.'.index'), ['bbs_name' => $bbs_name]);
        } else {
            return redirect()->back()->withInput()->with('alert', '글 등록 중 에러가 발생했습니다. '.$return['msg']);
        }

    }

    public function update($bbs_name, StoreRequest $request)
    {

        if( $bbs_name == 'schedule' ){
            $return = Schedule::updateBbs( $request->post() );
        } else {
            $return = Bbs_tbl::updateBbs( $request->post(), $bbs_name, $request->sid );
        }

        if( $return['status'] == 200 ){
            Alert::success('수정', $return['msg']);
            return redirect()->route( config('site.bbs.'.$bbs_name.'.index'), ['bbs_name' => $bbs_name]);
        } else {
            return redirect()->back()->withInput()->with('alert', '글 등록 중 에러가 발생했습니다. '.$return['msg']);
        }
       
    }

    public function destroy($bbs_name, Request $request)
    {

        if( $bbs_name == 'schedule' ){
            $return = Schedule::deleteBbs( $request->sid );
        } else {
            $return = Bbs_tbl::deleteBbs( $bbs_name, $request->sid );
        }

        if( $return['status'] == 200 ){
            Alert::success('삭제', $return['msg']);
            return redirect()->route( config('site.bbs.'.$bbs_name.'.index'), ['bbs_name' => $bbs_name]);
        } else {
            return redirect()->back()->withInput()->with('alert', '글 등록 중 에러가 발생했습니다. '.$return['msg']);
        }
    }

    public function change($bbs_name, Request $request)
    {

        if( !$request->get('status') ){
            return redirect()->route('bbs.list', ['bbs_name' => $bbs_name])->with('alert', '잘못된 접근 입니다.');
        }

        $return = Bbs_tbl::changeBbs( $bbs_name, $request->sid, $request->get('status') );

        return redirect()->route('bbs.list', ['bbs_name' => $bbs_name])->with('alert', $return['msg']);

    }

    public function calender( $bbs_name, Request $request )
    {

        // config('site.bbs_schedule.tooday');

        $posts = Schedule::orderBy('sdate');
        $datas = Schedule::calenderDatas( $request, $posts );

        $viewData = [
            'datas' => $datas
        ];

        view()->share($viewData);
        return view('bbs.' . config('site.bbs.' . $bbs_name . '.skin').'.list');
    }


}
