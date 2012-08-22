<?php
	include_once 'class/master.inc.php';
	session_destroy();
	header("location:index.php");