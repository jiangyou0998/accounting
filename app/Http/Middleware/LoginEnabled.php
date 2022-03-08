<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class LoginEnabled
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
        if(Auth::check() && Auth::user()->login_disabled !== 0) {
//            Auth::logout();
            // 手动清除当前用户的 Session 数据
            $request->session()->invalidate();
            // 会话里闪存认证成功后的消息提醒
            session()->flash('danger', '該賬號無法登錄，請重新登錄！');
            return redirect()->route('login');
        }
        return $next($request);
    }
}
