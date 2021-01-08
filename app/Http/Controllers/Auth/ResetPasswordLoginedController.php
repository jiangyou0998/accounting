<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

//2021-01-05 已登錄用戶修改密碼
class ResetPasswordLoginedController extends Controller
{
    public function showResetForm()
    {
        $email = Auth::user()->email;

        // 1. 生成 Token，会在视图 emails.reset_link 里拼接链接
        $token = hash_hmac('sha256', Str::random(40), config('app.key'));

        // 2. 入库，使用 updateOrInsert 来保持 Email 唯一
        DB::table('password_resets')->updateOrInsert(['email' => $email], [
            'email' => $email,
            'token' => Hash::make($token),
            'created_at' => new Carbon,
        ]);

        return view('auth.passwords.reset_logined')->with(
            ['token' => $token]
        );
    }

    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function reset(Request $request)
    {
        // 1. 验证数据是否合规
        $request->validate([
            'token' => 'required',
            'oldpassword' => 'required|password',
            'password' => 'required|confirmed|min:6',
        ]);
        // 2. 获取对应用户
        $user = Auth::user();

        $email = $user->email;
        $token = $request->token;
        // 找回密码链接的有效时间
        $expires = 60 * 10;

        // 3. 如果不存在
        if (is_null($user)) {
            session()->flash('danger', '邮箱未注册');
            return redirect()->back()->withInput();
        }

        // 4. 读取重置的记录
        $record = (array) DB::table('password_resets')->where('email', $email)->first();

        // 5. 记录存在
        if ($record) {
            // 5.1. 检查是否过期
            if (Carbon::parse($record['created_at'])->addSeconds($expires)->isPast()) {
                session()->flash('danger', '链接已过期，请重新尝试');
                return redirect()->back();
            }

            // 5.2. 检查是否正确
            if ( ! Hash::check($token, $record['token'])) {
                session()->flash('danger', 'token錯誤');
                return redirect()->back();
            }

            // 5.3. 一切正常，更新用户密码
            $user->update(['password' => bcrypt($request->password)]);

            // 5.4. 提示用户更新成功
            session()->flash('success', '密码重置成功，请使用新密码登录');
            return redirect()->route('login');
        }

        // 6. 记录不存在
        session()->flash('danger', '未找到重置记录');
        return redirect()->back();

    }

}
