<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inserción de pruebas y clientes Clínica Oftalmología Examen Mayo 2020 DWES</title>
</head>
<body>

<?php //Requiero los archivos necesarios para la funcionalidad de este fichero php

require_once "Cliente.php";
require_once "Prueba.php";
require_once "PruebaCliente.php";
require_once "daoCliente.php";
require_once "daoPrueba.php";
require_once "daoPruebaCliente.php"; 
require_once "classConexion.php";

if( (isset($_POST['Prueba']) ) && $_POST['Prueba']!=-1 && (isset($_POST['Cliente']) ) && $_POST['Cliente']!=-1 && (isset($_POST['diagnostico']) ) && $_POST['diagnostico'] !=-1 && (isset($_POST ['fecha']) ) && $_POST['fecha']!=-1 ){ //Si el usuario ha enviado vía POST los cuatro atributos que necesito para crear un objeto PruebaCliente

    $prueba_idprueba=$_POST['Prueba']; //Los atributos de la clase cogen los valores del POST
    $cliente_idCliente=$_POST['Cliente'];
    $diagnostico=$_POST['diagnostico'];
    $fechaPrueba=$_POST['fecha']; 

    $prucli = new PruebaCliente();  //Creo un nuevo objeto
    //Le seteo las variables, y así me ahorro el constructor   
    $prucli->__SET("prueba_idprueba", $prueba_idprueba);
    $prucli->__SET("cliente_idCliente", $cliente_idCliente);
    $prucli->__SET("diagnostico", $diagnostico);
    $prucli->__SET("fechaPrueba", $fechaPrueba);

    $daoPruebaCliente=new DaoPruebaCliente("examen"); //Conecto con la BBDD
    $daoPruebaCliente->Insertar($prucli); //Inserto el objeto en la BBDD en su tabla correspondiente
}

?>

<form method="POST" name="formulario" action="<?php $_SERVER['PHP_SELF']?>">

<label for="Cliente"> Seleccione un cliente </label>
        <select name="Cliente" id="Cliente">
            <option value="-1">Seleccione un cliente</option>
        <?php 
            $daoCliente=new DaoCliente("examen"); //Creo un objeto daoCliente y le paso la BBDD como parámetro, así conecta
            $daoCliente->Listar(); //llamo al método listar
            foreach ($daoCliente->Clientes as $key => $value) { //Dado que con listar lo que hago es rellenar el array de Clientes, accedo a él y lo recorro ya con normalidad. Recorro el array que he rellenado con el DAO y lo muestro
                echo "<option value='" . $value->idCliente . "'>" . $value->apellidos ." ". $value->nombreCliente . "</option>";
                }
        ?>    
        </select>

<br><br>

<label for="Prueba"> Seleccione una prueba </label>
        <select name="Prueba" id="Prueba">
            <option value="-1">Seleccione una prueba</option>
        <?php 
            $daoPrueba=new DaoPrueba("examen"); //Creo un objeto daoPrueba y le paso la BBDD como parámetro, así conecta
            $daoPrueba->Listar(""); //llamo al método listar
            foreach ($daoPrueba->Pruebas as $key => $value) { //Dado que con listar lo que hago es rellenar el array de Pruebas, accedo a él y lo recorro ya con normalidad. Recorro el array que he rellenado con el DAO y lo muestro
                echo "<option value='" . $value->idPrueba . "'>" . $value->nombrePrueba . "</option>";
                }
        ?> 
        </select>  

<br><br> 

<label for="diagnostico">Introduzca el diagnóstico</label>
<input type="text" name="diagnostico" id="diagnostico"/>
<br> <br>

<label for="fecha">Introduzca la fecha en formato DD-MM-AAAA</label>
<input type="text" name="fecha" id="fecha"/>
<br> <br>

<input type="submit" name="enviar" value="Insertar registro" /> 


</body>
</html>