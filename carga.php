<?php

include"Usuario.php";


Usuario::CrearTablaUsuarios();

?><!DOCTYPE html>
<html>
<head>		<title>PP Cattaneo</title>		</head>

<body>
<table border="1" style="margin:0 auto">
<tbody>
<form method="post" action="gestion.php"enctype="multipart/form-data">
	<tr>	<td>Nombre</td><td><input type="text" name="nombre"></td>	</tr>
	<tr>	<td>Correo </td><td><input type="text" name="correo"></td>	</tr>
	<tr>	<td>Edad</td><td><input type="text" name="edad"></td>	</tr>
	<tr>	<td>Clave</td><td><input type="password" name="clave"></td>	</tr>
	<tr>	<td>Imagen</td> <td><input type="file" name="foto" title="foto"></td>	</tr>
	

	<tr>
		<td><input type="submit" value="Alta" name="enviar"></td>
		<td><input type="submit" value="Borrar" name="enviar">
		<input type="submit" value="Modificar" name="enviar">
			<form method="post" action="index.php">
		<input type="submit" value="Volver" name="enviar">
	</form></td>

	</tr>
</form>
</tbody>
</table>

<?php 
	//para validar si funciona, si no lo borre, fue un error
      include("archivos/tablaUsuarios.php");

     ?>

</body>
</html>