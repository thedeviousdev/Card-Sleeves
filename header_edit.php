<?php 
include_once("login_session.php");
?>

<!DOCTYPE html>
<html>
  <head>
      <meta charset="UTF-8">
      <meta content="width=device-width,initial-scale=1" name="viewport">
      <title>Sleeved.io - How many sleeves do YOU need?</title>

      <meta content="name" name="author">
      <meta content="description here" name="description">
      <meta content="keywords, here" name="keywords">
      <link href="assets/fav.ico" rel="shortcut icon">

      <link href="https://fonts.googleapis.com/css?family=Hind:400,600|Montserrat:400,600,700" rel="stylesheet">
      <link rel="stylesheet" href="assets/EasyAutocomplete-1.3.5/easy-autocomplete.min.css">
      <link href="assets/fontawesome/all.min.css" rel="stylesheet">
      <link href="css/style.css" rel="stylesheet" type="text/css">


      <!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script> -->
      <script src="js/jquery-3.1.1.min.js"></script>
      <script src="assets/EasyAutocomplete-1.3.5/jquery.easy-autocomplete.min.js"></script>

      <script src="js/script.js"></script>
      
  </head>
  <body>
    
<div class="wrapper edit">
  <header>
    <div class="logo">
      <a href="/"><img src="assets/sleeved_logo.svg" /></a>
    </div>
    <div class="form">
      <form action="" class="form_search_edit" method="get">
        <input type="text" class="game-select" name="game" placeholder="Search..." />
        <button type="submit" /><i class="far fa-search"></i></button>
      </form>
    </div>
    <div class="edit_game">
      <a href="index_edit.php"><i class="far fa-pen"></i></a>
    </div>
    <div class="add_game">
      <span><i class="far fa-plus-square"></i></span>
    </div>
  </header>
  <div class="search">