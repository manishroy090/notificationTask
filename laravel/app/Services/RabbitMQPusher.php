<?php
namespace App\Services;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;




class  RabbitMQPusher{


   protected $queue ;

   public function __construct()
   {
      $this->queue = env('RABBITMQ_QUEUE');
      
      
   }

   public function publish($data){
      $connection = new AMQPStreamConnection(env('RABBITMQ_HOST'),env('RABBITMQ_PORT'),env('RABBITMQ_USER'),env('RABBITMQ_PASSWORD'));
      $channel = $connection->channel();
      $channel->queue_declare($this->queue,false,true,false,false);
      $msg = new AMQPMessage(json_encode($data));
      $channel->basic_publish($msg,'' ,$this->queue);
      $channel->close();
      $connection->close();
   }


}