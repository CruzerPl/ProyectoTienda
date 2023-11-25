<?php 
	session_start();
	if($_SESSION['rol'] != 1)
	{
		header("location: ./");
	}
	include "../conexion.php";

	if(!empty($_POST))
	{
		if($_POST['idproducto'] == 1){
			header("location: lista_productos.php");
			mysqli_close($conn);
			exit;
		}
		$idproducto = $_POST['idproducto'];

		//$query_delete = mysqli_query($conection,"DELETE FROM usuario WHERE idusuario =$idusuario ");
		$query_delete = mysqli_query($conn,"UPDATE producto SET estatus = 0 WHERE codproducto = $idproducto ");
		mysqli_close($conn);
		if($query_delete){
			header("location: lista_productos.php");
		}else{
			echo "Error al eliminar";
		}

	}




	if(empty($_REQUEST['id']))
	{
		header("location: lista_productos.php");
		mysqli_close($conn);
	}else{

		$idproducto = $_REQUEST['id'];

		$query = mysqli_query($conn,"SELECT * FROM producto
												WHERE codproducto = $idproducto ");
		mysqli_close($conn);
		$result = mysqli_num_rows($query);

		if($result > 0){
			while ($data = mysqli_fetch_array($query)) {
				# code...
                $producto = $data['descripcion'];
			}
		}else{
			header("location: lista_productos.php");
		}


	}


 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<title>Eliminar Producto</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">
		<div class="data_delete">
			<h2>¿Está seguro de eliminar el siguiente registro?</h2>
			<p>Nombre del producto: <span><?php echo $producto; ?></span></p>


			<form method="post" action="">
				<input type="hidden" name="idproducto" value="<?php echo $idproducto; ?>">
				<a href="lista_productos.php" class="btn_cancel">Cancelar</a>
				<input type="submit" value="Eliminar" class="btn_ok">
			</form>
		</div>


	</section>
	<?php include "includes/footer.php"; ?>
</body>
</html>