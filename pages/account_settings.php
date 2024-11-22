<?php
session_start();

if (isset($_SESSION['id'])) {
    header('Location: index.php');
    exit();
}
// Name: Kyle Stranick
// Course: ITN 264
// Section: 201
// Title: Assignment 10: Display Database Data
// Due: 11/8/2024

$title = 'Events';
$stylesheets = ['../css/eventspage.css'];
include '../partials/header.php';
include '../partials/navBar.php';
?>
