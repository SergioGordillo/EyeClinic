<?php

class PruebaCliente {
    
    //Atributos de la clase
     private $prueba_idprueba;
     private $cliente_idCliente;
     private $diagnostico;
     private $fechaPrueba;

    //Creo los getters y setters. Por cómo voy a hacer el programa, no necesito constructor.
	 public function __GET($propiedad)
	 {
		 return $this->$propiedad;
	 }
	 public function __SET($propiedad,$valor)
	 {
		 $this->$propiedad=$valor;
	 }
		
}

?>