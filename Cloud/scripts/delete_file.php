<?php

session_start();

if (!isset($_SESSION["username"])) {
  http_response_code(401);
  exit;
}

$username = $_SESSION["username"];
$filename = $_POST["filename"];
$filepath = "./files/$username/$filename";

if (file_exists($filepath)) {
  unlink($filepath);
  http_response_code(200);
} else {
  http_response_code(404);
}

?>