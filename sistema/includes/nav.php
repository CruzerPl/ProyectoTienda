<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>	
	<nav>
			<ul>
				<li><a href="index.php">Inicio</a></li>
			<?php 
				if($_SESSION['rol'] == 1){
			 ?>
				<li class="principal">

					<a href="#">Usuarios</a>
					<ul>
						<li><a href="registro_usuario.php">Nuevo Usuario</a></li>
						<li><a href="lista_usuarios.php">Lista de Usuarios</a></li>
					</ul>
				</li>
			<?php } ?>
				<li class="principal">
					<a href="#">Clientes</a>
					<ul>
						<li><a href="registro_cliente.php">Nuevo Cliente</a></li>
						<li><a href="lista_clientes.php">Lista de Clientes</a></li>
					</ul>
				</li>
				<?php 
				if($_SESSION['rol'] == 1){
			 ?>
				<li class="principal">
					<a href="#">Proveedores</a>
					<ul>
						<li><a href="registro_proveedor.php">Nuevo Proveedor</a></li>
						<li><a href="lista_proveedores.php">Lista de Proveedores</a></li>
					</ul>
				</li>
				<?php } ?>

				<?php 
				if($_SESSION['rol'] == 1){
				 ?>
				<li class="principal">
					<a href="#">Productos</a>
					<ul>
						<li><a href="registro_producto.php">Nuevo Producto</a></li>
						<li><a href="lista_productos.php">Lista de Productos</a></li>
					</ul>
				</li>
				<?php } ?>
				<li class="principal">
					<a href="#">Ventas</a>
					<ul>
						<li><a href="nueva_venta.php">Nueva Venta</a></li>
						<li><a href="">consultar Ventas</a></li>
					</ul>
				</li>
			</ul>
		</nav>