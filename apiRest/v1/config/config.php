<?php

//cargamos json articulos
$jsonArticulos = file_get_contents('../app/core/data/articulos.json');
$articulos = json_decode($jsonArticulos, true);
//cargamos json carritos
$jsonArticulos = file_get_contents('../app/core/data/carritos.json');
$carritos = json_decode($jsonArticulos, true);
//cargamos json usuarios
$jsonArticulos = file_get_contents('../app/core/data/usuarios.json');
$usuarios = json_decode($jsonArticulos, true);

return [
    'articulos' => $articulos,
    'usuarios' => $usuarios,
    'carritos' => $carritos,
];