<?php

class usuarios
{

    private int $u_id;
    private String $u_username;
    private String $u_nombre;
    private String $u_apellidos;
    private String $u_correo;
    private String $u_password;

    public function __construct($u_id, $u_username, $u_nombre, $u_apellidos, $u_correo, /*$u_password*/)
    {
        $this->u_id = $u_id;
        $this->u_username = $u_username;
        $this->u_nombre = $u_nombre;
        $this->u_apellidos = $u_apellidos;
        $this->u_correo = $u_correo;
        //$this->u_password = $u_password;
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
    private String $a_descripcion;
    private String $a_fecCreacion;
    private String $a_fecUltMod;

    public function __construct($a_id, $a_nom, $a_descripcion, $a_fecCreacion, $a_fecUltMod)
    {
        $this->a_id = $a_id;
        $this->a_nom = $a_nom;
        $this->a_descripcion = $a_descripcion;
        $this->a_fecCreacion = $a_fecCreacion;
        $this->a_fecUltMod = $a_fecUltMod;
    }

    public function getA_id()
    {
        return $this->a_id;
    }

    public function getA_nom()
    {
        return $this->a_nom;
    }

    public function getA_descripcion()
    {
        return $this->a_descripcion;
    }
    public function getA_fecCreacion()
    {
        return $this->a_fecCreacion;
    }
    public function getA_fecUltMod()
    {
        return $this->a_fecUltMod;
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

class Invitaciones
{
    private int $i_id;
    private int $i_idUsu;
    private int $i_idAct;
    private String $i_correoUsuarioInvitado;
    public function __construct($i_id, $i_idUsu, $i_idAct, $i_correoUsuarioInvitado)
    {
        $this->i_id = $i_id;
        $this->i_idUsu = $i_idUsu;
        $this->i_idAct = $i_idAct;
        $this->i_correoUsuarioInvitado = $i_correoUsuarioInvitado;
    }
    public function getI_id()
    {
        return $this->i_id;
    }

    public function getI_idUsu()
    {
        return $this->i_idUsu;
    }

    public function getI_idAct()
    {
        return $this->i_idAct;
    }

    public function geti_correoUsuarioInvitado()
    {
        return $this->i_correoUsuarioInvitado;
    }
}

class Gastos
{

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
