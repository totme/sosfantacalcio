<?php


namespace App\Libraries;

use App\Notifications\Log\CustomSlackNotification;
use Illuminate\Support\Facades\Notification;

class CustomLog
{
    public static function _log($message, $class, $type, $fields = [])
    {
        Notification::route('slack', env('SLACK_HOOK'))
            ->notify(new CustomSlackNotification($message, $type, $class, $fields));
    }
}
