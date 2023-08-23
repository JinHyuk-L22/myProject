<?php

namespace App\Http\Controllers\Member;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use \App\Http\Requests\Member\LoginPostRequest;

use App\Models\User;

use RealRashid\SweetAlert\Facades\Alert;

class MemberController extends Controller
{

    public function __construct()
    {
        // route 이름이아닌 메소드 이름써야함
        $this->middleware('guest')
            ->except([
                'logout'
                , 'createMember'
                , 'adminList'
                , 'updateMember'
                , 'destroyMember'
            ]);
    }

    public function loginView()
    {
        return view('member.index');
    }

    // 사용자가 생성한 리퀘스트 조건?
    public function login(LoginPostRequest $request)
    {

        // 제약조건 변수
        $credentials = $request->validated();

        // 넘어온 값들로 유저 테이블에서 매칭 비밀번호는 자동 해시처리됨 return bool
        if( Auth::attempt($credentials) ){

            // 세션 id 재생성
            $request->session()->regenerate();
            // Alert::alert('Title', 'Message', 'Type');
            Alert::alert( Auth::user()->name.'님 환영합니다.' );
            
            return redirect()
                ->intended();
        } else {

            // 데이터 임시 저장
            $request->flash();
            $request->flashOnly($request->input('member_id'));

            Alert::error('실패', '일치하는 정보가 없습니다.');
            return back();
        }

    }

    public function username()
    {
        return 'member_id';
    }

    public function createMember(Request $request)
    {

        User::create([
            'member_name' => $request->member_name
            , 'member_id' => $request->member_id
            , 'passwd' => Hash::make($request->passwd)
            , 'level' => '9'
            , 'created_at' => time()
        ]);

        return redirect()->back()->with(['alert' => '추가되었습니다.']);

    }

    public function updateMember(Request $request)
    {
        $user = User::find($request->sid);

        if( !$user ){
            return redirect()->back()->with(['alert' => '존재하지않는 계정입니다.']);
        }

        DB::beginTransaction();
        try {
            $user->update([
                'member_name' => $request->member_name
                , 'member_id' => $request->member_id
                , 'passwd' => $request->passwd ? Hash::make($request->passwd) : $user->passwd
                , 'updated_at' => time()
            ]);
        } catch (QueryException $e) {
            DB::rollBack();
            redirect()->back()->with([
                'alert' => '수정에 실패하였습니다.'. $e
            ]);
        }
        DB::commit();

        return redirect()->back()->with(['alert' => '수정되었습니다.']);

    }

    public function destroyMember(Request $request)
    {

        $user = User::find($request->sid);

        if( !$user ){
            return json_encode([
                'msg' => '존재하지않는 계정입니다.'
            ]);
        }

        DB::beginTransaction();
        try {
            $user->delete();
        } catch (QueryException $e) {
            DB::rollBack();
            return json_encode([
                'msg' => '삭제에 실패하였습니다.'. $e
            ]);
        }
        DB::commit();

        return json_encode([
            'msg' => '삭제되었습니다.'
        ]);

    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('member.login');
    }

    public function adminList()
    {

        $user = User::where([
            [ 'level' , 9 ]
        ])->get();

        return json_encode($user);
    }

}
