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
            echo "<script>console.log('Ocurrió un error de conexión...')</script>";
        }
    }

    private function desconectar()
    {
        $this->con->close();
    }

    public function login(Usuario $usuario)
    {
        $datos = array();
        $sql = "SELECT * FROM usuario WHERE correo='" . $usuario->getCorreo()
            . "' AND contrasena='" . $usuario->getContrasena() . "'";
        $this->conectar();
        $res = $this->con->query($sql);
        if (mysqli_num_rows($res) < 1) {
            $this->desconectar();
            return null;
        }
        while ($fila = mysqli_fetch_assoc($res)) {
            $datos["correo"] = $fila["correo"];
            $datos["nombre"] = $fila["nombre"];
            $datos["rol"] = $fila["rol"];
            $datos["usuarioID"] = $fila["usuarioID"];
        }
        $this->desconectar();
        $res->close();
        return $datos;
    }



    public function getCorreo($correo)
    {
        $sql = "SELECT * FROM usuario WHERE correo = ?";
        $this->conectar();
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();
        $this->desconectar();
        return $user;
    }

    public function updatePassword($correo, $nuevaContrasena)
    {
        $sql = "UPDATE usuario SET contrasena = ? WHERE correo = ?";
        $this->conectar();
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("ss", $nuevaContrasena, $correo);

        if ($stmt->execute()) {
            $stmt->close();
            $this->desconectar();
            return true; // Actualización exitosa
        } else {
            echo "Error al actualizar la contraseña: " . $this->con->error;
            $stmt->close();
            $this->desconectar();
            return false; // Error en la actualización
        }
    }


    // Agrega otros métodos necesarios aquí
}
