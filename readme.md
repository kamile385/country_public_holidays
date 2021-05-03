### WEB API application returning country public holidays.
#### Requirements for the Application:
1. Endpoints to implement:
    - countries list
    - grouped by a month holidays list for a given country and year
    - specific day status(workday, free day, holiday)
    - the maximum number of free(free day + holiday) days in a row, which will be by a given country and year
2. Endpoints should return JSON as a response.
3. To get a data(countries, holidays) your application should use a JSON API from https://kayaposoft.com/enrico/. Your application should avoid repeated requests to a https://kayaposoft.com/enrico/. Results from a https://kayaposoft.com/enrico/ should be normalized and saved to a database, so next time your application should query a database.
#### Requirements:
1. README.md with deployment instructions
2. Database - MySQL
3. Version control - GIT(bitbucket, github or gitlab)
4. API documentation - generated with https://symfony.com/doc/current/bundles/NelmioApiDocBundle/index.html
5. Deployment - project must be placed on the internet and publicly available (e.g. free hosting available at heroku.com)
#### Installation:
1. Clone, download project .zip or run this command:
```bash   
git pull https://github.com/kamile385/country_public_holidays.git
```   
2. [Download Symfony](https://symfony.com/download) to install the symfony binary on your computer
#### Usage:
```bash
cd country_public_holiday/
```
```bash
symfony serve
```
Then access the application in your browser at the given URL (https://localhost:8000 by default).

If you don't have the Symfony binary installed, run 
```bash
php -S localhost:8000 -t public/
```
to use the built-in PHP web server or configure a web server like Nginx or Apache to run the application.