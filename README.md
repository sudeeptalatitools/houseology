# Houseology
# Movie Reviews API Application

This application is designed to search movies via API

* The API can be used to search based following criteria:
    * Release Date
    * Genre
    * Rating

## Demo 

[Demo 1](https://ventia.rapporthosting.com/houseology/api/public/movies)
/movies

[Demo 2](https://ventia.rapporthosting.com/houseology/api/public/movies/genre/action)
/movies/genre/action

[Demo 3](https://ventia.rapporthosting.com/houseology/api/public/movies?rating=5)
/movies?rating=5


## Installation
Please run following command for installation

       php composer.phar update
      
## Configuration
Please configure the database connections in following files

       #.env
       #Line 23
       DATABASE_URL=mysql://USERNAME:PASSWORD@127.0.0.1:3306/DB_NAME

For Unit testing

       #phpunit.xml.dist
       #Line 18
       <env name="DATABASE_URL" value="mysql://USERNAME:PASSWORD@127.0.0.1:3306/DB_NAME" />



## Usage

       /movies/param/value

or

       /movies?param


### Example


You can use following url specific to criteria

       /movies/date_released/27-Feb-2018
       /movies/genre/action
       /movies/rating/5


or using generic url by passing parameters

       /movies?date_released=27-Feb-2018
       /movies?genre=action
       /movies?rating=5


### Testing
To run the unit test, please run the following command from the console.
Make sure you are in project root folder
 
       ./vendor/bin/simple-phpunit
        



The unit testing procedures have been included in the the app.

       #/tests/Controller/MoviesControllerDateReleaseTest.php
       #/tests/Controller/MoviesControllerGenreTest.php
       #/tests/Controller/MoviesControllerRatingTest.php        
       #/tests/Controller/MoviesControllerTest.php



For some database testing please make sure to use the test database

##### Additional configuration for testing VIA curl
The system has been tested with PHPUnit along with internal as well as external libraries

For testing with curl, please change the $testSystemUrl as per requirements

       #/tests/Controller/MoviesControllerTest.php
       #Line 15
       public $testSystemUrl='http://127.0.0.1/houseology/symfony/my-project/public/';






### Database


       --
       --Table structure for table `movies`
       --

       CREATE TABLE `movies` (
       `id` int(11) NOT NULL,
       `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
       `date_released` datetime NOT NULL,
       `genre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
       `rating` int(11) NOT NULL
       ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

       --
       -- Dumping data for table `movies`
       --

       INSERT INTO `movies` (`id`, `name`, `date_released`, `genre`, `rating`) VALUES
       (1, 'Movie A', '2018-02-27 00:00:00', 'Action', 5),\
       (2, 'Movie B', '2018-05-27 00:00:00', 'Action', 4),
       (3, 'Movie C', '2018-12-05 00:00:00', 'Action', 5),
       (4, 'Movie D', '2018-06-15 00:00:00', 'Action', 3),
       (5, 'Movie E', '2018-02-09 00:00:00', 'Action', 5);

       --
       -- Indexes for table `movies`
       --
       ALTER TABLE `movies`
        ADD PRIMARY KEY (`id`);


       --
       -- AUTO_INCREMENT for table `movies`
       --

       ALTER TABLE `movies`
         MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
         COMMIT;

      
