<?php
include_once '../modelo/Usuario.php';
$usuario = new Usuario();
// session_start();
// $id_usuario = $_SESSION['id_usuario'];


// seccion usuarios
if ($_POST["funcion"] == "add_session") {
    $cliente_id = $_POST["cliente_id"];
    $last_connected = $_POST["last_connected"];
    $usuario->add_session($cliente_id, $last_connected);
    echo json_encode($usuario->mensaje);
}
if ($_POST["funcion"] == "login") {
    $email = $_POST["email"];
    $password = $_POST["password"];
    $usuario->login($email, $password);
    echo json_encode($usuario->mensaje);
}
if ($_POST["funcion"] == "desconectar_session") {
    $cliente_id = $_POST["cliente_id"];
    $usuario->desconectar_session($cliente_id);
    echo json_encode($usuario->mensaje);
}
if ($_POST["funcion"] == "buscar_sesiones") {
    $usuario->buscar_sesiones();
    echo json_encode($usuario->mensaje);
}
