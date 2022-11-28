CREATE DATABASE GExpenses_3P1;

-- drop table gastos;drop table UsuariosActividades;drop table Usuarios;drop table Actividades;

USE GExpenses_3P1;

CREATE TABLE IF NOT EXISTS Usuarios ( 
	u_id		int AUTO_INCREMENT,
	u_username	varchar(30) UNIQUE,
	u_nombre	varchar(60),
	u_apellidos	varchar(60),
	u_correo	varchar(60) UNIQUE,
	u_password	varchar(255) NOT NULL,
	PRIMARY KEY(u_id)
) ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS Actividades (
	a_id		int AUTO_INCREMENT,
	a_nombre	varchar(30) NOT NULL,
	a_moneda	char(1) NOT NULL,
	a_descripcion varchar(130),
    a_fecCreacion date,
    a_fecUltMod date,
	PRIMARY KEY(a_id)
) ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS UsuariosActividades (
	ua_idUsu		int,
	ua_idAct		int,
	PRIMARY KEY(ua_idUsu, ua_idAct),
    FOREIGN KEY (ua_idUsu) REFERENCES Usuarios (u_id),
    FOREIGN KEY (ua_idAct) REFERENCES Actividades (a_id)
) ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS Invitaciones (
	i_id INT AUTO_INCREMENT,
    i_idUsu INT,
    i_idAct INT,
    i_correoUsuarioInvitado VARCHAR(60),
	i_date DATETIME ,
	PRIMARY KEY (i_id),
	FOREIGN KEY (i_idUsu, i_idAct) REFERENCES UsuariosActividades (ua_idUsu, ua_idAct)
) ENGINE=INNODB;


CREATE TABLE IF NOT EXISTS Gastos (
	g_id		int AUTO_INCREMENT,
	g_idUsu		int, -- PERSONA QUE PAGA
	g_idAct		int, -- ACTIVIDAD RELACIONADA
	g_precio	int NOT NULL,
	g_concepto	varchar(50),
	PRIMARY KEY (g_id),
	FOREIGN KEY (g_idUsu, g_idAct) REFERENCES UsuariosActividades (ua_idUsu, ua_idAct)
) ENGINE=INNODB;


INSERT INTO Usuarios (u_username, u_nombre, u_apellidos, u_correo, u_password) values('aalgarra', 'Alejandro', 'Algarra Delgado', 'algarra.delgado.alejandro@alumnat.copernic.cat', '$2y$10$o7.Xhj4uByDtF2gX0JRbouQcFSMV4TdghkS1QzmVcE/8KFliifFKK');
INSERT INTO Usuarios (u_username, u_nombre, u_apellidos, u_correo, u_password) values('amorales', 'Alex', 'Morales Luna', 'morales.luna.alex@alumnat.copernic.cat', '$2y$10$o7.Xhj4uByDtF2gX0JRbouQcFSMV4TdghkS1QzmVcE/8KFliifFKK');
INSERT INTO Usuarios (u_username, u_nombre, u_apellidos, u_correo, u_password) values('mfreixa', 'Max', 'Freixa Abcd', 'freixa.abcd.max@alumnat.copernic.cat', '$2y$10$o7.Xhj4uByDtF2gX0JRbouQcFSMV4TdghkS1QzmVcE/8KFliifFKK');

INSERT INTO Actividades (a_nombre, a_moneda, a_descripcion, a_fecCreacion, a_fecUltMod) values('test', '€', 'Test Test TEst', '2022/11/01', '2022/11/18');
INSERT INTO Actividades (a_nombre, a_moneda, a_descripcion, a_fecCreacion, a_fecUltMod) values('test2', '€', 'Test Test TEst', '2022/11/05', '2022/11/13');
INSERT INTO Actividades (a_nombre, a_moneda, a_descripcion, a_fecCreacion, a_fecUltMod) values('test3', '€', 'Test Test TEst', '2022/11/08', '2022/11/15');
