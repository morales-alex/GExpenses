/*
CREATE DATABASE GExpenses_3P1
	COLLATE Latin1_general_CI_AI;
*/

-- drop table gastos;drop table dbo.UsuariosActividades;drop table dbo.Usuarios;drop table dbo.Actividades;

USE GExpenses_3P1;

CREATE TABLE Usuarios (
	u_id		int IDENTITY(1,1), -- IDENTITY(1,1) = AUTO_INCREMENT, EMPIEZA EN 1 Y SUBE DE 1 EN 1
	u_username	varchar(30) UNIQUE,
	u_nombre	varchar(60),
	u_apellidos	varchar(60),
	u_correo	varchar(60) UNIQUE,
	u_password	varchar(50),
	PRIMARY KEY(u_id)
);

CREATE TABLE Actividades (
	a_id		int IDENTITY(1,1),
	a_nombre	varchar(30),
	a_moneda	char(1),
	a_descripcion varchar(130),
	PRIMARY KEY(a_id)
);

CREATE TABLE UsuariosActividades (
	ua_idUsu		int FOREIGN KEY REFERENCES Usuarios(u_id),
	ua_idAct		int FOREIGN KEY REFERENCES Actividades(a_id),
	PRIMARY KEY(ua_idUsu, ua_idAct)
);

CREATE TABLE Gastos (
	g_id		int IDENTITY(1,1),
	g_idUsu		int, -- PERSONA QUE PAGA
	g_idAct		int, -- ACTIVIDAD RELACIONADA
	g_precio	int,
	g_concepto	varchar(50),
	PRIMARY KEY(g_idUsu, g_idAct, g_id),
	FOREIGN KEY (g_idUsu, g_idAct) REFERENCES UsuariosActividades (ua_idUsu, ua_idAct)
);

INSERT INTO Usuarios (u_username, u_nombre, u_apellidos, u_correo, u_password) values('aalgarra', 'Alejandro', 'Algarra Delgado', 'algarra.delgado.alejandro@alumnat.copernic.cat', '123');
INSERT INTO Usuarios (u_username, u_nombre, u_apellidos, u_correo, u_password) values('amorales', 'Alex', 'Morales Luna', 'morales.luna.alex@alumnat.copernic.cat', '123');
INSERT INTO Usuarios (u_username, u_nombre, u_apellidos, u_correo, u_password) values('mfreixa', 'Max', 'Freixa Abcd', 'freixa.abcd.max@alumnat.copernic.cat', '123');


select * from usuarios;
