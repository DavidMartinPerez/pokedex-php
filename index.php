<!DOCTYPE html>
<?php
    //UPDATE `pokedex` SET `capturado`= 1 WHERE `numero` = $numero;
    if(isset($_POST["actualizar"])){

    }
    
?>

<html lang="en" dir="ltr" style="background-image: url('https://i.pinimg.com/originals/d5/00/d2/d500d286b7f6e8787218447409e1b152.jpg')">
    <head>
        <meta charset="utf-8">
        <title>POKEDEX</title>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    </head>
    <body class="container">
        <?php

        $bd = @new mysqli("localhost", "root", "", "pokedex") ;
        //comprobamos si se conecta a la base de datos
        if($bd->connect_errno) {
            die("Error al conectar con la Base de datos (Posibles datos erroneos)") ;
        }
        $bd-> set_charset("utf8");
            $reg = $bd->query("SELECT * FROM `pokedex` LIMIT 0, 807");
        ?>
        <table class="table table-bordered">
            <tr>
                <th>Nº Pokedex</th>
                <th>Nombre pokemon</th>
                <th>Capturado</th>
            </tr>
            <tr>
            <?php
                while($row = mysqli_fetch_object($reg)){ ?>
                <td><?=$row->numero ?></td>
                <td><?=$row->nombre ?></td>
                <?php if ($row->capturado == 0) { //Comprobar si el pokemon ha sido capturado
                    $estado = "";
                } else {
                    $estado = 'checked="checked"';
                }
                ?>
                <td><input type="checkbox" <?=$estado?> value="<?=$row->numero ?>"></td>
            </tr>
        <?php } ?>

        </table>
    </body>
</html>
