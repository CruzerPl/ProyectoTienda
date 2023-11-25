<?php 
	session_start();
    if($_SESSION['rol'] != 1)
	{
		header("location: ./");
	}
	include "../conexion.php";

	if(!empty($_POST))
	{  

		$alert='';
		if(empty($_POST['proveedor']) || empty($_POST['producto']) || $_POST['precio'] <= 0)
		{
			$alert='<p class="msg_error">Todos los campos son obligatorios.</p>';
		}else{

            $codproducto = $_REQUEST['id'];
			$proveedor = $_POST['proveedor'];
			$producto  = $_POST['producto'];
			$precio   = $_POST['precio'];
            $usuario_id = $_SESSION['idUser'];

            $query_update = mysqli_query($conn,"UPDATE producto 
                                                       SET descripcion = '$producto' ,
                                                           proveedor = $proveedor,
                                                           precio = $precio 
                                                        WHERE codproducto = $codproducto");

            if($query_update){
                $alert='<p class="msg_save">Producto actualizado correctamente.</p>';
            }else{
                 $alert='<p class="msg_error">Error al actualizar el producto.</p>';
                }
            }
	}   
    
    //Validar Producto
    if(empty($_REQUEST['id'])){
        header("location: lista_productos.php");

    }else{
        $id_producto = $_REQUEST['id'];


        $query_producto = mysqli_query($conn,"SELECT p.codproducto, p.descripcion, p.precio, p.existencia, pr.codproveedor, pr.proveedor 
                                                FROM producto p
                                                INNER JOIN proveedor pr
                                                ON p.proveedor = pr.codproveedor 
                                                WHERE p.codproducto = $id_producto AND p.estatus = 1");

        $result_producto = mysqli_num_rows($query_producto);

        if($result_producto > 0){

            $data_producto = mysqli_fetch_array($query_producto);

        }
    }
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<title>Actualizar Producto</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">
		
		<div class="form_register">
			<h1>Actualizar Producto</h1>
			<hr>
			<div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>

			<form action="" method="post" enctype="multipart/form-data">
                
                <label for="proveedor">Proveedor</label>

                <?php 
                
                $query_proveedor= mysqli_query($conn, "SELECT codproveedor, proveedor FROM proveedor WHERE estatus = 1 ORDER BY proveedor ASC");
                $result_proveedor= mysqli_num_rows($query_proveedor);
                mysqli_close($conn);
                ?>


                <select name="proveedor" id="proveedor" class="notItemOne">

                <option value="<?php echo $data_producto['codproveedor'] ?>" selected ><?php echo $data_producto['proveedor'] ?></option>

                <?php  
                
                if($result_proveedor >0 ){
                    while($proveedor = mysqli_fetch_array($query_proveedor)){
                ?>
                 <option value=" <?php echo $proveedor['codproveedor']; ?>"><?php echo $proveedor['proveedor']; ?></option>
                <?php  
                    }
                }
                ?>

                </select>

				<label for="producto">Producto</label>
				<input type="text" name="producto" id="producto" placeholder="Nombre completo del producto" value="<?php echo $data_producto['descripcion'];?>">
				
                <label for="precio">Precio</label>
				<input type="number" name="precio" id="precio" placeholder="Precio $" value="<?php echo $data_producto['precio'];?>">
				
                <div class="photo">
	                <label for="foto"></label>
               
             <div class="upimg">
                    <input type="file" name="foto" id="foto">
                </div>
                    <div id="form_alert"></div>
                </div>
                <br>
				<input type="submit" value="actualizar Producto" class="actualizar Producto">

			</form>


		</div>


	</section>
	<?php include "includes/footer.php"; ?>
</body>
</html>