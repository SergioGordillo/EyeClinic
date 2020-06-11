<?php

require_once("Prueba.php");
require_once("classConexion.php");

class daoPruebaCliente extends Conexion { //Esta clase hereda de Conexión.
	
              
               public $PruebaClientes=array();    //Array de objetos PruebaClientes
               

	           public function Listar() //Función para listar todos los datos de la tabla pruebacliente
	           {
				   
				  $this->PruebaClientes=array(); //Hay que vaciar el array de objetos Pruebas
				   
				  $consulta="select * from pruebacliente";

                  $param=array(); //Creo un array para pasarle parámetros

                  $this->Consulta($consulta,$param); //Ejecuto la consulta
            	
						
				  foreach ($this->datos as $fila)  //Recorro el array de la consulta
				  {
					   
					  $prucli = new PruebaCliente();  //Creo un nuevo objeto
                                             //Le seteo las variables, y así me ahorro el constructor   
					  $prucli->__SET("prueba_idprueba",$fila["prueba_idprueba"]);
					  $prucli->__SET("cliente_idCliente",$fila["cliente_idCliente"]);
					  $prucli->__SET("diagnostico",$fila["diagnostico"]);
					  $prucli->__SET("fechaPrueba",$fila["fechaPrueba"]);
					 
					  $this->PruebaClientes[]=$prucli; //Meto la prueba en el array de PruebasClientes
					  
				  }
			   }
	  
	           public function ObtPruCli($prueba_idprueba, $cliente_idCliente, $fechaPrueba) //Función para la búsqueda de una pruebaCliente según las tres claves primarias: id de la prueba, id del cliente y fecha de la prueba
	           {
				   
                  $consulta="select prueba_idprueba, cliente_idCliente, fechaprueba 
                  from pruebacliente 
                  where prueba_idprueba=:prueba_idprueba 
                  AND cliente_idCliente=:cliente_idCliente
                  AND fechaprueba:=fechaprueba"; //Construyo la consulta SQL

                  $param=array(":prueba_idprueba"=>$prueba_idprueba,
                               "cliente_idCliente"=>$cliente_idCliente,
                               "fechaprueba"=>$fechaprueba); //Esta consulta sí lleva varios parámetros, las distintas claves primarias

                  $this->Consulta($consulta,$param); //Ejecuto la consulta
				  
				 
            	
				  if (count($this->datos) > 0 )         //Si según las claves primarias el pruebacliente está en la BBDD
				  {
				     $fila=$this->datos[0];  //La columna solo revolveria una fila
				
                    $prucli = new PruebaCliente();  //Construyo un objeto pruebacliente
                        //Le seteo las variables, y así me ahorro el constructor   

                    $prucli->__SET("prueba_idprueba",$fila["prueba_idprueba"]);
					$prucli->__SET("cliente_idCliente",$fila["cliente_idCliente"]);
					$prucli->__SET("diagnostico",$fila["diagnostico"]);
					$prucli->__SET("fechaPrueba",$fila["fechaPrueba"]);
					 
				  }  	               
				   
				  return $prucli; //Retorno el objeto pruebaCliente buscado
				
			   }
	
	           public function Insertar($prucli) //Función que me permite insertar un objeto pruebacliente
	           {  //Por un lado hago la consulta y por otro lado le paso los parámetros, que me los coge vía GET del objeto pruebacliente que recibe como parámetro
			      $consulta="insert into pruebacliente values (:prueba_idprueba, 
	                            			              :cliente_idCliente,
				                                          :diagnostico,
														  :fechaPrueba)";
												

                  $param=array(":prueba_idprueba"=>$prucli->__GET("prueba_idprueba"),
				               ":cliente_idCliente"=>$prucli->__GET("cliente_idCliente"),
				               ":diagnostico"=>$prucli->__GET("diagnostico"),
							   ":fechaPrueba"=>$prucli->__GET("fechaPrueba"),
							   );     								
										

                  $this->ConsultaSimple($consulta,$param); //Ejecuto la consulta
				  
				 		   
			   }
			   
			   
			   public function Actualizar($prucli) //Función que me permite actualizar pruebas
	           { //Por un lado hago la consulta y por otro lado le paso los parámetros, que me los coge vía GET del objeto prueba que recibe como parámetro
			      $consulta="update pruebacliente set diagnostico=:diagnostico
                                    where prueba_idprueba=:prueba_idprueba 
                                    AND cliente_idCliente=:cliente_idCliente
                                    AND fechaPrueba=:fechaPrueba"; 					  

                 $param=array(":prueba_idprueba"=>$prucli->__GET("prueba_idprueba"),
                                    ":cliente_idCliente"=>$prucli->__GET("cliente_idCliente"),
                                    ":diagnostico"=>$prucli->__GET("diagnostico"),
                                    ":fechaPrueba"=>$prucli->__GET("fechaPrueba"),
                                    );     	

                  $this->ConsultaSimple($consulta,$param);
				  
				 		   
			   }
			   
            //En este caso no realizo la función eliminar porque no se nos requirió 	
}

?>
