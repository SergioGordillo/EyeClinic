<?php

require_once("Prueba.php");
require_once("classConexion.php");

class daoPrueba extends Conexion { //Esta clase hereda de Conexión.
	
              
               public $Pruebas=array();    //Array de objetos Pruebas
               

			   public function Listar($orden) { //Función para listar las pruebas

				$this->Pruebas=array(); //Hay que vaciar el array de objetos Pruebas
			   
				if(!empty($orden)){ //Si el parámetro $orden no está vacío
   
				   $consulta="select * from prueba order by " . $orden; //Creo la consulta. En este caso no se puede hacer con consultas preparadas
				   $param=array(); //Creo un array para pasarle parámetros
				
				   $this->Consulta($consulta,$param); //Ejecuto la consulta
				 
						 
				   foreach ($this->datos as $fila)  //Recorro el array de la consulta
				   {
						
					   $pru = new Prueba();  //Creo un nuevo objeto
											  //Le seteo las variables, y así me ahorro el constructor   
					   $pru->__SET("idPrueba",$fila["idPrueba"]);
					   $pru->__SET("nombrePrueba",$fila["nombrePrueba"]);
					   $pru->__SET("aparatosNecesarios",$fila["aparatosNecesarios"]);
					   $pru->__SET("descripcion",$fila["descripcion"]);
					  
					   $this->Pruebas[]=$pru; //Meto la prueba en el array de Pruebas
					}
   
				}else{
   
				   $consulta="select * from prueba";

				   $param=array(); //Creo un array para pasarle parámetros
				
				   $this->Consulta($consulta,$param); //Ejecuto la consulta
				 
						 
				   foreach ($this->datos as $fila)  //Recorro el array de la consulta
				   {
						
					   $pru = new Prueba();  //Creo un nuevo objeto
											  //Le seteo las variables, y así me ahorro el constructor   
					   $pru->__SET("idPrueba",$fila["idPrueba"]);
					   $pru->__SET("nombrePrueba",$fila["nombrePrueba"]);
					   $pru->__SET("aparatosNecesarios",$fila["aparatosNecesarios"]);
					   $pru->__SET("descripcion",$fila["descripcion"]);
					  
					   $this->Pruebas[]=$pru; //Meto la prueba en el array de Pruebas
   
				}
						 
					
			}

		}
			   
			  
	  
	           public function ObtPru($idPrueba) //Función para la búsqueda de una prueba según su ID
	           {
				   
				  $consulta="select * from prueba where idPrueba=:idPrueba"; //Construyo la consulta SQL

                  $param=array(":idPrueba"=>$idPrueba); //Esta consulta sí lleva un parámetro, el ID Prueba

                  $this->Consulta($consulta,$param); //Ejecuto la consulta
				  
				  $pru = new Prueba();  //Construyo un objeto prueba
            	
				  if (count($this->datos) > 0 )         //Si la prueba está en la BBDD según su ID
				  {
				     $fila=$this->datos[0];  //La columna solo revolveria una fila
				
					   
                    $pru = new Prueba();  //Creo un nuevo objeto
                        //Le seteo las variables, y así me ahorro el constructor   
                    $pru->__SET("idPrueba",$fila["idPrueba"]);
                    $pru->__SET("nombrePrueba",$fila["nombrePrueba"]);
                    $pru->__SET("aparatosNecesarios",$fila["aparatosNecesarios"]);
                    $pru->__SET("descripcion",$fila["descripcion"]);
					 
				  }  	               
				   
				  return $pru; //Retorno el objeto prueba
				
			   }
	
	           public function Insertar($pru) //Función que me permite insertar prueba
	           {  //Por un lado hago la consulta y por otro lado le paso los parámetros, que me los coge vía GET del objeto prueba que recibe como parámetro
			      $consulta="insert into prueba values (:idPrueba, 
	                            			              :nombrePrueba,
				                                          :aparatosNecesarios,
														  :descripcion)";
												

