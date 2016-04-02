<?php

if (!array_key_exists("function", $_POST)) die();
$func = $_POST["function"];
$response = "";
switch ($func) {
    // do ajax stuff
}
echo json_encode($response);