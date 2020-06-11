<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo sobre las pruebas Clínica Oftalmología Examen Mayo 2020 DWES</title>
</head>
<body>

<?php //Requiero los archivos necesarios para la funcionalidad de este fichero php

require_once "Prueba.php";
require_once "daoPrueba.php";
require_once "classConexion.php";

$orden = "";

if(isset($_POST["borrar"])){

    if(isset($_POST['Pruebas']) && count($_POST['Pruebas'])>0){
        $arrayPruebas=$_POST['Pruebas']; //Aquí no me llega el objeto, me llega el id (value del checkbox). El array que me llega tiene forma de 0-1, 1-3 etc.

        $daoPrueba=new DaoPrueba("examen"); //Hago la conexión con la BBDD

        foreach ($arrayPruebas as $key => $prueba) { //En esta prueba, lo que tengo no es el objeto entero, sino sólo el id, porque es el valor que recojo del checkbox

            $daoPrueba->Eliminar($prueba); //Elimino mediante el método del dao las pruebas seleccionadas
            
        }


    }

} else if(isset($_POST["actualizar"])){ //Si me llega vía POST 'actualizar'

    if(isset($_POST['Pruebas'])){ //Si tengo seteado Pruebas (lo del checkbox)
       
        $arrayPruebas=$_POST['Pruebas'];
       
        $daoPrueba=new daoPrueba("examen"); //Hago la conexión

        foreach ($arrayPruebas as $key => $value) {
            $idPrueba=$value;
            $nombrePrueba=$_POST[$value."_Nombre"];
            $aparatosNecesarios=$_POST[$value."_aparatosNecesarios"];
            $descripcion=$_POST[$value."_descripcion"];

            $prueba = new Prueba(); //Creo un objeto prueba
            //Al no tener constructores, seteo los valores directamente
            $prueba->__SET("idPrueba",$idPrueba);
            $prueba->__SET("nombrePrueba",$nombrePrueba);
            $prueba->__SET("aparatosNecesarios",$aparatosNecesarios);
            $prueba->__SET("descripcion",$descripcion);

            $daoPrueba->Actualizar($prueba); //Llamo a la función del daoPrueba para actualizar
        }

    }

}  else if(isset($_POST["insertar"])){ //Si tengo seteado insertar

    if(isset($_POST ['idPrueba'] ) && isset($_POST ['nombrePrueba'] ) && isset($_POST ['aparatosNecesarios'] ) && isset($_POST ['descripcion'] )    ) { //Si todos los valores están seteados

        $idPrueba=$_POST['idPrueba']; //Cojo los valores
        $nombrePrueba=$_POST['nombrePrueba'];
        $aparatosNecesarios=$_POST['aparatosNecesarios'];
        $descripcion=$_POST['descripcion'];

        $prueba = new Prueba(); //Creo un objeto prueba
            //Al no tener constructores, seteo los valores directamente
        $prueba->__SET("idPrueba",$idPrueba);
        $prueba->__SET("nombrePrueba",$nombrePrueba);
        $prueba->__SET("aparatosNecesarios",$aparatosNecesarios);
        $prueba->__SET("descripcion",$descripcion);

        $daoPrueba=new daoPrueba("examen"); //Conecto con la BBDD
        $daoPrueba->Insertar($prueba); //Inserto
    }


} else if (isset($_POST["buscar"])){ //En caso de que reciba vía POST 'buscar'
    $idPrueba=$_POST['idPrueba']; 
    $daoprueba=new DaoPrueba("examen"); //Conecto con la BBDD
    $pruebabuscada=$daoprueba->ObtPru($idPrueba); //La variable pruebabuscada recibirá los valores de la búsqueda
    $correcto=true;

    if(is_null($pruebabuscada)){ //Si la prueba buscada no existe en nuestra BBDD
        $correcto = false;
        echo "No existe la prueba buscada en nuestra BBDD";
    }

} else if (isset($_POST['ordenar']) ) { //Si está seteado ordenar

    $orden=$_POST['selectordenar']; //En ese caso cojo el valor que tiene el select y que ha enviado vía POST

} else if (isset($_POST['filtrar']) ){


    // $daoPrueba=new daoPrueba("examen"); //Conecto con la BBDD
    // $daoPrueba->Filtrar($_POST['filtronombreprueba']); //Inserto

    
    $daoPrueba=new daoPrueba("examen"); //Conecto con la BBDD

    $prueba = new Prueba(); //Creo un objeto con los campos a filtrar
    $prueba->__SET("nombrePrueba",$_POST['filtronombreprueba']); //Seteo las variables con lo que envío $_POST
    $prueba->__SET("aparatosNecesarios",$_POST['filtroaparatosnecesarios']);

    $daoPrueba->FiltrarObjeto($prueba); //Inserto el objeto en el método del DAO


}

