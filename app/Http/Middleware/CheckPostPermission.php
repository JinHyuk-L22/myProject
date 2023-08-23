<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;

class CheckPostPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $bbs_name = $request->route()->parameter('bbs_name');
        $bbs_permission = config('site.bbs.' . $bbs_name . '.permission');
        view()->share('bbs_name', $bbs_name);
        view()->share('bbs_permission', $bbs_permission);
        view()->share('selected_first_menu_key', config('site.bbs.' . $bbs_name . '.first_menu_key'));
        view()->share('selected_second_menu_key', config('site.bbs.' . $bbs_name . '.second_menu_key'));

        $call_method = $request->route()->getActionMethod();
        $post = $request->route()->parameter('post');

        $permission_name = null;
        switch ($call_method) {
            case 'create':
            case 'store':
                $permission_name = 'create';
                break;
            case 'index':
                $permission_name = 'index';
                break;
            case 'show':
                $permission_name = 'show';
                break;
            case 'edit':
                $permission_name = 'edit';
                break;
            case 'update':
                $permission_name = 'update';
                break;
            case 'change':
                $permission_name = 'update';
                break;
            case 'list':
                $permission_name = 'list';
                break;
            default:
                $permission_name = $call_method;
        }


        if( in_array($request->route()->getActionMethod(), ['create', 'store', 'edit', 'update', 'destroy']) ){
//            if( !Auth::check() ){
//                return redirect()->route('member.login')->with('alert', '로그인 후에 이용해주세요.');
//            }
        }

        if (!is_null($post) && !$post->hasPermission($permission_name)) {
            return redirect()->back()->with('alert', '권한이 없습니다.');
        } elseif (is_null($post) && !is_null($permission_name) && !$bbs_permission[$permission_name]()) {
            return redirect()->back()->with('alert', '권한이 없습니다.');
        }

        return $next($request);
    }
}
