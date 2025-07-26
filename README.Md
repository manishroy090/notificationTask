# 📨 Notification System with Laravel & Node.js (RabbitMQ)

Note : Please make ensue that rabbitmq server is running on Your pc.

A scalable and extensible notification system built using **Laravel** for API + message publishing and **Fastify (Node.js)** microservice for consuming notifications in real time via **RabbitMQ**.

---

## 🛠️ Features

> ✅ Repository & Service Pattern in Laravel  
> ✅ Strategy Pattern in Node.js for extensibility (Push, Email, SMS, etc.)  
> ✅ RabbitMQ Publisher (Laravel) & Consumer (Node.js)  
> ✅ Rate Limiting with Cache (Redis)  
> ✅ Form Request Validation  
> ✅ Enum for consistent Message Type handling  
> ✅ Logging in both Laravel and Node.js  
> ✅ APIs for recent and summary notifications  

---

## 📦 Technologies Used

- **Laravel 11+**
- **Node.js (Fastify)**
- **RabbitMQ**
- **Redis**
- **Axios**
- **Pino** for Node.js logs
- **Laravel Logging** (default)
- **MySQL/MariaDB**

---

## ⚙️ How to Set Up

### 1️⃣ Clone the Project

```bash
git clone https://github.com/yourusername/notificationsystem.git
cd notificationsystem


cd laravel

# Install PHP dependencies
composer install

# Create environment config
cp .env.example .env

# Set database credentials in .env
# DB_DATABASE=your_db
# DB_USERNAME=root
# DB_PASSWORD=

# Generate application key
php artisan key:generate

# Run migrations
php artisan migrate

# (Optional) Start Laravel dev server
php artisan serve


cd ../nodejs

# Install Node dependencies
npm install

# Create environment config
cp .env.example .env

# Start Fastify server and RabbitMQ consumer
npm start

##Laravel Environment Variables
QUEUE_CONNECTION=sync
RABBITMQ_HOST=localhost
RABBITMQ_PORT=5672
RABBITMQ_USER=guest
RABBITMQ_PASSWORD=guest
RABBITMQ_QUEUE=notification

##✅ Node.js Environment Variables
RABBITMQ_URL=amqp://localhost
NOTIFICATION_QUEUE=notification
LARAVEL_API_BASE=http://localhost:8000
PORT=3000
