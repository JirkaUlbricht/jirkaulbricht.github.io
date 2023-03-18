<?php

session_start();

if ($_POST["username"] === "myusername" && $_POST["password"] === "mypassword") {
  $_SESSION["username"] = $_POST["username"];
  http_response_code(200);
} else {
  alert("Wrong username or password. Try again");
  http_response_code(401);
}

?>