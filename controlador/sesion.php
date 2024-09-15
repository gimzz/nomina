<?php
session_start();
if(time() - $_SESSION['timestamp'] > 1800) { //subtract new timestamp from the old one
  echo"<script>alert('15 Minutes over!');</script>";
  unset($_SESSION['user'], $_SESSION['clave'], $_SESSION['timestamp']);
  $_SESSION['logged_in'] = false;
  header("Location:../index.php"); //redirect to index.php
  exit;
} else {
  $_SESSION['timestamp'] = time(); //set new timestamp
}
if (!isset($_SESSION['user'])) {
    echo "Ups, te has equivocado";
    header('Location: ../index.html');
    die();
  }
?>