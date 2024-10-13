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
