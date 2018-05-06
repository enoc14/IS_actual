drop database if exists AnunciosITCM;
create database AnunciosITCM;
use AnunciosITCM;

drop table if exists CONTRASEÑA;
create table CONTRASEÑA(
	usuario varchar(50),
	contraseña varchar(25)
);

drop table if exists ANUNCIO;
create table ANUNCIO(
	id int auto_increment,
	titulo varchar(50),
	informacion longtext,
    plantilla enum ('1', '2', '3'),
    publicado bool not null default 0,
    ruta varchar(50),
    constraint pk_ANUNCIO primary key ANUNCIO(id)
);

drop table if exists ARCHIVO;
create table ARCHIVO(
	id int auto_increment,
    publicado bool not null default 0,
	archivo varchar(50),
    titulo varchar(50),
    constraint pk_ARCHIVO primary key ARCHIVO(id)
);

-- Mayo/02
-- Notas: Boolean es un tinyint(1), es decir toma solo 0-1, para falso-verdadero, respectivamente

-- #ANUNCIOS####################################################################################################### --

-- #Guardar, Editar, Eliminar#

drop procedure if exists guardarAnuncio;
delimiter $$
create procedure guardarAnuncio(in titulo varchar(50), in info longtext,in plan enum('1','2','3'))
	begin
		insert into ANUNCIO(titulo, informacion,plantilla, publicado) values (titulo,info,plan,0);
    end$$
delimiter ;

drop procedure if exists editarAnuncio;
-- Busca un anuncio por su id y cambia todo del mismo, incluyendo si está publicado o no
delimiter $$
create procedure editarAnuncio(in id int,in titulo varchar(50), in info longtext, in f_i date,
in f_f date, in h_i time,in h_f time,in plan enum ('1', '2', '3'), in publi bool)
	begin
		update ANUNCIO set ANUNCIO.titulo=titulo, ANUNCIO.informacion=info, ANUNCIO.fecha_subida=f_i, 
        ANUNCIO.fecha_vigencia= f_f, ANUNCIO.hora_inicio=h_i, ANUNCIO.hora_fin=h_f, ANUNCIO.plantilla=plan, 
        ANUNCIO.publicado=publi
        where ANUNCIO.id=id;
    end$$
delimiter ;

drop procedure if exists CambiarPlantillaAnuncio;
-- Busca un anuncio por su id, y cambia su plantilla
delimiter $$
create procedure CambiarPlantillaAnuncio(in id int, in plan enum ('1', '2', '3'))
	begin
		update ANUNCIO set ANUNCIO.plantilla=plan
        where ANUNCIO.id = id;
    end$$
delimiter ;

drop procedure if exists RetirarAnuncio;
-- Busca un anuncio por su id, y lo marca como NO publicado
delimiter $$
create procedure RetirarAnuncio(in id int)
	begin
		update ANUNCIO set ANUNCIO.publicado=0
        where ANUNCIO.id = id;
    end$$
delimiter ;

-- #Selects#

drop procedure if exists getAllAnuncios;
-- Muestra todo de todos los anuncios
delimiter $$
create procedure getAllAnuncios()
	begin
		Select * from ANUNCIO;
    end$$
delimiter ;

drop procedure if exists getAnuncio;
-- Muestra todo de un anuncio por su id
delimiter $$
create procedure getAnuncio(in id int)
	begin
		Select * from ANUNCIO 
        where ANUNCIO.id = id;
    end$$
delimiter ;


-- #ARCHIVOS####################################################################################################### --
    
    -- #Guardar, Editar, Eliminar#

drop procedure if exists guardarArchivo;
-- Guarda archivo, pidiendo todo menos id, que es autoincrement y publicado, que toma false por defecto
delimiter $$
create procedure guardarArchivo(in arch varchar(50), in tit varchar(50))
	begin
		insert into ARCHIVO(archivo, titulo) 
        values (arch, tit);
    end$$
delimiter ;

drop procedure if exists editarArchivo;
-- Busca un archivo por su id y cambia todo del mismo, incluyendo si está publicado o no
delimiter $$
create procedure editarArchivo(in id int,in arch varchar(50), in f_i date,in f_f date, in h_i time,in h_f time, in publi bool)
	begin
		update ARCHIVO set ARCHIVO.archivo=arch, ARCHIVO.fecha_subida=f_i, ARCHIVO.fecha_vigencia= f_f, 
        ARCHIVO.hora_inicio=h_i, ARCHIVO.hora_fin=h_f, ARCHIVO.publicado=publi
        where ARCHIVO.id=id;
    end$$
delimiter ;

drop procedure if exists PublicarArchivo;
-- Busca un archivo por su id, y lo marca como publicado
delimiter $$
create procedure PublicarArchivo(in id int)
	begin
		update ARCHIVO set ARCHIVO.publicado=1
        where ARCHIVO.id = id;
    end$$
delimiter ;

drop procedure if exists RetirarArchivo;
-- Busca un archivo por su id, y lo marca como NO publicado
delimiter $$
create procedure RetirarArchivo(in id int)
	begin
		update ARCHIVO set ARCHIVO.publicado=0
        where ARCHIVO.id = id;
    end$$
delimiter ;

-- #Selects#

drop procedure if exists getAllArchivos;
-- Muestra todo de todos los archivos
delimiter $$
create procedure getAllArchivos()
	begin
		Select * from ARCHIVO;
    end$$
delimiter ;

drop procedure if exists getArchivo;
-- Muestra todo de un archivo por su id
delimiter $$
create procedure getArchivo(in id int)
	begin
		Select * from ARCHIVO 
        where ARCHIVO.id = id;
    end$$
