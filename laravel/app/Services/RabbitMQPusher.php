<?php
namespace App\Services;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;




class  RabbitMQPusher{


   protected $queue = 'notification';

   public function publish($data){
      $connection = new AMQPStreamConnection('localhost',5672,'guest','guest');
      $channel = $connection->channel();
      $channel->queue_declare($this->queue,false,true,false,false);
      $msg = new AMQPMessage(json_encode($data));
      $channel->basic_publish($msg,'' ,$this->queue);
      $channel->close();
      $connection->close();
   }


}