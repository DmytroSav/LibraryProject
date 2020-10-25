# Library-project

## Project desription

It's an SPA with VueJS frontend + bootstrap library for styling + PHP for back-end (used dotenv library for storing variables and
 psr-4 for namespacing).
 For MVC, the following logic was implemented:
  + View  represented by responsive VueJS components with  axios library for requests to back-end,
  + Models for DB calls
  + Controllers to interpret the HTTP requests from front-end and return / store an appropriate info
  
  You can set up this project locally by following the instructions below:
 
## Project setup
```

0.Create the database:
CREATE DATABASE library_app DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

1.switch current directiry to api/ folder and run the back-end server with:
php -S 127.0.0.1:8000 -t public
[make sure that PHP server runs on different port than NPM (8000 etc)]

2. copy .env.example in the root directory (for frontend) and .env.example in api/src (for backend),
rename them to .env

3.insert your api url (the one php -S runs on) to .env in root (e.g. VUE_APP_API_URL = http://127.0.0.1:8000/). 
Make sure you did not forget the slash in the end (!)

4. built front-end with:
npm install

5.run front-end with:
npm run serve

6. Insert database info to .env file in api/src

7. To get your database set up, change current directory to api/src and run:
 php library_db_seeder.php

8. and ... that's it! hope you managed the environment successfully, feel free to test the Library

