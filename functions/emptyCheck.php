<?php

function emptyCheck($json_data, $name) {
    return isset($json_data[$name]) && !empty($json_data[$name]) ? $json_data[$name] : null;
}