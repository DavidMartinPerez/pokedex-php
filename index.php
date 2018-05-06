<!DOCTYPE html>
<html lang="en" dir="ltr" style="background-image: url('https://i.pinimg.com/originals/d5/00/d2/d500d286b7f6e8787218447409e1b152.jpg')">
    <head>
        <meta charset="utf-8">
        <title>POKEDEX</title>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
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
        //Añadir un pokemon capturados.
        if(isset($_POST["add"])){
            //UPDATE `pokedex` SET `capturado`= 1 WHERE `numero` = $numero;
            $valor = $_POST["add"];
            if(is_numeric($valor)){
                $reg = $bd->query("UPDATE `pokedex` SET `capturado`= 1 WHERE `numero` = $valor");
            }else{
                $reg = $bd->query("UPDATE `pokedex` SET `capturado`= 1 WHERE `nombre` = $valor");
            }
        }
        //Comprobamos cuantos registros existen para el contador.
        $regResultado = $bd->query("SELECT `numero`, `nombre`, `capturado` FROM `pokedex`");
        $totalPokemon = 0;
        $totalCapturados = 0;
        $totalNoCapturados = 0;
        while($row = mysqli_fetch_object($regResultado)){
            if($row->capturado == 1){
                $totalCapturados++;
            }else{
                $totalNoCapturados++;
            }
            $totalPokemon++;
        }
        //Filtrar por no Capturados.
        if(isset($_GET["no"])){
            $reg = $bd->query("SELECT `numero`, `nombre`, `capturado` FROM `pokedex` WHERE `capturado` = 0");
        } else {
            $inicio = $_GET["i"] ?? 0;
            $fin = $_GET["f"] ?? 807;
            $reg = $bd->query("SELECT * FROM `pokedex` LIMIT $inicio, $fin");
        }
        ?>
        <div class="row">
            <div class="col col-sm-3">
                Capturar pokemon:
                <form method="POST">
                    <input name="add" type="text" /><button type="submit">Registrar</button>
                </form>
            </div>
            <div class="col col-sm-9">
                <a class="btn btn-danger" href="?no">No capturados</a>
                Total de pokemon: <span style="color: blue"><?=$totalPokemon?></span> |
                Total de capturados: <span style="color: green"><?=$totalCapturados?></span> |
                Total no capturados: <span style="color: red"><?=$totalNoCapturados?></span>
            </div>
            <div class="col col-sm-8">
                <a class="btn btn-info" href="?i=0&f=151">Kanto(151)<br>1-151</a>
                <a class="btn btn-info" href="?i=151&f=100">Johto(100)<br>152-251</a>
                <a class="btn btn-info" href="?i=251&f=135">Hoen(135)<br>252-386</a>
                <a class="btn btn-info" href="?i=386&f=107">Sinnoh(107)<br>387-493</a>
                <a class="btn btn-info" href="?i=493&f=156">Teselia(156)<br>494-649</a>
                <a class="btn btn-info" href="?i=649&f=72">Kalos(72)<br>650-721</a>
                <a class="btn btn-info" href="?i=721&f=86">Alola(86)<br>722-807</a>
            </div>
        </div>
        <br>
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
                <?php if ($row->capturado == 1) { //Comprobar si el pokemon ha sido capturado
                    $estado = '<span class="glyphicon glyphicon-ok" style="color: green" aria-hidden="true"></span>';
                } else {
                    $estado = '<span class="glyphicon glyphicon-remove" style="color: red" aria-hidden="true"></span>';
                }
                ?>
                <td><?=$estado?></td>
            </tr>
        <?php } ?>

        </table>
    </body>
</html>
