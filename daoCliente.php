<?php

require_once("Cliente.php");
require_once("classConexion.php");

class daoCliente extends Conexion { //Esta clase hereda de Conexión.
	
              
               public $Clientes=array();    //Array de objetos Clientes
               

	
	           public function Listar() //Función para listar los clientes
	           {
				   
				  $this->Clientes=array(); //Hay que vaciar el array de objetos clientes 
				   
				  $consulta="select * from cliente";

                  $param=array(); //Creo un array para pasarle parámetros

                  $this->Consulta($consulta,$param); //Ejecuto la consulta
            			
				  foreach ($this->datos as $fila)  //Recorro el array de la consulta
				  {
					   
					  $cli = new Cliente();  //Creo un nuevo objeto
                                             //Le seteo las variables, y así me ahorro el constructor   
                      $cli->idCliente = $fila["idCliente"]; //Accedo a la propiedad directamente
					  $cli->__SET("nombreCliente",$fila["nombreCliente"]);
					  $cli->__SET("apellidos",$fila["apellidos"]);
					  $cli->__SET("direccion",$fila["direccion"]);
					  $cli->__SET("telefono",$fila["telefono"]);
					  $cli->__SET("nif",$fila["nif"]);
					  $cli->__SET("email",$fila["email"]);
					 
                      $this->Clientes[]=$cli; //Meto el cliente en el array Clientes
                      
					  
				  }
			   }
	  
	           public function ObtCli($idCliente) //Función para la búsqueda de un cliente según su ID
	           {
				   
				  $consulta="select * from cliente where idCliente=:idCliente"; //Construyo la consulta SQL

                  $param=array(":idCliente"=>$idCliente); //Esta consulta sí lleva un parámetro, el ID Cliente

                  $this->Consulta($consulta,$param); //Ejecuto la consulta
				  
				  $cli = new Cliente();  //Construyo un objeto cliente
            	
				  if (count($this->datos) > 0 )         //Si el cliente está en la BBDD según su ID
				  {
				     $fila=$this->datos[0];  //La columna solo revolveria una fila
				
					   
                    $cli = new Cliente();  //Creo un nuevo objeto
                        //Le seteo las variables, y así me ahorro el constructor   
                    $cli->__SET("idCliente",$fila["idCliente"]);
                    $cli->__SET("nombreCliente",$fila["nombreCliente"]);
                    $cli->__SET("apellidos",$fila["apellidos"]);
                    $cli->__SET("direccion",$fila["direccion"]);
                    $cli->__SET("telefono",$fila["telefono"]);
                    $cli->__SET("nif",$fila["nif"]);
                    $cli->__SET("email",$fila["email"]);
					 
				  }  	               
				   
				  return $cli; //Retorno el cliente 
				
			   }
	
	           public function Insertar($cli) //Función que me permite insertar cliente
	           {  //Por un lado hago la consulta y por otro lado le paso los parámetros, que me los coge vía GET del objeto cliente que recibe como parámetro
			      $consulta="insert into cliente values (:idCliente, 
	                            			              :nombreCliente,
				                                          :apellidos,
														  :direccion,
														  :telefono,
														  :nif,
														  :email)";
												

                  $param=array(":idCliente"=>$cli->__GET("idCliente"),
				               ":nombreCliente"=>$cli->__GET("nombreCliente"),
				               ":apellidos"=>$cli->__GET("apellidos"),
							   ":direccion"=>$cli->__GET("direccion"),
							   ":telefono"=>$cli->__GET("telefono"),
							   ":nif"=>$cli->__GET("nif"),
                               ":email"=>$cli->__GET("email")
							   );     								
										

                  $this->ConsultaSimple($consulta,$param); //Ejecuto la consulta
				  
				 		   
			   }
			   
			   
			   public function Actualizar($cli) //Función que me permite actualizar clientes
	           { //Por un lado hago la consulta y por otro lado le paso los parámetros, que me los coge vía GET del objeto cliente que recibe como parámetro
			      $consulta="update cliente set  idCliente=:idCliente,
				                               
                                                        nombreCliente=:nombreCliente,
                                                        apellidos=:apellidos,
                                                        direccion=:direccion,
                                                        telefono=:telefono,
                                                        nif=:nif,
                                                        email=:email
									where idCliente=:idCliente     "; 					  

                  $param=array(":idCliente"=>$cli->__GET("idCliente"),
				               ":nombreCliente"=>$cli->__GET("nombreCliente"),
				               ":apellidos"=>$cli->__GET("apellidos"),
							   ":direccion"=>$cli->__GET("direccion"),
							   ":telefono"=>$cli->__GET("telefono"),
							   ":nif"=>$cli->__GET("nif"),
                               ":email"=>$cli->__GET("email") 
							   );    

                  $this->ConsultaSimple($consulta,$param);
				  
				 		   
			   }
			   
			   public function Eliminar($idCliente) //Función que me permite eliminar un cliente de la BBDD
	           {
			      $consulta="delete from cliente   where idCliente=:idCliente ";
                  
				  $param=array(":idCliente"=>$idCliente);

                  $this->ConsultaSimple($consulta,$param);
				  
				 		   
			   }
	
}









?>