                  $param=array(":idPrueba"=>$pru->__GET("idPrueba"),
				               ":nombrePrueba"=>$pru->__GET("nombrePrueba"),
				               ":aparatosNecesarios"=>$pru->__GET("aparatosNecesarios"),
							   ":descripcion"=>$pru->__GET("descripcion"),
							   );     								
										

                  $this->ConsultaSimple($consulta,$param); //Ejecuto la consulta
				  
				 		   
			   }
			   
			   
			   public function Actualizar($pru) //Función que me permite actualizar pruebas
	           { //Por un lado hago la consulta y por otro lado le paso los parámetros, que me los coge vía GET del objeto prueba que recibe como parámetro
			      $consulta="update prueba set  idPrueba=:idPrueba,
				                               
                                                        nombrePrueba=:nombrePrueba,
                                                        aparatosNecesarios=:aparatosNecesarios,
                                                        descripcion=:descripcion
									where idPrueba=:idPrueba     "; 	
									

                 $param=array(":idPrueba"=>$pru->__GET("idPrueba"),
                                    ":nombrePrueba"=>$pru->__GET("nombrePrueba"),
                                    ":aparatosNecesarios"=>$pru->__GET("aparatosNecesarios"),
                                    ":descripcion"=>$pru->__GET("descripcion"),
									);  

                  $this->ConsultaSimple($consulta,$param);
				  
				 		   
			   }
			   
			   public function Eliminar($idPrueba) //Función que me permite eliminar una prueba de la BBDD
	           {
			      $consulta="delete from prueba where idPrueba=:idPrueba ";
                  
				  $param=array(":idPrueba"=>$idPrueba);

				  $this->ConsultaSimple($consulta,$param);
				  
				  //No se puede borrar porque el campo idPrueba es clave foránea de AltaPrueba
				  
				 		   
			   }

			   public function Filtrar($nombre){

				$consulta="select * from prueba WHERE nombrePrueba LIKE '%". $nombre ."%'";

				$param=array(); //Creo un array para pasarle parámetros
			 
				$this->Consulta($consulta,$param); //Ejecuto la consulta
			  
					  
				foreach ($this->datos as $fila)  //Recorro el array de la consulta
				{
					 
					$pru = new Prueba();  //Creo un nuevo objeto
										   //Le seteo las variables, y así me ahorro el constructor   
					$pru->__SET("idPrueba",$fila["idPrueba"]);
					$pru->__SET("nombrePrueba",$fila["nombrePrueba"]);
					$pru->__SET("aparatosNecesarios",$fila["aparatosNecesarios"]);
					$pru->__SET("descripcion",$fila["descripcion"]);
				   
					$this->Pruebas[]=$pru; //Meto la prueba en el array de Pruebas

			   }
			}

			public function FiltrarObjeto($prueba){

				$consulta="select * from prueba WHERE 1 ";

				if(!empty($prueba->__GET("nombrePrueba") ) ) {
					$consulta.= "and lower(nombrePrueba) LIKE '%". strtolower($prueba->nombrePrueba) ."%' ";
				}

				if(!empty($prueba->__GET("aparatosNecesarios") ) ){
					$consulta.= "and lower(aparatosNecesarios) LIKE '%". strtolower($prueba->aparatosNecesarios) ."%' ";
				}

				$param = array();

				$this->Consulta($consulta,$param); //Ejecuto la consulta
			  
					  
				foreach ($this->datos as $fila)  //Recorro el array de la consulta
				{
					 
					$pru = new Prueba();  //Creo un nuevo objeto
										   //Le seteo las variables, y así me ahorro el constructor   
					$pru->__SET("idPrueba",$fila["idPrueba"]);
					$pru->__SET("nombrePrueba",$fila["nombrePrueba"]);
					$pru->__SET("aparatosNecesarios",$fila["aparatosNecesarios"]);
					$pru->__SET("descripcion",$fila["descripcion"]);
				   
					$this->Pruebas[]=$pru; //Meto la prueba en el array de Pruebas

			   }
			}
	
}

?>