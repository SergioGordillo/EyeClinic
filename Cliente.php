<?php

class Cliente {
    
    //Atributos de la clase
     private $idCliente;
     private $nombreCliente;
     private $apellidos;
     private $direccion;
     private $telefono;
     private $nif;
     private $email;

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