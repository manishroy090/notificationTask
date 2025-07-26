<?php
namespace App\Repositories\Interfaces;


 interface NotificationInterface{

    public function StoreNotification($data);

    public function updateNotificationStatus($id);

    public function getRecentNotification();

    public function getNotificationSummary();

}
