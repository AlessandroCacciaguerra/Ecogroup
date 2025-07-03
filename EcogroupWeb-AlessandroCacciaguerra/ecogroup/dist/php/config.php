<?php

$database_data = array(
    "server" => "0.0.0.0",
    "user" => "root",
    "password" => "cGgF6I9WczWDhYM2EdeeNv96rYlL",
    "dbname" => "eco_group",
    "port" => "3306"
);


define("CONF_DATABASE", $database_data);
define("LOGIN_HASH", getenv("LOGIN_HASH"));
