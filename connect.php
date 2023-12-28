<?php

    $con = new mysqli("localhost", "root", "", "auth_db");
    if($con -> connect_error) {
        die("Connection Failed".$con->connect_error);
    }

?>