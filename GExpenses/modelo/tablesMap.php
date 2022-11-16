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

class Actividades
{

    private int $a_id;
    private String $a_nom;

    public function __construct($a_id, $a_nom)
    {
        $this->a_id = $a_id;
        $this->a_nom = $a_nom;
    }

    public function getA_id()
    {
        return $this->a_id;
    }

    public function getA_nom()
    {
        return $this->a_nom;
    }
}

class UsuariosActividades
{

    private int $a_idUsu;
    private int $a_idAct;

    public function __construct($a_idUsu, $a_idAct)
    {
        $this->a_idUsu = $a_idUsu;
        $this->a_idAct = $a_idAct;
    }

    public function getA_idUsu()
    {
        return $this->a_idUsu;
    }

    public function getA_idAct()
    {
        return $this->a_idAct;
    }
}

class Gastos {

    private int $g_id;
    private int $g_idUsu;
    private int $g_idAct;
    private int $g_precio;
    private String $g_concepto;

    public function __construct($g_id, $g_idUsu, $g_idAct, $g_precio, $g_concepto)
    {
        $this->g_id = $g_id;
        $this->g_idUsu = $g_idUsu;
        $this->g_idAct = $g_idAct;
        $this->g_precio = $g_precio;
        $this->g_concepto = $g_concepto;
    }

    public function getG_id()
    {
        return $this->g_id;
    }

    public function getG_idUsu()
    {
        return $this->g_idUsu;
    }

    public function getG_idAct()
    {
        return $this->g_idAct;
    }

    public function getG_precio()
    {
        return $this->g_precio;
    }

    public function getG_concepto()
    {
        return $this->g_concepto;
    }

}