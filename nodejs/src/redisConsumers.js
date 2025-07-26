import amqp from 'amqplib';
import axios from 'axios';
import EmailStrategy from './strategies/EmailStrategy.js';
import PushStrategy from './strategies/PushStrategy.js';
import SMSStrategy from './strategies/SMSStrategy.js';


const strategyMap = {
  email:EmailStrategy,
  sms:SMSStrategy,
  push:PushStrategy

}


const queue = 'notification'
export default async function consumeRabbitMQ() {
  const connection = await amqp.connect(process.env.RabbitMQ_URL);
  const channel = await connection.createChannel();
  await channel.assertQueue(queue,{durable:true});
  channel.consume(queue , async(msg)=>{
    if(msg !==null){
      const data = JSON.parse(msg.content.toString());
      const strategyClass = strategyMap[data.type] || PushStrategy
      const strategy = new strategyClass();
      await strategy.send(data);
      try {
         await axios.put(`${process.env.Laravel_Api}notification/${data.id}`);
      } catch (error) {
        channel.nack(msg, false, true);
      }

      channel.ack(msg);
    }
  },{ noAck: false }); 
}