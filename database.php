<?php
/**
 * Created by PhpStorm.
 * File: database.php
 * User: Michael Blackley
 * Student ID: 800771723
 * Date: 12/12/16
 * Time: 12:54 PM
 */


$dbname = 'final';
    $userName = 'root';
    $password = 'Clayton09';
$serverName = 'localhost';

    try {
        $conn = new PDO("mysql:host=$serverName;dbname=$dbname",$userName,$password);
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        include('database_error.php');
        exit();
    }
?>