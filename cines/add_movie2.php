<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Película</title>

    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
</head>
<body>

<?php

include("funciones.php");

$conexion = conectar_bd();

//vamos a leer los cines!!!

$consulta = "SELECT * FROM movietheaters";

$cines = $conexion->query($consulta);

$cines-> fetch_assoc();

?>

<form method="POST">
    <label for="titulo"class="form-label">Titulo:</label>
    <input type="text" name="titulo" required class="form-control">

    <br>

    <label for="rating"class="form-label">Rating:</label>
    <select name="rating">
        <option value="PG">PG</option>
        <option value="G">G</option>
        <option value="NC-17">NC-17</option>
        <option value="PG-13">PG-13</option>
    </select>

    <br>
    <label for="money" class="form-label">Money:</label>
    <input type="number"  name="money" class="form-control">

    <label for="cine"class="form-label">Cine</label>
    <select name="cine" class="form-control">

    <?php

    //esto sirve para mostrar el option desde la BD
    foreach($cines as $cine){
        echo " <option value='".$cine["Code"]."'>".$cine["Name"]."</option>";
    }
    

    ?>


    </select>
    
    <input type="submit" class="btn btn-primary" value="Añadir Película">

</form>
    
<?php


if($_POST){
    $titulo = $_POST ["titulo"];
    $rating = $_POST["rating"];
    $recaudacion = $_POST["money"];
    $cine = $_POST["cine"];


    $conexion = conectar_bd();

    $consulta = " INSERT INTO movies (Title, Rating, Money)
    VALUES ('$titulo','$rating','$recaudacion')";

    $resultado_consulta = $conexion->query($consulta);

    $id_pelicula = $conexion->insert_id; //agrega la id de la ultima inserción 


    //nueva consulta en la tabla de cines actualizo el cine seleccionado con la id de la pelicula creada

    $consulta = "UPDATE movietheaters SET Movie = $id_pelicula
    WHERE Code = $cine"; 
    
    $resultado_consulta = $conexion->query($consulta);


    header("location:index4.php"); //te redirige a nuestro listado




}
?>

</body>
</html>