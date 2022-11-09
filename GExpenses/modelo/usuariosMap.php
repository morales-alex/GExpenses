<?php

class usuarios
{

    private int $u_id;
    private String $u_username;
    private String $u_nombre;
    private String $u_apellidos;
    private String $u_correo;
    private String $u_password;

    public function __construct($u_id, $u_username, $u_nombre, $u_apellidos, $u_correo, $u_password)
    {
        $this->u_id = $u_id;
        $this->u_username = $u_username;
        $this->u_nombre = $u_nombre;
        $this->u_apellidos = $u_apellidos;
        $this->u_correo = $u_correo;
        $this->u_password = $u_password;
    }

    public function getU_id()
    {
        return $this->u_id;
    }

    public function getU_username()
    {
        return $this->u_username;
    }

    public function getU_nombre()
    {
        return $this->u_nombre;
    }

    public function getU_apellidos()
    {
        return $this->u_apellidos;
    }

    public function getU_correo()
    {
        return $this->u_correo;
    }

    public function getU_password()
    {
        return $this->u_password;
    }
}
