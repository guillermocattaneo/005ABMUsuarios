<?php 
require "Usuario.php";
$Usuario = new Usuario($_POST['nombre'],$_POST['correo'],$_POST['edad'],$_POST['clave'],$_FILES['foto']);
$accion=$_POST['enviar'];
if($accion=="Alta")
{
	$Usuario->Guardar();

}
if($accion=="Borrar")
{
	Usuario::Borrar($Usuario);
}
if($accion=="Modificar")
{
	Usuario::Modificar($Usuario);
}

header("location:index.php");
 ?>