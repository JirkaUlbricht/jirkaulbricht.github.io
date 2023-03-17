<?php

session_start();

// Replace this with your own authentication mechanism
if ($_POST["username"] === "myusername" && $_POST["password"] === "mypassword") {
  $_SESSION["username"] = $_POST["username"];
  http_response_code(200);
} else {
  http_response_code(401);
}

?>