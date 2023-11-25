<?php 
	
	$host = 'localhost';
	$user = 'root';
	$password = '';
	$db = 'tienda_pc';

	$conn = @mysqli_connect($host,$user,$password,$db);

	if(!$conn){
		echo "Error en la conexión";
	}

?>