<?php 
	session_start();
	if($_SESSION['rol'] != 1)
	{
		header("location: ./");
	}
	include "../conexion.php";

	if(!empty($_POST))
	{
		if($_POST['idcliente'] == 1){
			header("location: lista_clientes.php");
			mysqli_close($conection);
			exit;
		}
		$idcliente = $_POST['idcliente'];

		//$query_delete = mysqli_query($conection,"DELETE FROM usuario WHERE idusuario =$idusuario ");
		$query_delete = mysqli_query($conn,"UPDATE cliente SET estatus = 0 WHERE idcliente = $idcliente ");
		mysqli_close($conn);
		if($query_delete){
			header("location: lista_clientes.php");
		}else{
			echo "Error al eliminar";
		}

	}




	if(empty($_REQUEST['id']))
	{
		header("location: lista_clientes.php");
		mysqli_close($conn);
	}else{

		$idcliente = $_REQUEST['id'];

		$query = mysqli_query($conn,"SELECT * FROM cliente
												WHERE idcliente = $idcliente ");
		mysqli_close($conn);
		$result = mysqli_num_rows($query);

		if($result > 0){
			while ($data = mysqli_fetch_array($query)) {
				# code...
                $nit = $data['nit'];
				$nombre = $data['nombre'];
			}
		}else{
			header("location: lista_clientes.php");
		}


	}


 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<title>Eliminar Cliente</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">
		<div class="data_delete">
			<h2>¿Está seguro de eliminar el siguiente registro?</h2>
			<p>Nombre del cliente: <span><?php echo $nombre; ?></span></p>
			<p>RFC: <span><?php echo $nit; ?></span></p>

			<form method="post" action="">
				<input type="hidden" name="idcliente" value="<?php echo $idcliente; ?>">
				<a href="lista_clientes.php" class="btn_cancel">Cancelar</a>
				<input type="submit" value="Eliminar" class="btn_ok">
			</form>
		</div>


	</section>
	<?php include "includes/footer.php"; ?>
</body>
</html>