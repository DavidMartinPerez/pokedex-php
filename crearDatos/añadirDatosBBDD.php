<?php
    $eliminar = 0;
    if(isset($_GET["limpiar"])){
        $eliminar = 1;
    }
    $data = file_get_contents("datos.json");
    $arrayPokemon = json_decode($data, true);
    //INSERT INTO `pokedex`(`numero`, `nombre`, `capturado`) VALUES (1,"aaa",0)
    $coma = 0;
    $sql = 'INSERT INTO `pokedex`(`numero`, `nombre`, `capturado`) VALUES ';

    foreach ($arrayPokemon as $pokemon) {
        if($coma == 1){
            $sql .= ' , ';
        } else {
            $coma = 1;
        }
        $sql .= '(' . $pokemon["numero"] . ',"' . $pokemon["nombre"] . '",0)';

    }
    $bd = @new mysqli("localhost", "root", "", "pokedex") ;
    if($bd->connect_errno) {
        die("Error al conectar con la Base de datos (Posibles datos erroneos)") ;
    }
    $bd-> set_charset("utf8");
    //comprobamos si se conecta a la base de datos
    if($eliminar == 1){
        $bd->query("DELETE FROM pokedex");
    }
    $reg = $bd->query($sql);
    if($reg){
        echo "Datos exportados";
    } else {
        ?>
        <div> Datos duplicados </div>
        <div> ¿Deseas limpiar la base de datos y reintentarlo? </div>
        <a href="?limpiar">Pulsa aquí</a>
        <?php
    }
?>
