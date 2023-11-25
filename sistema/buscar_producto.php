<?php 
	session_start();
	include "../conexion.php";	

 ?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<title>Lista de Productos</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">
		<?php 

			$busqueda = strtolower($_REQUEST['busqueda']);
			if(empty($busqueda))
			{
				header("location: lista_productos.php");
				mysqli_close($conn);
			}


		 ?>
		
		<h1>Lista de Productos</h1>
		<a href="registro_Producto.php" class="btn_new">Crear Producto</a>
		
		<form action="buscar_producto.php" method="get" class="form_search">
			<input type="text" name="busqueda" id="busqueda" placeholder="Buscar" value="<?php echo $busqueda; ?>">
			<input type="submit" value="Buscar" class="btn_search">
		</form>

		<table>
			<tr>
                <th>Codigo</th>
				<th>Descripcion</th>
				<th>Precio</th>
				<th>Existencia</th>
				<th>Proveedor</th>
                <th>Fecha</th>
				<th>Acciones</th>
			</tr>
		<?php 
			//Paginador
			
			$sql_registe = mysqli_query($conn,"SELECT COUNT(*) as total_registro FROM producto 
																WHERE ( codproducto LIKE '%$busqueda%' OR 
																		descripcion LIKE '%$busqueda%' OR 
																		precio LIKE '%$busqueda%' OR 
																		existencia LIKE '%$busqueda%'
																		  ) 
																AND estatus = 1  ");

			$result_register = mysqli_fetch_array($sql_registe);
			$total_registro = $result_register['total_registro'];

			$por_pagina = 5;

			if(empty($_GET['pagina']))
			{
				$pagina = 1;
			}else{
				$pagina = $_GET['pagina'];
			}

			$desde = ($pagina-1) * $por_pagina;
			$total_paginas = ceil($total_registro / $por_pagina);

			$query = mysqli_query($conn,"SELECT * FROM producto 
                                            WHERE( codproducto LIKE '%$busqueda%' OR 
													descripcion LIKE '%$busqueda%' OR 
													precio      LIKE  '%$busqueda%' OR 
													existencia LIKE '%$busqueda%'
													)  
                                                    AND estatus = 1
                                                    ORDER BY codproducto ASC LIMIT $desde,$por_pagina");
			mysqli_close($conn);
			$result = mysqli_num_rows($query);
			if($result > 0){

				while ($data = mysqli_fetch_array($query)) {

					$formato = "Y-m-d H:i:s";
                    $fecha = DateTime::createFromFormat($formato, $data["date_add"]);
					
			?>
				<tr>
				    <td><?php echo $data["codproducto"]; ?></td>
                    <td><?php echo $data["descripcion"]; ?></td>
                    <td><?php echo $data["precio"]; ?></td>
					<td><?php echo $data["existencia"]; ?></td>
					<td><?php echo $data["proveedor"]; ?></td>
                    <td><?php echo $fecha->format('d-m-Y');  ?></td>
					<td>
						<a class="link_edit" href="editar_producto.php?id=<?php echo $data["codproducto"]; ?>">Editar</a>



                        <a class="link_delete" href="eliminar_confirmar_producto.php?id=<?php echo $data["codproducto"]; ?>">Eliminar</a>

						
					</td>
				</tr>
			
		<?php 
				}

			}
		 ?>


		</table>
<?php 
	
	if($total_registro != 0)
	{
 ?>
		<div class="paginador">
			<ul>
			<?php 
				if($pagina != 1)
				{
			 ?>
				<li><a href="?pagina=<?php echo 1; ?>&busqueda=<?php echo $busqueda; ?>">|<</a></li>
				<li><a href="?pagina=<?php echo $pagina-1; ?>&busqueda=<?php echo $busqueda; ?>"><<</a></li>
			<?php 
				}
				for ($i=1; $i <= $total_paginas; $i++) { 
					# code...
					if($i == $pagina)
					{
						echo '<li class="pageSelected">'.$i.'</li>';
					}else{
						echo '<li><a href="?pagina='.$i.'&busqueda='.$busqueda.'">'.$i.'</a></li>';
					}
				}

				if($pagina != $total_paginas)
				{
			 ?>
				<li><a href="?pagina=<?php echo $pagina + 1; ?>&busqueda=<?php echo $busqueda; ?>">>></a></li>
				<li><a href="?pagina=<?php echo $total_paginas; ?>&busqueda=<?php echo $busqueda; ?> ">>|</a></li>
			<?php } ?>
			</ul>
		</div>
<?php } ?>


	</section>
	<?php include "includes/footer.php"; ?>
</body>
</html>