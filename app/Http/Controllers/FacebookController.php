<?php

namespace App\Http\Controllers;

use App\Enum\Role;
use App\Libraries\CustomLog;
use App\Notifications\User\SuperAdminCreate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class FacebookController extends Controller
{
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function handleFacebookCallback(Request $request)
    {
        try {
            $user = Socialite::driver('facebook')->user();
            $findUser = User::where('facebook_id', $user->id)->first();

            if ($findUser) {
                $findUser->profile_photo_path = $user->avatar;
                $findUser->save();
                Auth::login($findUser);

                return redirect()->intended('dashboard');
            } else {
                $insert = [
                    'username' =>  Str::slug($user->name).'_'.rand(1, 3),
                    'name' => $user->name,
                    'email' => $user->email,
                    'facebook_id'=> $user->id,
                    'profile_photo_path' => $user->avatar,
                    'password' => encrypt(Str::random(16))
                ];

                $adminEmails = \explode(',', getenv('ADMIN_EMAILS'));

                if (in_array($user->email, $adminEmails)) {
                    $insert['role'] = Role::SUPERADMIN;
                }

                $newUser = User::create($insert);

                Auth::login($newUser);

                return redirect()->route('dashboard');
            }
        } catch (Exception $e) {
            $errorData = [
                'ip' => $request->getClientIp(),
                'time' => Carbon::now()->format('Y-m-d H:i')
            ];

            if (!empty($user)) {
                $errorData['facebook_id'] = $user->id;
            }
            CustomLog::_log($e->getMessage(), __CLASS__, 'error', $errorData);
            return redirect()->route('error.page');
        }
    }
}
