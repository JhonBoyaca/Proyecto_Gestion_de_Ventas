<?php
require_once "config.php";
require_once "Usuario.php";
class DAOUsuarios
{

    private $con;

    private function conectar()
    {
        try {
            $this->con = new mysqli(SRV, USR, PWD, SCHEMA);
        } catch (Exception $ex) {
            echo "<script>console.log('Ocurrio un error de conexión...')</script>";
        }
    }
    private function desconectar()
    {
        $this->con->close();
    }

    public function login(Usuario $usuario)
    {
        $datos = array();
        $sql = "select correo, rol from usuario where correo='" . $usuario->getCorreo()
            . "' and contrasena='" . $usuario->getContrasena() . "'";
        $this->conectar();
        $res = $this->con->query($sql);
        if (mysqli_num_rows($res) < 1) {
            $this->desconectar();
            return null;
        }
        while ($fila = mysqli_fetch_assoc($res)) {
            $datos["nombre"] = $fila["correo"];
            $datos["rol"] = $fila["rol"];
        }
        $this->desconectar();
        $res->close();
        return $datos;
    }
}
