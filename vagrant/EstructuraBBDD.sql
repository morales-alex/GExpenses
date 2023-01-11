DROP DATABASE IF EXISTS GExpenses_3P1 ;
CREATE DATABASE GExpenses_3P1;

-- drop table gastos;drop table UsuariosActividades;drop table Usuarios;drop table Actividades;

USE GExpenses_3P1;

CREATE TABLE IF NOT EXISTS Usuarios ( 
	u_id		int AUTO_INCREMENT, -- IDENTITY(1,1) = AUTO_INCREMENT, EMPIEZA EN 1 Y SUBE DE 1 EN 1
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
	a_moneda	varchar(3) NOT NULL,
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
	i_token VARCHAR(40),
    i_correoUsuarioInvitado VARCHAR(60),
	i_fecInv datetime,
	PRIMARY KEY (i_id),
	FOREIGN KEY (i_idUsu, i_idAct) REFERENCES UsuariosActividades (ua_idUsu, ua_idAct)
) ENGINE=INNODB;


CREATE TABLE IF NOT EXISTS Gastos (
	g_id		int AUTO_INCREMENT,
	g_idUsu		int, -- PERSONA QUE PAGA
	g_idAct		int, -- ACTIVIDAD RELACIONADA
	g_precio	double NOT NULL,
	g_concepto	varchar(50),
    g_fecCrea	date,
	PRIMARY KEY (g_id),
	FOREIGN KEY (g_idUsu, g_idAct) REFERENCES UsuariosActividades (ua_idUsu, ua_idAct)
) ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS LineasGastos (
l_id int AUTO_INCREMENT,
l_idUsu int, -- EL enduadado
l_idGasto int, -- GASTO
l_importe double NOT NULL,
PRIMARY KEY (l_id, l_idGasto),
FOREIGN KEY (l_idGasto) REFERENCES Gastos (g_id)
) ENGINE=INNODB;

INSERT INTO Usuarios (u_username, u_nombre, u_apellidos, u_correo, u_password) values('admin', 'Pere', 'Pou G', 'Pou.Pere.G@alumnat.copernic.cat', '$2y$10$o7.Xhj4uByDtF2gX0JRbouQcFSMV4TdghkS1QzmVcE/8KFliifFKK');
INSERT INTO Usuarios (u_username, u_nombre, u_apellidos, u_correo, u_password) values('aalgarra', 'Alejandro', 'Algarra Delgado', 'algarra.delgado.alejandro@alumnat.copernic.cat', '$2y$10$o7.Xhj4uByDtF2gX0JRbouQcFSMV4TdghkS1QzmVcE/8KFliifFKK');
INSERT INTO Usuarios (u_username, u_nombre, u_apellidos, u_correo, u_password) values('amorales', 'Alex', 'Morales Luna', 'morales.luna.alex@alumnat.copernic.cat', '$2y$10$o7.Xhj4uByDtF2gX0JRbouQcFSMV4TdghkS1QzmVcE/8KFliifFKK');
INSERT INTO Usuarios (u_username, u_nombre, u_apellidos, u_correo, u_password) values('mfreixa', 'Max', 'Freixa Abcd', 'freixa.abcd.max@alumnat.copernic.cat', '$2y$10$o7.Xhj4uByDtF2gX0JRbouQcFSMV4TdghkS1QzmVcE/8KFliifFKK');

INSERT INTO Actividades (a_nombre, a_moneda, a_descripcion, a_fecCreacion, a_fecUltMod) values('Viaje a las bahamas', 'EUR', 'Esto es una prueba de la descripcion de la actividad', '2022/11/01', '2022/11/18');
INSERT INTO Actividades (a_nombre, a_moneda, a_descripcion, a_fecCreacion, a_fecUltMod) values('Visita al palau de la música', 'EUR', 'Test Test TEst', '2022/11/05', '2022/11/13');
INSERT INTO Actividades (a_nombre, a_moneda, a_descripcion, a_fecCreacion, a_fecUltMod) values('Gincana por el monte', 'USD', 'Test Test TEst', '2022/11/08', '2022/11/15');

