<?php 

class Usuario
{	
	public $nombre;
	public $correo;
	public $edad;
	public $clave;
	public $foto;


	function __construct($nombre,$correo,$edad,$clave,$foto)
	{
		$this->nombre=$nombre;
		$this->correo=$correo;//CONSTRUCTOR
		$this->edad=$edad;
		$this->clave=$clave;
		$this->foto=$foto;
	}

	public function nombreFoto($foto)//Valida si ya hay fotos subidas con el mismo nombre, si las hay las sube con otro nombre
	{
		
		$nombreOriginal= $foto['name'];
		$exploded_nombre= explode(".", $nombreOriginal);
		$extension= array_pop($exploded_nombre);
		
		$array= glob("fotos/".$exploded_nombre[0]."*.".$extension);//GLOB: Devuelve un array con la cant de veces que se repite un archivo en un directorio
		$cant= count($array); //Devuelve el entero del anterior GLOB

		if($cant > 0)
		{
			$nombreFinal=$exploded_nombre[0]."(Copia$cant).".$extension;

		}else
		{
			$nombreFinal=$nombreOriginal;
		}
		move_uploaded_file($foto['tmp_name'], "fotos/".$nombreFinal);
		return $nombreFinal;
	}

	public function Guardar()
	{
		if($this->nombre!=""||$this->correo!=""||$this->edad!="")
		{
			$archivo=fopen("usuario.txt", "a");	
			$nombrefoto=Usuario::nombreFoto($this->foto);
			$datos=$this->nombre."=>".$this->correo."=>".$this->edad."=>".$this->clave."=>".$nombrefoto."\n";			
			fwrite($archivo, $datos);		
			fclose($archivo);
			return true;
		}else
		return false;
	}

	public static function CrearTablaUsuarios()
	{
		if(file_exists("usuario.txt"))
		{
			$cadena="<table border=1><th> Nombre </th><th> correo </th><th> edad </th><th> clave </th><th> Foto </th>";
			$archivo=fopen("usuario.txt", "r");

		
				while(!feof($archivo))
				{
					$getFile=fgets($archivo);
					$alum=explode("=>", $getFile);
					$alum[0]=trim($alum[0]);
					if($alum[0]!="")
					{
				  		$cadena=$cadena."<tr><td>".$alum[0]."</td><td>".$alum[1]."</td><td>".$alum[2]."</td><td>".$alum[3]."</td><td><img src=fotos/".$alum[4]." height=75px width=75px</td></tr>";
					}

				}
				$cadena =$cadena." </table>";
				fclose($archivo);
				$archivo2=fopen("archivos/tablaUsuarios.php", "w");
				fwrite($archivo2, $cadena);
		}else
			{
				$cadena= "no hay Usuarios";

				$archivo=fopen("archivos/tablaUsuarios.php", "w");
				fwrite($archivo, $cadena);
			}
	}

	public static function traerTodos()//Devuelve un array con elementos de Usuario
	{
		$ListaDeUsuarios=  array();
		$archivo=fopen("usuario.txt","r");		
		while(!feof($archivo))
			{
				$renglon=fgets($archivo);
				$alumn=explode("=>", $renglon);
				$alumn[0]=trim($alumn[0]);
				if($alumn[0]!="")
					$ListaDeUsuarios[]=$alumn;
			}
		fclose($archivo);
		return $ListaDeUsuarios;
	}

	public static function Modificar($Usuario)
	{
		$esta=false;
		$counter=0;
	
		$arrayUsuarios= Usuario::traerTodos();
		foreach ($arrayUsuarios as $aluma)

			 { 
			 	$counter=$counter+1;
			 	$aluma[1]=trim($aluma[1]);
				if($aluma[1]!="")
				if($aluma[1]==$Usuario->correo) 
				{
				$esta=true;
					$aluma[0]=$Usuario->nombre;
					$aluma[1]=$Usuario->correo;
					$aluma[2]=$Usuario->edad;
					$aluma[3]=$Usuario->clave;
					move_uploaded_file($_FILES['foto']['tmp_name'], "fotos/".$Usuario->foto['name']);
					$aluma[4]=$Usuario->foto['name'];
					$arrayUsuarios[$counter-1]=$aluma;												
				}	
			}

	if($esta==true)
				{			 
				$archivo=fopen("usuario.txt", "w");	
			foreach ($arrayUsuarios as $alumnito)
					{
						if($alumnito[0]!="")
						{	
						$renglon=$alumnito[0]."=>".$alumnito[1]."=>".$alumnito[2]."=>".$alumnito[3]."=>".$alumnito[4]."\n";
						fwrite($archivo, $renglon);
						}								
					}
				fclose($archivo);
		      	}
		return $esta;
	}

	public static function Borrar($Usuario)
	{
		$esta=false;
		$counter=0;	
		$arrayUsuarios= Usuario::traerTodos();
			foreach ($arrayUsuarios as $aluma)
			 { $counter=$counter+1;
			 	$aluma[1]=trim($aluma[1]);
				if($aluma[1]!="")
				if($aluma[1]==$Usuario->correo) 
				{				
					$esta = true;		
					$aluma[3]=trim($aluma[3]);								
					unlink("fotos/".$aluma[3]);	
					unset($arrayUsuarios[$counter-1]);							
				}	
			}//1er for
	if($esta==true)
				{			 
						$archivo=fopen("usuario.txt", "w");	
			foreach ($arrayUsuarios as $alumnito)
					{
						if($alumnito[0]!="")
						{				
						$renglon=$alumnito[0]."=>".$alumnito[1]."=>".$alumnito[2]."=>".$alumnito[3]."=>".$alumnito[4]."\n";
						fwrite($archivo, $renglon);
						}								
					}
				fclose($archivo);
			}
		return $esta;

	}


}

 ?>