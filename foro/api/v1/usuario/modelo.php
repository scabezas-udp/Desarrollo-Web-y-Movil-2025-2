<?php

class Usuario
{
    private $id;
    private $username;
    private $password;
    private $email;
    private $created_at;
    private $activo;

    public function __construct() {}

    // accesadores
    public function getId()
    {
        return $this->id;
    }
    public function getUsername()
    {
        return $this->username;
    }
    public function getPassword()
    {
        return $this->password;
    }
    public function getCreatedAt()
    {
        return $this->created_at;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function getActivo()
    {
        return $this->activo;
    }

    // mutadores
    public function setId($_n)
    {
        $this->id = $_n;
    }
    public function setUsername($_n)
    {
        $this->username = $_n;
    }
    public function setPassword($_n)
    {
        $this->password = $_n;
    }
    public function setCreatedAt($_n)
    {
        $this->created_at = $_n;
    }
    public function setEmail($_n)
    {
        $this->email = $_n;
    }
    public function setActivo($_n)
    {
        $this->activo = $_n;
    }

    public function getByUsernamePassword($_username, $_password)
    {
        $lista = [];
        $con = new Conexion();
        $query = "SELECT id, username, password, email, created_at, activo FROM foro_usuario WHERE username = '" . $_username . "' AND password=MD5('" . $_password . "');";
        $rs = mysqli_query($con->getConnection(), $query);
        if ($rs) {
            while ($registro = mysqli_fetch_assoc($rs)) {
                $registro['activo'] = $registro['activo'] == 1 ? true : false;
                array_push($lista, $registro);
            }
            mysqli_free_result($rs);
        }
        $con->closeConnection();
        return $lista[0];
    }

    public function add(Entrada $_nuevo)
    {
        /*
        $con = new Conexion();
        $nuevoId = count($this->getAll()) + 1;
        $query = "INSERT INTO indicador (id, codigo, nombre, unidad_medida_id, valor, activo) VALUES (" . $nuevoId . " ,'" . $_nuevo->getCodigo() . "', '" . $_nuevo->getNombre() . "', " . $_nuevo->getUnidadMedidaId() . ", " . $_nuevo->getValor() . ", TRUE)";
        try {
            $rs = mysqli_query($con->getConnection(), $query);
            $con->closeConnection();
            if ($rs) {
                return true;
            }
        } catch (\Throwable $th) {
            return false;
        }*/
    }
}
