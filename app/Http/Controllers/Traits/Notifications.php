<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


// use LaravelFCM\Message\OptionsBuilder;
// use LaravelFCM\Message\PayloadDataBuilder;
// use LaravelFCM\Message\PayloadNotificationBuilder;
// use App\Models\api\DeviceToken;
// use FCM;

trait Notifications
{

    /**
     *Statis function to send notification.
    *
    * @param  Array $details
    * @return Response
    */
    public static function sendMobileNotification($details) {
        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60*20);

        $notificationBuilder = new PayloadNotificationBuilder($details["title"]);
        $notificationBuilder->setBody($details["notification_message"])
                            ->setSound('default');

        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData($details["data_message"]);

        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();

        // You must change it to get your tokens

        $tokens = DeviceToken::whereIn("user_id", $details["user_id"])->get();
        $tokens = $tokens->pluck("device_token")->toArray();
        if(!$tokens || count($tokens) <= 0){
            return;
        }
        $downstreamResponse = FCM::sendTo($tokens, $option, $notification, $data);
    }

    /**
     * Function to fetch User notifications
     * 
     * @param string $name
     * 
     */
    public static function getUserNotifications()
    {
        if (auth()->check()) {
            $user = auth()->user();
            
            $_html = '';

            foreach ($user->notifications as $notification) {
                $_html .= $notification->type;
            }
           

            return $_html;
        }
        return null;
    }

    /**
     * Function to fetch User notifications
     * 
     * @param string $name
     * 
     */
    public static function getUserUnreadNotifications()
    {
        if (auth()->check()) {
            $user = auth()->user();
            foreach ($user->unreadNotifications as $notification) {
                echo $notification->type;
            }

            $_html = '';

            return $_html;
        }
        return null;
    }


}
