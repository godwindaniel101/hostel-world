
## About Application [Demo](https://hostel-world.herokuapp.com/)
A simple php (Laravel) project to sort event for authenticated users

- Authentication
- Event Search System

**System Requirement**
- The software was designed on docker version 20.10.8
- php => 7.4

## Setup
- Install  [Composer](https://getcomposer.org/download/) 

- Clone application from git respository or unzip project archive

- Open  project directory  `cd  hostel-world  `

- Copy environmental variables. `cp ./src/.env.example ./src/.env`

- Install dependencies    `composer install`

- Setup databse variables in `.env`

- Finish setup by running   `composer install  && php artisan migrate --seed   && php artisan passport:install && php artisan serve -port=8008`


- Application should be available on  port 8008

**Running Application**
- After can be brought up by runing `php artisan serve -port=8008`  

- Application can be brought down by closing termial 

**Testing  Application**
- To run test `php artisan test`

## Docker Setup
- Clone application from git respository or unzip project archive
- Open  project directory  `cd  hostel-world  `
- Copy environmental variables. `cp ./src/.env.example ./src/.env`
- Spin up Docker    `docker-compose up --build -d`
- Open Docker Bash  `docker-compose exec app /bin/bash`
- Run the following command on Docker Bash

  `composer install  && php artisan migrate --seed   && php artisan passport:install`
  
- Application should be available on  port 8008

**Running Application**
- After initial set up above application can easily be brought up by running the command   
`docker-compose up --build -d`
- Application can be brought down by running the command  `docker-compose down `

**Testing  Application**
-After initial set up above, spin up the application by running `docker-compose up --build -d`
- Run application shell by running    `docker-compose exec app /bin/bash`
- Run test by running  `php artisan test`
 **Note**  Test is to be ran on application bash to persist PHP version on test and running instance.

#End Points
Base URL `http://localhost:8008/api`

**Login**  

`POST : {baseUrl}/login`

Handles authentication of users

**Register User**  

`POST : {baseUrl}/register`

Handles creation of new user

**Events**  

`GET : {baseUrl}/events`

 **Note**  Data here are mirror images of intended json file, however the date was adjusted to valid dates.

**Events(JSON)**  

`GET : {baseUrl}/events_json`

 **Note**  Data here are mirror images of intended json file, however the date was adjusted to valid dates.

This endpoint gets events preloaded into the database



**Software Assumptions**
- a `GLOBAL CATCH` class was impemented to catch all errors thus eliminating the need for try and catch across the application
- Only basic required endpoints were built, which are register, login, logout and get event data.

- `log` is primarily storted on the `laravel log` file however, calls made to `events` endpoint are logged on the terminal

- `Sentry` was integerated into the application to account for failing 

- Database was included in the docker file to make the setp process easier.

- The event date was adjusted to allow only valid dates as previous days date can not be used.

- Port 8008, 6033 and 8020 are required to be available for Docker Container to work.

- All response from the Application are also presented on **stdout**, thus visible on the Docker console.

- Caching was not used in this application as the event data was not stated as persistent .


##### Best  Regards!


