
<?php
/**
 * Created by PhpStorm.
 * File: index.php
 * User: Michael Blackley
 * Student ID: 800771723
 * Date: 12/12/16
 * Time: 12:54 PM
 *
 * Purpose: This file sets up the
 * CSS behind the website and also sets up the form
 * for the index page. The CSS includes changing the
 * background, header1, header2 and favorite cities fonts
 * and colors. The CSS also manipulates the search bar to be
 * more of an oval shape with "City, State, Country' listed
 * in the search bar to guide the client on what to enter.
 */

?>
<html>
<header>
    <h1>Weather Forecast</h1>

    <h2 style="color: gray; font-size: 14pt">Get weather forecast by city</h2>
    
    <aside style="float: right;"><b>Favorite Cities</b></aside>
    <style>
        h1 {
            color: #003399;
        }

        b {
            color: gray;
        }

        body {
            background-color: #A9E2F3;
            font-size: 20px;
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
</body>
</html>
