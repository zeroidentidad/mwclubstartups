<?php
session_start();
if(isset($_SESSION["login"])==false){
	header("location:index.php");
}
?>