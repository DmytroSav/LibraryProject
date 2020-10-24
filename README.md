# Library-project

## Project setup
```

1.Create the database:
CREATE DATABASE library_app DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

2. built front-end with:
npm install

3.run front-end with:
npm run serve

4.switch to api/ folder and run back-end server with:
php -S 127.0.0.1:8000 -t public

[make sure it runs on different port than npm (8080 etc)]

5. copy .env.example in root directory (for frontend) and .env.example api/src (for backend),
rename them to .env

6.insert your API_URL to .env in root (e.g. VUE_APP_API_URL = http://127.0.0.1:8000/)

7. Insert database info to .env file in api/src

8. run $php library_db_seeder.php from api/src

9. and that's it! hope you managed the environment successfully, feel free to test the App

