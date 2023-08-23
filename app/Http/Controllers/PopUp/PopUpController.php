<?php

namespace App\Http\Controllers\PopUp;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PopUpController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * 미리보기
     *
     * @param Request $request
     * @return $this
     */
    public function preview(Request $request)
    {
        $post_data = $request->post();

//        view()->share($post_data);
        return view('popup.preview')->with(['post_data' => $post_data]);
    }

    /**
     * 닫기
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function close(Request $request)
    {

        $response = response(view('popup.close'));

        if ((bool)$request->post('is_not_open') && !is_null($request->post('popup_id'))) {
            $response->cookie('popup_' . $request->post('popup_id') . '_not_open', true, 24 * 60);
        }

        return $response;
    }

    /**
     * 팝업창
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($sid)
    {

        $popUp = Notices::find($sid);

        return view('info.notice.pop.skin1')->with(['post_data' => $popUp]);
    }
}
