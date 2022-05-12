<?php
require 'config.php';
$stmt = $conn->prepare("DELETE FROM cart");
$stmt->execute();

session_start();
session_destroy();

header("Location: home.php");
