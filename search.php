

<html>
<header>
    <h1>Weather Forecast</h1>

    <h2 style="color: gray; font-size: 14pt">Get weather forecast by city</h2>

    <aside style="float: right;"><b>Favorite Cities</b>
<?php
/**
 * Created by PhpStorm.
 * File: index.php
 * User: Michael Blackley
 * Student ID: 800771723
 * Date: 12/12/16
 * Time: 12:54 PM
 *
 * Purpose: This is the back end portion of the projet. It
 * connects to the phpmyadmin database called final thats located
 * in the database.php file. There is a counter located in the code that
 * counts how many times the user has searched a certain location. If that user
 * searches for this location five times, it stores that location in the database 'list'
 * and displays this list on the right hand side of the website under 'Favorite Cities'.
 * After the user has entered their city, state and country, the code splits each of these
 * and puts them into separate array locations. From there a URL is designed based on the
 * variables of city, state, and country and is also linked with an API key to link to the
 * open weather map website. After the URL is successfully designed, the XML is called and
 * is further used to show the user the temperature, humidity, pressure, wind speed, clouds and
 * weather image.
 */


require_once('database.php');
        echo '<br>';
        $queryFavCities2 = 'SELECT * FROM list ORDER BY ID';
        $statement2 = $conn->prepare($queryFavCities2);
        $statement2->execute();
        $FavCities2 = $statement2->fetchAll();
        $statement2->closeCursor();

        foreach($FavCities2 as $list)
        {
            echo $list["city"];
            echo '<br>';
        }
  ?>
    </aside>

    <style>

        aside {
            color: #003399;
        }

        b {
            color: gray;
        }

        h1 {
            color: #003399;
        }

        body {
            background-color: #A9E2F3;
            font-size: 20px;
        }

        div {
            color: #003399;
        }

        h2{
            color: #00628B;
        }

        #search {

        }

        #search input[type="text"] {
            background: url(search-white.png) no-repeat 10px 6px #fcfcfc;
            border: 1px solid #d1d1d1;
            font: bold 12px Arial,Helvetica,Sans-serif;
            color: #bebebe;
            width: 150px;
            padding: 6px 15px 6px 35px;
            -webkit-border-radius: 20px;
            -moz-border-radius: 20px;
            border-radius: 20px;
            text-shadow: 0 2px 3px rgba(0, 0, 0, 0.1);
            -webkit-box-shadow: 0 1px 3px rgba(0, 0, 0, 0.15) inset;
            -moz-box-shadow: 0 1px 3px rgba(0, 0, 0, 0.15) inset;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.15) inset;
            -webkit-transition: all 0.7s ease 0s;
            -moz-transition: all 0.7s ease 0s;
            -o-transition: all 0.7s ease 0s;
            transition: all 0.7s ease 0s;
        }

        #search input[type="text"]:focus {
            width: 200px;
        }
    </style>
</header>

   <body style="backgrond-color: #A9E2F3;">
<form method="post" action="search.php" id="search">
    <input name="search" type="text" size="40" placeholder="City,State,Country" />
</form>



<?php
/**
 * Created by PhpStorm.
 * File: search.php
 * User: Michael Blackley
 * Student ID: 800771723
 * Date: 12/12/16
 * Time: 12:54 PM
 */
require_once('database.php');
$search = $_POST['search'];   //captures what the user has searched
$key = 'c1c86d3230fba4076331062c80a30d38';  //API key
$count = 0;

$separate = split (",", $search);   //split the search by each ,
if(!isset($separate[1]))
{
    $separate[1] = NULL;
}

if(!isset($separate[2]))
{
    $separate[2] = NULL;
}

if(!isset($separate[3]))
{
    $separate[3] = NULL;
}

$city = $separate[0];

$state = $separate[1];

$country = $separate[2];

$country = $separate[2];

$stmt = $conn->prepare("INSERT INTO cities (myFavCities) VALUES (:search)");
$stmt->bindParam(':search', $search);
$stmt->execute();

$queryFavCities = 'SELECT * FROM cities ORDER BY ID';
$statement = $conn->prepare($queryFavCities);
$statement->execute();
$FavCities = $statement->fetchAll();
$statement->closeCursor();


foreach ($FavCities as $fav)
{
    if($search == $fav['myFavCities']){
        $count++;
    }

 }


 if ($count == 5)
 {
     $stmt = $conn->prepare("INSERT INTO list (city) VALUES (:search)");
     $stmt->bindParam(':search', $search);
     $stmt->execute();
 }


if(isset($city) && !isset($state) &&!isset($country))
{
    $url = 'http://api.openweathermap.org/data/2.5/forecast?q=' . $city . '&mode=xml&appid=' . $key;
}

if(isset($city, $state) && !isset($country))
{
    $url = 'http://api.openweathermap.org/data/2.5/forecast?q=' . $city . ','.$state.',us&mode=xml&appid=' . $key;
}

if(isset($city,$country) && $state == "")  //only works in this format city,,country
{
    $url = 'http://api.openweathermap.org/data/2.5/forecast?q=' . $city . ','.$country.'&mode=xml&appid=' . $key;
}


$xml = simplexml_load_file($url) or die ("Cant load XML!");

$forecast = $xml->forecast;
$name = $xml->location;
$town = $name->name;
$countryName = $name->country;

echo '<h2>5 Day Weather Forecasts for ';
echo $town;
echo ", ";
echo $countryName;
echo '</h2>';

foreach($forecast->time as $x){
    echo '<div>';

    $time = $x["to"];    //get the time and date

    $symbolNum = $x->symbol["var"];  //get the symbol number from XML to call image URL
    $imageURL = 'http://openweathermap.org/img/w/'.$symbolNum.'.png';

    echo '<aside style="float: left;">';
    echo '<img width="75px" height="75px" src="'.$imageURL.'">';
    echo '</br>';
    echo $x["to"].'<br>';
    echo '</aside>';
    echo "&nbsp    temperature:" .$x->temperature["value"]. " ". $x->temperature["unit"].'<br>';  //5.68 celsius
    echo "&nbsp    humidity:" .$x->humidity["value"].$x->humidity["unit"].'<br>';     //41 %
    echo "&nbsp    pressure:" .$x->pressure["value"]. $x->pressure["unit"].'<br>';     //1013.83 hPa
    echo "&nbsp    wind speed:" .$x->windSpeed["name"].'<br>';   //gentle breeze
    echo "&nbsp    clouds:" .$x->clouds["value"].'<br>';       //clear sky

    echo '</div>';
    echo '</br>';
    echo '</br>';

}

?>
   </body>

</html>
