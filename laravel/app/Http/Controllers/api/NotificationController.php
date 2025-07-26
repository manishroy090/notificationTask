<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;
use App\Services\RabbitMQPusher;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use App\Repositories\NotificationRepository;
use App\Http\Requests\NotificationStoreRequest;
use App\Http\Requests\NotificationUpdateRequest;




class NotificationController extends Controller
{
    //

    protected $RabbitMQPusher;
    protected $NotificationRepository;

    protected $rateLimitNo = 10;


    public function __construct(RabbitMQPusher $rabbitMQPusher, NotificationRepository $notificationRepository)
    {

        $this->RabbitMQPusher = $rabbitMQPusher;
        $this->NotificationRepository = $notificationRepository;
    }

    public function store(NotificationStoreRequest $request)
    {
        $validatedNotification =  $request->validated();
    
        $resMessage = "message published successfully";
        try {
            $key = "rate_limit_user_{$validatedNotification['user_id']}";
            $count = Cache::get($key, 0);

            if ($count >= $this->rateLimitNo) {
                return response()->json([
                    'error' => "Rate limit exceeded"
                ], 429);
            }

            Cache::put($key, $count + 1, now()->addHour());
            $notification =  $this->NotificationRepository->StoreNotification($validatedNotification);
            $this->RabbitMQPusher->publish([
                'id' => $notification->id,
                'message' => $notification->message,
                'type'=>$notification->type
            ]);
            log::info(["notification_{$notification->id}"=>$resMessage]);
            return response()->json([
                'message' =>$resMessage 
            ],200);
        } catch (\Throwable $th) {
            //throw $th;
            $resMessage = "Something went wrong";
            log::info([$validatedNotification['user_id']=>$th->getMessage()]);
            return response()->json([
              'message'=>$resMessage 
            ],500);
        }
    }


    public function markNotificationAsProcessed($id)
    {

        $notification =  $this->NotificationRepository->updateNotificationStatus($id);
        if (!$notification) {
            Log::info([$id => $id . "- Notification is not found"]);
            return response()->json(['message' => "Notification Not Found"], 400);
        }
        $this->NotificationRepository->updateNotificationStatus($id, true);

        Log::info([$id => $id . " is marked as processed"]);
        return response()->json([
            'message' => "Notification marked as processed"
        ], 200);
    }


    public function recentNotification()
    {
        $recentNotification = Cache::remember('recent_notification', 60, function () {
            return $this->NotificationRepository->getRecentNotification();
        });


        return response()->json([
            'success' => true,
            'recentNotification' => $recentNotification
        ],200);
    }


    public function notificationSummary()
    {
        $summary = Cache::remember('recent_notification', 60, function () {
             return  $this->NotificationRepository->getNotificationSummary();
        });

        return response()->json([
            'success' => true,
            'summary' => $summary
        ],200);
    }
}
