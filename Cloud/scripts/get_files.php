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

$files = array_diff(scandir($dirpath), array(".", ".."));

foreach ($files as $filename) {
  $filepath = $dirpath . $filename;
  $filesize = filesize($filepath);
  echo "<div>";
  echo "<span>$filename</span>";
  echo "<span>($filesize bytes)</span>";
  echo "<button onclick=\"deleteFile('$filename')\">Delete</button>";
  echo "<button onclick=\"downloadFile('$filename')\">Download</button>";
  echo "</div>";
}

?>
