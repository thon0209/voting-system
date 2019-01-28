<h1>Web Based-Voting System</h1>

## Features

Single Page Application

## Admin Panel

Login
Start Election
View Election
Voter, Party List, Positions & Candidate (Create, Read, Update, Delete)
Manage Account (can upload file through .xlsx file format)

## Voter Panel

Login using their student id
Vote (Can only access when the election started)
Result (Can only access when she/he already vote)
Logout

## Language used

Laravel
Vue.js
MySQL

## Requirements

Laravel verion 5.7
Vue.js 2.0
Composer (To install Laravel and Other Dependencies)
NPM (To Compile Vue Components)


## Installation
run "php artisan key:generate" to generate application key
copy .env.example to .env and setup your database
create a database named "db-voting"
run "php artisan migrate" to migrating the tables.
run "npm run dev" to compile Vue Components
finally run "php artisan serve" to start application
