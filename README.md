
## วิธีติดตั้งระบบ Inventory System

<br>
(First you need to install composer, and you need a mysql server that contain a database with name "Inventory"(don`t forget to change the database credentials in `.env` file))
<br><br>
 หากมีphpอยู่แล้ว

 ติดตั้ง Composer จากนั้น ติดตั้ง Node.JS เพื่อใช้ npm 

 เมื่อติดตั้งแล้ว ใช้คำสั่งด้สนล่างโดยเรียงจากบนไปล่าง


 หากไม่มี ทำการดาวโหลด php หรือ โหลดxampp
 จากนั้นทำตามด้านบน

```shell

# Download all required packages
composer install

npm install

#create .env
 cp .env.example .env

 #Generate a new application key

php artisan key:generate

# Migrate database
php artisan migrate


# Run the server
php artisan serve

#แยก Terminal
#Run NPM 
npm run dev


```
<br>
<br><br>