INSERT INTO UsuariosActividades (ua_idUsu, ua_idAct) values (1, 1);
INSERT INTO UsuariosActividades (ua_idUsu, ua_idAct) values (2, 1);
INSERT INTO UsuariosActividades (ua_idUsu, ua_idAct) values (3, 1);
INSERT INTO UsuariosActividades (ua_idUsu, ua_idAct) values (4, 1);

INSERT INTO UsuariosActividades (ua_idUsu, ua_idAct) values (1, 2);
INSERT INTO UsuariosActividades (ua_idUsu, ua_idAct) values (1, 3);

insert into Gastos (g_idUsu, g_idAct, g_precio, g_concepto, g_fecCrea) values (1, 1, 55.90, 'Bocadillos de jamón con tomate', sysdate());
insert into Gastos (g_idUsu, g_idAct, g_precio, g_concepto, g_fecCrea) values (1, 1, 300.56, 'Buceo con tiburones', sysdate());

INSERT INTO LineasGastos (l_idUsu, l_idGasto, l_importe) values (1, 1, )
-- PROCEDURE BUSCADOR DE DEUDAS
DELIMITER //
DROP PROCEDURE IF EXISTS BuscadorDeuda;
CREATE PROCEDURE BuscadorDeuda(IN Usuario1 varchar(30), IN Usuario2 varchar(30), OUT quantitat INT)
	BEGIN 
		SET quantitat = (Select SUM(l_importe)
			from LineasGastos lg
			inner join Gastos g on g.g_id = lg.l_idGasto
			inner join Actividades a on a.a_id = g.g_idAct
			inner join Usuarios uPaga on uPaga.u_id = g.g_idUsu
			inner join Usuarios uDebe on uDebe.u_id = lg.l_idUsu
			where a_id = 1 and uDebe.u_username=Usuario1 and uPaga.u_username=Usuario2
			group by uPaga.u_username); -- , uDebe.u_username;
	END //
DELIMITER ;

-- PROCEDURE COMPARADOR DE DEUDAS 
DROP PROCEDURE IF EXISTS ComparadorDeudas;
DELIMITER //
CREATE PROCEDURE ComparadorDeudas(IN Usuario1 varchar(30), IN Usuario2 varchar(30), OUT quantitat DOUBLE, OUT debedor varchar(30), OUT cobrador varchar(30))
	BEGIN
		SET @deudaUsuario1 = 0;
        CALL BuscadorDeuda(Usuario1, Usuario2, @deudaUsuario1);
        SET @deudaUsuario2 = 0;
        CALL BuscadorDeuda(Usuario2, Usuario1, @deudaUsuario2);
		SET quantitat = ABS(@deudaUsuario1 - @deudaUsuario2);
        
        IF (@deudaUsuario1 > @deudaUsuario2) THEN
			SET cobrador = Usuario1;
            SET debedor = Usuario2;
		ELSE 
			SET debedor = Usuario2;
            SET cobrador = Usuario1;
		END IF;
	END;
//
DELIMITER ;
-- CALL ComparadorDeudas("aalgarra", "fdsfdsa", @quantia,  @debedor, @cobrador);
-- SELECT coalesce(@quantia,0) AS QUANTIA, @debedor AS Paga, @cobrador AS Cobra;
/*
select * from gastos;
select * from usuariosActividades;
select * from actividades;
select * from usuarios;*//*
POSIBLE SELECT PARA LO QUE LE DEBE A CADA PERSONA
SELECT SUM(lg.l_importe) FROM LineasGastos lg
INNER JOIN Gastos g on g.g_id = lg.l_idGasto
group by lg.l_IdUsu, g.g_idUsu;
*/