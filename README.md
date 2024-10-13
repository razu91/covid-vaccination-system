## Overview 

The COVID-19 Vaccination Registration System is a web-based platform developed in Laravel, designed to streamline the process of vaccine registration and appointment scheduling. Citizens can easily register using their National ID (NID), receive scheduling details via email, and be notified with a reminder the day before their vaccination. The system operates on a first-come, first-served basis, ensuring vaccinations are only scheduled during weekdays (Sunday to Thursday).


### Prerequisite

<ul>
    <li>PHP 8.2 || 8.3</li>
    <li>MySQL 8.0</li>
    <li> Apache || Nginx </li>
    <li> Composer </li>
</ul>


### Installation Steps

1. **Clone the Repository**

   Open your terminal and run the following command to clone the repository:

   ```
   git clone https://github.com/razu91/covid-vaccination-system.git

   ```
   
2. **Navigate to the Project Directory**
    
   ```
   cd covid-vaccination-system
   ```

3. **Install Composer Dependencies**

   ```
   composer install
   ```

4. **Set Up Environment File**
   
   ```
   cp .env.example .env // create|rename .env file

   ```

5. **Generate Application Key**
   
   ```
   php artisan key:generate
   ```

6. **Configure Database Connection (.env)**
   
   ```
    DB_CONNECTION=mysql/mariadb
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database_name
    DB_USERNAME=your_database_username
    DB_PASSWORD=your_database_password

   ```

7. **Configure Email Credentials (.env)**
    
    ```
    MAIL_MAILER=smtp
    MAIL_HOST=sandbox.smtp.mailtrap.io
    MAIL_PORT=2525
    MAIL_USERNAME=mail_provider_username
    MAIL_PASSWORD=mail_provider_password
    MAIL_FROM_ADDRESS=mail_sender_address
    ```
8. **Run Migration & seed for database**
    
    ```
    php artisan migrate --seed
    ```

9. **Start the Development Server**
   
   ```
   php artisan serve
   ```


### Email Notification System

A vaccine schedule date reminder email will automatically be sent to the user at 9 PM the day before the vaccination date.

We use Laravel's **Notification System** along with a **queue worker** for sending emails. A Laravel command, ```send:vaccine-schedule-mail```, is scheduled to run every day at 9 PM.

To send emails properly, we should run the following two commands:

**Local Development Servicer**
```
 php artisan schedule:run
 php artisan queue:work
 ```
 
 **CPanel (Setup Cron Job)**
 
 ```
 * * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1

 * * * * * cd /path-to-your-project && php artisan queue:work >> /dev/null 2>&1
 ```
 
 ### SMS Notifications

Here use Laravel Notification system . We can easily implement Sms notification without modify current code. 

Step 1 : Go to Notification class (**SendVaccineScheduleNotification**)

Step 2 : Integrate any sms provider like (twillo/slack/nexmo)

```
composer require twilio/sdk
```

Step 3 : Add Channels for sms
```
    public function via(object $notifiable): array
    {
        return ['mail','sms']; // Add 'sms' here
    }
```

Step 4 : Create SMS function toSms for send notification via sms
```
use Twilio\Rest\Client;

public function toSms(object $notifiable)
{
    $name = $this->vaccine_user->name;
    $date = date_format(date_create($this->vaccine_user->scheduled_date), 'd MD, Y');

    $message = "Hello $name, your COVID vaccine is scheduled for $date.";

    $twilio = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));
    $twilio->messages->create(
        $notifiable->phone, // Your user's phone number
        [
            'from' => env('TWILIO_FROM'),
            'body' => $message,
        ]
    );
}
```

**Note: For sending mail or SMS, using a service class to handle the logic is considered good practice.**


## Project Performance Optimization

Optimizing your project for performance is crucial for ensuring faster load times and an overall better user experience. Here are some recommended steps for improving the performance of a Laravel application:

### 1. **Use Cache Efficiently**
   - Enable caching for routes, views, and configurations.
     ```bash
     php artisan route:cache
     php artisan config:cache
     php artisan view:cache
     ```
   - Use **Redis** or **Memcached** for caching, which is much faster than file-based caching.

### 2. **Optimize Database Queries**
   - Use **Eager Loading** to minimize the number of database queries.
     ```php
     // Instead of this:
     $users = User::all();
     foreach ($users as $user) {
         echo $user->profile->name;
     }

     // Use eager loading:
     $users = User::with('profile')->get();
     ```
   - Avoid **N+1 Query Problem** by loading relationships in bulk.
   - Use **Indexes** on frequently searched columns.
   - Use **Chunking** when working with large datasets.
     ```php
     User::chunk(100, function ($users) {
         foreach ($users as $user) {
             // Process each user...
         }
     });
     ```

### 3. **Use Queues for Time-Consuming Tasks**
   - Offload tasks such as sending emails, processing images, or other time-consuming jobs to the queue.
   - Ensure that your queue worker is running:
     ```bash
     php artisan queue:work
     ```

### 4. **Optimize Assets**
   - Minify and combine CSS and JS files.
   - Use Laravel Mix or Webpack to compile and minify assets.
     ```bash
     npm run production
     ```
   - Implement **lazy loading** for images and other assets that aren’t needed immediately.

### 5. **Enable HTTPS**
   - Enable HTTPS to use HTTP/2, which is faster than HTTP/1.1 due to its multiplexing feature.

### 6. **Pagination**
   - Use **chunked pagination** or **cursor pagination** for better performance with large datasets:
     ```php
     $users = User::cursorPaginate(10);
     ```

### 7. **Use the Latest PHP Version**
   - Always use the latest stable PHP version (Laravel 11 supports PHP 8.2 and 8.3), as newer versions include performance improvements.

### 8. **Optimize Session and Cache Storage**
   - Store sessions and cache data in memory stores like Redis or Memcached instead of the default file system storage for faster access.

### 9. **Optimize Composer Autoload**
   - Use the optimized Composer autoloader to reduce overhead when loading classes:
     ```bash
     composer install --optimize-autoloader --no-dev
     ```

### 10. **Monitor and Optimize SQL Queries**
   - Use database profiling tools like **Laravel Debugbar** or **Telescope** during development to monitor and optimize your SQL queries.

### 11. **Use Content Delivery Network (CDN)**
   - For faster asset delivery, use a CDN to serve static files such as images, CSS, and JavaScript.

### 12. **Database Query Caching**
   - Use caching for frequently used database queries to reduce database load:
     ```php
     $users = Cache::remember('users', 60, function () {
         return User::all();
     });
     ```
### 13. **Switch to Nginx with PHP-FPM**
   - **Nginx** is a high-performance web server with lower memory usage compared to Apache. It excels at serving static files and handling many concurrent connections.
   - **PHP-FPM** (FastCGI Process Manager) is a faster alternative to PHP’s default CGI, allowing you to handle heavy loads and process PHP scripts more efficiently.

### Benefits of Nginx with PHP-FPM:
   - **Better resource management**: Nginx uses fewer system resources compared to Apache, especially when serving static files.
   - **Increased performance**: PHP-FPM provides faster script execution and better handling of high traffic loads.
   - **Concurrent requests**: Nginx handles more concurrent requests than Apache, leading to improved speed under load.

**And many more way to improve performance**
