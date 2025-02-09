<?php

class Notification {
    public function sendNewMessageNotification($userId, $message) {
        $user = $this->getUserSettings($userId);
        
        if ($user['notification_settings']['email']) {
            $this->sendEmail($user['email'], 'Pesan Baru', $message);
        }
        
        if ($user['notification_settings']['push']) {
            $this->sendPushNotification($user['device_token'], $message);
        }
    }
}
?>