delimiter ;
    
#E N O C XD XD XD XD#################################################################################################
								  
drop procedure if exists guardarAnuncio;
delimiter $$
create procedure guardarAnuncio(in titulo varchar(50), in info longtext,in plan enum('1','2','3'))
	begin
		insert into ANUNCIO(titulo, informacion,plantilla,publicado) values (titulo,info,plan,0);
    end$$
delimiter ;

drop procedure if exists r_img;
delimiter $$
create procedure r_img(in l_id int)
	begin
		update anuncio set anuncio.ruta = (concat('files/anuncio_',l_id,'.jpg')) where anuncio.id = l_id;
		select titulo, informacion from ANUNCIO where l_id = id;
    end$$
delimiter ;

drop procedure if exists getAnunciosPublicados;
-- Muestra todo de los anuncios publicados
delimiter $$
create procedure getAnunciosPublicados()
	begin
		select anuncio.* from anuncio
        where ANUNCIO.publicado = 1;
    end$$
delimiter ;

drop procedure if exists getArchivosPublicados;
-- Muestra todo de los anuncios publicados
delimiter $$
create procedure getArchivosPublicados()
	begin
		select archivo.* from archivo
        where archivo.publicado = 1;
    end$$
delimiter ;

drop procedure if exists getAnunciosNoPublicados;
-- Muestra todo de los anuncios NO publicados
delimiter $$
create procedure getAnunciosNoPublicados()
	begin
		Select * from ANUNCIO 
        where ANUNCIO.publicado = 0;
    end$$
delimiter ;

drop procedure if exists getArchivosNoPublicados;
-- Muestra todo de los anuncios NO publicados
delimiter $$
create procedure getArchivosNoPublicados()
	begin
		Select * from archivo 
        where archivo.publicado = 0;
    end$$
delimiter ;

drop procedure if exists PublicarAnuncio;
-- Busca un anuncio por su id, y lo marca como publicado
delimiter $$
create procedure PublicarAnuncio(in id int)
	begin
		update ANUNCIO set ANUNCIO.publicado=1
        where ANUNCIO.id = id;
    end$$
delimiter ;

drop procedure if exists PublicarArchivo;
-- Busca un anuncio por su id, y lo marca como publicado
delimiter $$
create procedure PublicarArchivo(in id int)
	begin
		update archivo set archivo.publicado=1
        where archivo.id = id;
    end$$
delimiter ;

drop procedure if exists eliminarAnuncio;
-- Busca un anuncio por su id, y lo elimina
delimiter $$
create procedure eliminarAnuncio(in id int)
	begin
		delete from ANUNCIO
        where ANUNCIO.id = id;
    end$$
delimiter ;

drop procedure if exists eliminarArchivo;
-- Busca un anuncio por su id, y lo elimina
delimiter $$
create procedure eliminarArchivo(in id int)
	begin
		delete from archivo
        where archivo.id = id;
    end$$
delimiter ;

drop procedure if exists getP;
delimiter $$
create procedure getP(in id int)
	begin
		select anuncio.* from anuncio
        where ANUNCIO.id = id;
    end$$
delimiter ;

drop procedure if exists getPA;
delimiter $$
create procedure getPA(in id int)
	begin
		select archivo.* from archivo
        where archivo.id = id;
    end$$
delimiter ;

drop procedure if exists getNP;
delimiter $$
create procedure getNP(in id int)
	begin
		select anuncio.* from anuncio
        where ANUNCIO.id = id;
    end$$
delimiter ;

drop procedure if exists getNPA;
delimiter $$
create procedure getNPA(in id int)
	begin
		select archivo.* from archivo
        where archivo.id = id;
    end$$
delimiter ;

								    
grant all privileges on AnunciosITCM.*
to 'admin1'@'localhost'
identified by '1234';


#Validación de contraseñas#############################################################################################
drop procedure if exists CambContraseña;
delimiter $$
	create procedure CambContraseña(in usuario varchar(50), in contra varchar(25))
    begin
		 update CONTRASEÑA set CONTRASEÑA.contraseña=contra where CONTRASEÑA.usuario=usuario;
    end$$
delimiter ;

drop procedure if exists ValContraseñaAdmin1;
delimiter $$
	create procedure ValContraseñaAdmin1(in usuario varchar(50), in contra varchar(25))
    begin
		 select * from CONTRASEÑA where CONTRASEÑA.usuario='Admin1' and CONTRASEÑA.contraseña='Admin';
    end$$
delimiter ;

drop procedure if exists ValContraseñaAdmin2;
delimiter $$
	create procedure ValContraseñaAdmin2(in usuario varchar(50), in contra varchar(25))
    begin
		 select * from CONTRASEÑA where CONTRASEÑA.usuario='Admin2' and CONTRASEÑA.contraseña='Admin2';
    end$$
delimiter ;

-- #USUARIOS & CONTRASEÑAS#########################################################################################--

drop procedure if exists IdentificarUsr;
-- Busca a un usr por su contraseña, y de no encontrarlo devuelve un mensaje de error
delimiter $$
create procedure IdentificarUsr(in contra varchar(25))
	begin
    IF EXISTS (Select CONTRASEÑA.usuario from CONTRASEÑA where CONTRASEÑA.contraseña = contra) THEN
		Select CONTRASEÑA.usuario from CONTRASEÑA
        where CONTRASEÑA.contraseña = contra;
    ELSE
		Select 'Contraseña incorrecta, por favor intente de nuevo.';
    END IF;
    end $$
delimiter ;
