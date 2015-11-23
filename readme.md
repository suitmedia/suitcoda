suitcoda
========

[![License](https://poser.pugx.org/suitmedia/suitcoda/license.svg)](https://packagist.org/packages/suitmedia/suitcoda) 
[![Total Downloads](https://poser.pugx.org/suitmedia/suitcoda/d/total.svg)](https://packagist.org/packages/suitmedia/suitcoda) 
[![Build Status](https://api.travis-ci.org/suitmedia/suitcoda.svg)](https://travis-ci.org/suitmedia/suitcoda) 
[![codecov.io](http://codecov.io/github/suitmedia/suitcoda/coverage.svg?branch=master)](http://codecov.io/github/suitmedia/suitcoda?branch=master) 
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/suitmedia/suitcoda/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/suitmedia/suitcoda/?branch=master) 
[![Code Climate](https://codeclimate.com/github/suitmedia/suitcoda/badges/gpa.svg)](https://codeclimate.com/github/suitmedia/suitcoda) 

## Installation

1. Clone this repository (**`git clone git@github.com:suitmedia/suitcoda.git`**)
2. Run `composer install` in the root project to install all dependencies including develeopment requirement.
3. Run `php artisan migrate` in the root project to migrate suitcoda database.
4. Run `php artisan db:seed` in the root project to add seeder to database.
5. Create username and password with command `php artisan user:new-superuser [username] [name] [email] [password]`

## How to create project

1. Login with url `/login`
2. Click 'Create New Project'.
3. Input project name and url, then submit.

## How to create inspection

1. Run command `php artisan queue:listen --timeout=0` to run queue in local.
2. Click in the project you want to inspect.
3. Click tab 'Activity', then click button 'New Inspection'.
4. Check scope you want to inspect, then click button 'Inspect'.
5. Check result in database.

## How to run worker

Coming soon


