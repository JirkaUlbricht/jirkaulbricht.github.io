<?php

session_start();

if (!isset($_SESSION["username"])) {
  http_response_code(401);
  exit;
}

$username = $_SESSION["username"];
$filename = $_GET["filename"];
$filepath = "./files/$username/$filename";

if (file_exists($filepath)) {
  header("Content-type: application/octet-stream");
  header("Content-Disposition: attachment; filename=\"$filename\"");
  readfile($filepath);
} else {
  http_response_code(404);
}

?>
