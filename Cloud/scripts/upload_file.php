<?php

session_start();

if (!isset($_SESSION["username"])) {
  http_response_code(401);
  exit;
}

$username = $_SESSION["username"];
$dirpath = "./files/$username/";

if (!is_dir($dirpath)) {
  mkdir($dirpath);
}

foreach ($_FILES["file"]["error"] as $key => $error) {
  if ($error == UPLOAD_ERR_OK) {
    $tmp_name = $_FILES["file"]["tmp_name"][$key];
    $name = basename($_FILES["file"]["name"][$key]);
    move_uploaded_file($tmp_name, $dirpath . $name);
  }
}

http_response_code(200);

?>