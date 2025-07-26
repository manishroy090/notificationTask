<?php
namespace App\Repositories;
use App\Repositories\Interfaces\NotificationInterface;
use App\Models\Notification;

class NotificationRepository implements NotificationInterface{

    public function StoreNotification($data){
        return   Notification::create($data);
    }

    public function updateNotificationStatus($id,$status=null){
        $notification =  Notification::find($id);
        if(empty($status)){
           return $notification;
        }
         
        $notification->processed = true;
        $notification->save();
    }


    public function getRecentNotification(){
        return Notification::latest()->take(10)->get();
    }


    public function getNotificationSummary(){
         return [
                'totalNotification' => Notification::count(),
                'ProcessedNotification' => Notification::where('processed', 1)->count()
            ];
    }
    

}