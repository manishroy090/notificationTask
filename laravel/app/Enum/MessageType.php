<?php
namespace App\Enum;


enum MessageType : string
{
    case Push = 'push';
    case Email = 'email';
    case Sms = 'sms';
}