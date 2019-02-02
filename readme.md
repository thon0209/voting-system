<h1>Web Based-Voting System</h1>

## Features

Single Page Application

## Admin Panel

<li>Login</li>
<li>Start Election</li>
<li>View Election</li>
<li>Voter, Party List, Positions & Candidate (Create, Read, Update, Delete)</li>
<li>Manage Account (can upload file through .xlsx file format)</li>

## Voter Panel

<li>Login using their student id</li>
<li>Vote (Can only access when the election started)</li>
<li>Result (Can only access when she/he already vote)</li>
<li>Logout</li>

## Language used

<li>Laravel</li>
<li>Vue.js</li>
<li>MySQL</li>

## Requirements

<li>Laravel verion 5.7</li>
<li>Vue.js 2.0</li>
<li>Composer (To install Laravel and Other Dependencies)</li>
<li>NPM (To Compile Vue Components)</li>


## Installation
<li>run "php artisan key:generate" to generate application key</li>
<li>copy .env.example to .env and setup your database</li>
<li>create a database named "db-voting"</li>
<li>run "php artisan migrate" to migrating the tables.</li>
<li>run "npm run dev" to compile Vue Components</li>
<li>finally run "php artisan serve" to start application</li>
