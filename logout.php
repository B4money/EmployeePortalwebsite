<?php
    error_reporting(E_ALL ^ E_NOTICE);
    session_start();
    session_unset();
	session_start();
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit;
?>