if ( !isset($_POST['filtrar']) || isset ($_POST['listar']) ){
    $daoPrueba=new daoPrueba("examen"); //Para conectar con la BBDD
    $daoPrueba-> Listar($orden); //Llamo al método listar    
}


?>
<form method="POST" name="formulario" action="<?php $_SERVER['PHP_SELF']?>">


<label for='filtronombreprueba'>Introduzca el Nombre de la Prueba a buscar </label>
<input type='text' name='filtronombreprueba' id='filtronombreprueba'/>

<label for='filtroaparatosnecesarios'>Introduzca el Filtro de Aparatos Necesarios </label>
<input type='text' name='filtroaparatosnecesarios' id='filtroaparatosnecesarios'/>


<table>
    <tr>
        <th></th>
        <th>ID Prueba</th>
        <th>Nombre Prueba</th>
        <th>Aparatos Necesarios</th>
        <th>Descripción</th>
    </tr>
    <?php
        foreach ($daoPrueba->Pruebas as $key => $prueba) { //Como ya hice el listar arriba, simplemente recorro el array que he rellenado con dicho método y voy poniendo los names y values que me permitan mostrarlo en formato tabla
            echo "<tr>";

            echo "<td>";
            echo "<input type='checkbox' name='Pruebas[]' value='".$prueba->idPrueba."'>";
            echo "</td>";

            echo "<td>";
            echo $prueba->idPrueba; 
            echo "</td>";

            echo "<td>";
                    echo "<input type='text' name='".$prueba->idPrueba."_Nombre' value='".$prueba->nombrePrueba."'>";
                    echo "</td>";

                    echo "<td>";
                    echo "<input type='text' name='".$prueba->idPrueba."_aparatosNecesarios' value='".$prueba->aparatosNecesarios."'>";
                    echo "</td>";

                    echo "<td>";
                    echo "<input type='text' name='".$prueba->idPrueba."_descripcion' value='".$prueba->descripcion."'>";
                    echo "</td>";

            echo "</tr>"; 


          
        }



    ?>


    <tr>
        <td></td>
        <td>
            <input type="text" name="idPrueba"> 
        </td>
        <td>
            <input type="text" name="nombrePrueba" value="<?php if(isset($pruebabuscada) && $correcto) {echo $pruebabuscada->nombrePrueba;} ?>"> 
        </td>
        <td>
            <input type="text" name="aparatosNecesarios" value="<?php if(isset($pruebabuscada)&& $correcto) {echo $pruebabuscada->aparatosNecesarios;} ?>"> 
        </td>
        <td>
            <input type="text" name="descripcion" value="<?php if(isset($pruebabuscada)&& $correcto) {echo $pruebabuscada->descripcion;} ?>"> 
        </td>
    </tr>
</table>
<input type="submit" value="Borrar" name="borrar"> 
<!-- El valor es lo que muestro y el name lo que recojo -->
<input type="submit" value="Actualizar" name="actualizar">
<input type="submit" value="Insertar" name="insertar">
<input type="submit" value="Buscar" name="buscar">
<label for="selectordenar"> Seleccione cómo quiere ordenar la tabla </label>
<select name="selectordenar" id="selectordenar">
    <option value="-1">Seleccione por qué campo quiere ordenar la tabla</option>
    <option value="idPrueba">Ordenar por Id Prueba</option>
    <option value="nombrePrueba">Ordenar por Nombre de la Prueba</option>
    <option value="aparatosNecesarios">Ordenar por Aparatos Necesarios</option>
    <option value="descripcion">Ordenar por Descripción</option>
</select>
<input type="submit" value="Ordenar" name="ordenar">
<input type="submit" value="Filtrar por campos" name="filtrar">
<input type="submit" value="Listar" name="listar">











</form>


</body>

</html>