USE GExpenses_3P1;

CREATE TABLE Usuarios (
	u_id		varchar(4),
	u_username	varchar(30) UNIQUE,
	u_nombre	varchar(60),
	u_correo	varchar(60) UNIQUE,
	u_password	varchar(50),
	PRIMARY KEY(u_id)
);

CREATE TABLE Actividades (
	a_id		varchar(4),
	a_nom		varchar(30),
	PRIMARY KEY(a_id)
);

CREATE TABLE UsuariosActividades (
	a_idUsu		varchar(4) FOREIGN KEY REFERENCES Usuarios(u_id),
	a_idAct		varchar(4) FOREIGN KEY REFERENCES Actividades(a_id),
	PRIMARY KEY(a_idUsu, a_idAct)
);
-- ES REALMENTE NECESARIO UsuariosActividades? PARECE QUE REPITE INFO.
CREATE TABLE Gastos (
	g_id		varchar(4),
	g_idUsu		varchar(4) FOREIGN KEY REFERENCES Usuarios(u_id), -- PERSONA QUE PAGA
	g_idAct		varchar(4) FOREIGN KEY REFERENCES Actividades(a_id), -- ACTIVIDAD RELACIONADA
	g_precio	int,
	g_concepto	varchar(50),
	PRIMARY KEY(g_idUsu, g_idAct, g_id)
);