<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    public const OPERATION_INCREMENT = 'INC';
    public const OPERATION_DECREMENT = 'DEC';

    public const TYPE_ANSWERS = 'answers';
    public const TYPE_QUESTIONS = 'questions';
    public const TYPE_CREDITS = 'credits';
    public const TYPE_RAISE = 'raise';
    public const TYPE_SHARES = 'shares';

    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'facebook_id',
        'credits',
        'questions',
        'answers',
        'raise',
        'level',
        'role',
        'profile_photo_path'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function changeValue($operation , $type = self::TYPE_ANSWERS, $value = 1)
    {
        if ($operation  == self::OPERATION_INCREMENT) {
            self::increment($type, $value);
        } else {
            self::decrement($type, $value);
        }
    }
}
