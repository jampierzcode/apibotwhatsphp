<?php
include_once "Conexion.php";

class Usuario
{
    var $datos;
    var $mensaje;
    public $conexion;

    public function __construct()
    {
        // se va a conectar a la base de datos
        $db = new Conexion(); // $db ya no es una variable es un objeto
        $this->conexion = $db->pdo;
        // $this hace referencia al objeto que se crea en una instancia de clase
    }
    function add_session($cliente_id, $last_connected)
    {

        try {
            $sql = "INSERT INTO sessions(clientId, isActive, lastConnected) VALUES(:cliente_id, :active, :last_connected)";
            $query = $this->conexion->prepare($sql);
            $query->execute(array(
                ":cliente_id" => $cliente_id,
                ":active" => 1,
                ':last_connected' => $last_connected,
            ));

            $session_id = $this->conexion->lastInsertId(); // Obtener el ID del usuario insertado
            $response = [
                "msg" => "add-session",
                "session_id" => $session_id
            ];

            $this->mensaje = $response;
            return $this->mensaje;
        } catch (\Throwable $error) {
            $response = [
                "msg" => "error",
                "error" => $error
            ];
            $this->mensaje = $response;
            return $this->mensaje;
        }
    }
    function desconectar_session($cliente_id)
    {

        try {
            $sql = "UPDATE sessions SET isActive=:isActive WHERE clientId=:cliente_id";
            $query = $this->conexion->prepare($sql);
            $query->execute(array(
                ":isActive" => 0,
                ":cliente_id" => $cliente_id,
            ));

            $response[] = [
                "msg" => "success",
            ];

            $this->mensaje = $response;
            return $this->mensaje;
        } catch (\Throwable $error) {
            $response[] = [
                "msg" => "error",
                "error" => $error
            ];
            $this->mensaje = $response;
            return $this->mensaje;
        }
    }
    function buscar_sesiones()
    {

        try {
            $sql = "SELECT * FROM sessions WHERE isActive=1";
            $query = $this->conexion->prepare($sql);
            $query->execute();
            $this->datos = $query->fetchAll();
            $response = [
                "msg" => "success",
                "data" => $this->datos
            ];
            $this->mensaje = $response;
            return $this->mensaje;
        } catch (\Throwable $error) {
            $response = [
                "msg" => "error",
                "error" => $error
            ];
            $this->mensaje = $response;
            return $this->mensaje;
        }
    }
}
