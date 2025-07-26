import Fastify from 'fastify';
import axios from 'axios';
import consumeRabbitMQ from './redisConsumers.js';
import dotenv from 'dotenv';
dotenv.config();



const fastify = Fastify({
  logger: true
});


fastify.get('/', async function handler (request, reply) {
  await  consumeRabbitMQ();
});


fastify.get('/notification/recent', async()=>{
  const response = await axios.get(`${process.env.Laravel_Api}notification/recent`);
  return response.data;
});

fastify.get('/notification/summary', async()=>{
    const response = await axios.get(`${process.env.Laravel_Api}notification/summary`);
    return response.data;
});

try {
  await fastify.listen({ port: 3000 })
} catch (err) {
  fastify.log.error(err)
  process.exit(1)
}