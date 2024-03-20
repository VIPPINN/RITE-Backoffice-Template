
------ Usuario ----------------------------------------------------------------------------

CREATE TABLE GrupoUsuario (
  id int IDENTITY(1,1) NOT NULL,
  descripcion varchar(255) NOT NULL,
  PRIMARY KEY (id)
)

SET IDENTITY_INSERT GrupoUsuario ON
INSERT INTO GrupoUsuario (id,descripcion) VALUES (1,'OA');
INSERT INTO GrupoUsuario (id,descripcion) VALUES (2,'Entidad');
INSERT INTO GrupoUsuario (id,descripcion) VALUES (3,'ONC');
INSERT INTO GrupoUsuario (id,descripcion) VALUES (4,'Unidad Contratacion');
INSERT INTO GrupoUsuario (id,descripcion) VALUES (5,'Delegado');
SET IDENTITY_INSERT GrupoUsuario OFF

CREATE TABLE TipoPersona (
  id int IDENTITY(1,1) NOT NULL,
  descripcion varchar(255) NOT NULL,
  PRIMARY KEY (id)
)

SET IDENTITY_INSERT TipoPersona ON
INSERT INTO TipoPersona (id,descripcion) VALUES (1,'FISICA');
INSERT INTO TipoPersona (id,descripcion) VALUES (2,'JURIDICA');
SET IDENTITY_INSERT TipoPersona OFF

/*
DROP TABLE UsuarioDelegado;
DROP TABLE Usuario;
*/

CREATE TABLE Usuario (
  id int IDENTITY(1,1) NOT NULL,
  idUsuarioQueDelega int,
  CUIT bigint NOT NULL,
  email varchar(255),
  idTipoPersona int NOT NULL,
  nombre varchar(255),
  apellido varchar(255),
  razonSocial varchar(255),
  idGrupoUsuario int NOT NULL,
  idClasificacionUltima int,
  fechaAlta date,
  fechaBaja date,
  PRIMARY KEY (id),
  FOREIGN KEY (idTipoPersona) REFERENCES TipoPersona(id),
  FOREIGN KEY (idUsuarioQueDelega) REFERENCES Usuario(id),
  FOREIGN KEY (idGrupoUsuario) REFERENCES GrupoUsuario(id)
)

CREATE TABLE UsuarioDelegado (
  id int IDENTITY(1,1) NOT NULL,
  idUsuarioQueDelega int NOT NULL,
  idUsuarioDelegado int NOT NULL,
  fechaAlta date,
  fechaBaja date,
  PRIMARY KEY (id),
  FOREIGN KEY (idUsuarioQueDelega) REFERENCES Usuario(id),
  FOREIGN KEY (idUsuarioDelegado) REFERENCES Usuario(id)
)

-- Clasificacion ----------------------------------------------------------------------

CREATE TABLE GrupoEntidad (
  id int IDENTITY(1,1) NOT NULL,
  orden int,
  descripcion varchar(255) NOT NULL,
  PRIMARY KEY (id)
)

SET IDENTITY_INSERT GrupoEntidad ON
INSERT INTO GrupoEntidad (id,orden,descripcion) VALUES (1,1,'Empresa');
INSERT INTO GrupoEntidad (id,orden,descripcion) VALUES (2,2,'ECPE');
INSERT INTO GrupoEntidad (id,orden,descripcion) VALUES (3,3,'Cooperativa');
SET IDENTITY_INSERT GrupoEntidad OFF

CREATE TABLE TipoEntidad (
  id int IDENTITY(1,1) NOT NULL,
  idGrupoEntidad int NOT NULL,
  orden int,
  descripcion varchar(255) NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (idGrupoEntidad) REFERENCES GrupoEntidad(id)
)

SET IDENTITY_INSERT TipoEntidad ON
INSERT INTO TipoEntidad (id,orden,idGrupoEntidad,descripcion) VALUES (1,1,1,'Empresa');
INSERT INTO TipoEntidad (id,orden,idGrupoEntidad,descripcion) VALUES (2,2,1,'...');
INSERT INTO TipoEntidad (id,orden,idGrupoEntidad,descripcion) VALUES (3,3,2,'Sociedad con participacion Estatal');
INSERT INTO TipoEntidad (id,orden,idGrupoEntidad,descripcion) VALUES (4,4,2,'SAPEM');
INSERT INTO TipoEntidad (id,orden,idGrupoEntidad,descripcion) VALUES (5,5,2,'...');
INSERT INTO TipoEntidad (id,orden,idGrupoEntidad,descripcion) VALUES (6,6,3,'Cooperativa');
SET IDENTITY_INSERT TipoEntidad OFF

CREATE TABLE CategoriaEntidad (
  id int IDENTITY(1,1) NOT NULL,
  orden int,
  descripcion varchar(255) NOT NULL,
  PRIMARY KEY (id)
)

SET IDENTITY_INSERT CategoriaEntidad ON
INSERT INTO CategoriaEntidad (id,orden,descripcion) VALUES (1,1,'Micro/Pequeña');
INSERT INTO CategoriaEntidad (id,orden,descripcion) VALUES (2,2,'Mediana');
INSERT INTO CategoriaEntidad (id,orden,descripcion) VALUES (3,3,'Grande');
SET IDENTITY_INSERT CategoriaEntidad OFF

CREATE TABLE ActividadEntidad (
  id int IDENTITY(1,1) NOT NULL,
  orden int,
  descripcion varchar(255) NOT NULL,
  PRIMARY KEY (id)
)

SET IDENTITY_INSERT ActividadEntidad ON
INSERT INTO ActividadEntidad (id,orden,descripcion) VALUES (1,1,'Construccion');
INSERT INTO ActividadEntidad (id,orden,descripcion) VALUES (2,2,'Servicios');
INSERT INTO ActividadEntidad (id,orden,descripcion) VALUES (3,3,'Comercio');
INSERT INTO ActividadEntidad (id,orden,descripcion) VALUES (4,4,'Industria y Mineria')
INSERT INTO ActividadEntidad (id,orden,descripcion) VALUES (5,5,'Acropecuaria');
SET IDENTITY_INSERT ActividadEntidad OFF

/*
DROP TABLE Clasificacion;
DROP TABLE RangoVenta;
DROP TABLE RangoPersonal;
DROP TABLE SEPyME;
*/

CREATE TABLE SEPyME (
  id int IDENTITY(1,1) NOT NULL,
  descripcion varchar(255),
  FechaAlta date,
  FechaBaja date,
  PRIMARY KEY (id)
)

SET IDENTITY_INSERT SEPyME ON
INSERT INTO SEPyME(id,descripcion,fechaAlta) VALUES (1,'Resolución 69/2020 (RESOL-2020-69-APN-SPYMEYE#MDP) 22/06/2020','2022-01-01');
SET IDENTITY_INSERT SEPyME OFF

CREATE TABLE RangoVenta (
  id int IDENTITY(1,1) NOT NULL,
  idSEPyME int NOT NULL,
  idGrupoEntidad int NOT NULL,
  idCategoriaEntidad int NOT NULL,
  idActividadEntidad int NOT NULL,
  limiteVentaTotalAnualInicial bigint NOT NULL,
  limiteVentaTotalAnualFinal bigint,
  PRIMARY KEY (id),
  FOREIGN KEY (idSEPyME) REFERENCES SEPyME(id),
  FOREIGN KEY (idGrupoEntidad) REFERENCES GrupoEntidad(id),
  FOREIGN KEY (idCategoriaEntidad) REFERENCES CategoriaEntidad(id),
  FOREIGN KEY (idActividadEntidad) REFERENCES ActividadEntidad(id)
)

SET IDENTITY_INSERT RangoVenta ON
-- Construccion
INSERT INTO RangoVenta (id,idSepyme,idGrupoEntidad,idCategoriaEntidad,idActividadEntidad,limiteVentaTotalAnualInicial,limiteVentaTotalAnualFinal) VALUES (  1, 1, 1, 1, 1,         0, 115370000);
INSERT INTO RangoVenta (id,idSepyme,idGrupoEntidad,idCategoriaEntidad,idActividadEntidad,limiteVentaTotalAnualInicial,limiteVentaTotalAnualFinal) VALUES (  2, 1, 1, 2, 1, 115370001, 965460000);
INSERT INTO RangoVenta (id,idSepyme,idGrupoEntidad,idCategoriaEntidad,idActividadEntidad,limiteVentaTotalAnualInicial,limiteVentaTotalAnualFinal) VALUES (  3, 1, 1, 3, 1, 965460001,      null);
-- Servicios
INSERT INTO RangoVenta (id,idSepyme,idGrupoEntidad,idCategoriaEntidad,idActividadEntidad,limiteVentaTotalAnualInicial,limiteVentaTotalAnualFinal) VALUES (  4, 1, 1, 1, 2,         0,  59710000);
INSERT INTO RangoVenta (id,idSepyme,idGrupoEntidad,idCategoriaEntidad,idActividadEntidad,limiteVentaTotalAnualInicial,limiteVentaTotalAnualFinal) VALUES (  5, 1, 1, 2, 2,  59710001, 705790000);
INSERT INTO RangoVenta (id,idSepyme,idGrupoEntidad,idCategoriaEntidad,idActividadEntidad,limiteVentaTotalAnualInicial,limiteVentaTotalAnualFinal) VALUES (  6, 1, 1, 3, 2, 705790001,      null);
-- Comercio
INSERT INTO RangoVenta (id,idSepyme,idGrupoEntidad,idCategoriaEntidad,idActividadEntidad,limiteVentaTotalAnualInicial,limiteVentaTotalAnualFinal) VALUES ( 7, 1, 1, 1, 3,         0, 247200000);
INSERT INTO RangoVenta (id,idSepyme,idGrupoEntidad,idCategoriaEntidad,idActividadEntidad,limiteVentaTotalAnualInicial,limiteVentaTotalAnualFinal) VALUES ( 8, 1, 1, 2, 3, 247200001,2602540000);
INSERT INTO RangoVenta (id,idSepyme,idGrupoEntidad,idCategoriaEntidad,idActividadEntidad,limiteVentaTotalAnualInicial,limiteVentaTotalAnualFinal) VALUES ( 9, 1, 1, 3, 3,2602540001,      null);
-- Industria y Mineria
INSERT INTO RangoVenta (id,idSepyme,idGrupoEntidad,idCategoriaEntidad,idActividadEntidad,limiteVentaTotalAnualInicial,limiteVentaTotalAnualFinal) VALUES ( 10, 1, 1, 1, 4,         0, 243290000);
INSERT INTO RangoVenta (id,idSepyme,idGrupoEntidad,idCategoriaEntidad,idActividadEntidad,limiteVentaTotalAnualInicial,limiteVentaTotalAnualFinal) VALUES ( 11, 1, 1, 2, 4, 243290001,2540380000);
INSERT INTO RangoVenta (id,idSepyme,idGrupoEntidad,idCategoriaEntidad,idActividadEntidad,limiteVentaTotalAnualInicial,limiteVentaTotalAnualFinal) VALUES ( 12, 1, 1, 3, 4,2540380001,      null);
-- Agropecuario
INSERT INTO RangoVenta (id,idSepyme,idGrupoEntidad,idCategoriaEntidad,idActividadEntidad,limiteVentaTotalAnualInicial,limiteVentaTotalAnualFinal) VALUES ( 13, 1, 1, 1, 5,         0,  71960000);
INSERT INTO RangoVenta (id,idSepyme,idGrupoEntidad,idCategoriaEntidad,idActividadEntidad,limiteVentaTotalAnualInicial,limiteVentaTotalAnualFinal) VALUES ( 14, 1, 1, 2, 5,  71960000, 676810000);
INSERT INTO RangoVenta (id,idSepyme,idGrupoEntidad,idCategoriaEntidad,idActividadEntidad,limiteVentaTotalAnualInicial,limiteVentaTotalAnualFinal) VALUES ( 15, 1, 1, 3, 5, 676810001,      null);
SET IDENTITY_INSERT RangoVenta OFF

SET IDENTITY_INSERT RangoVenta ON
INSERT INTO RangoVenta (id,idSepyme,idGrupoEntidad,idCategoriaEntidad,idActividadEntidad,limiteVentaTotalAnualInicial,limiteVentaTotalAnualFinal) SELECT id + 15,idSEPyME,2,idCategoriaEntidad,idActividadEntidad,limiteVentaTotalAnualInicial,limiteVentaTotalAnualFinal FROM RangoVenta WHERE idGrupoEntidad = 1;
INSERT INTO RangoVenta (id,idSepyme,idGrupoEntidad,idCategoriaEntidad,idActividadEntidad,limiteVentaTotalAnualInicial,limiteVentaTotalAnualFinal) SELECT id + 30,idSEPyME,3,idCategoriaEntidad,idActividadEntidad,limiteVentaTotalAnualInicial,limiteVentaTotalAnualFinal FROM RangoVenta WHERE idGrupoEntidad = 1;
SET IDENTITY_INSERT RangoVenta OFF

CREATE TABLE RangoPersonal(
  id int IDENTITY(1,1) NOT NULL,
  idSEPyME int NOT NULL,
  idGrupoEntidad int NOT NULL,
  idCategoriaEntidad int NOT NULL,
  idActividadEntidad int NOT NULL,
  limitePersonalOcupadoInicial int NOT NULL,
  limitePersonalOcupadoFinal int,
  PRIMARY KEY (id),
  FOREIGN KEY (idSEPyME) REFERENCES SEPyME(id),
  FOREIGN KEY (idGrupoEntidad) REFERENCES GrupoEntidad(id),
  FOREIGN KEY (idCategoriaEntidad) REFERENCES CategoriaEntidad(id),
  FOREIGN KEY (idActividadEntidad) REFERENCES ActividadEntidad(id)
)

SET IDENTITY_INSERT RangoPersonal ON
-- Construccion
INSERT INTO RangoPersonal (id,idSepyme,idGrupoEntidad,idCategoriaEntidad,idActividadEntidad,limitePersonalOcupadoInicial,limitePersonalOcupadoFinal) VALUES (  1, 1, 1, 1, 1,   0,   45);
INSERT INTO RangoPersonal (id,idSepyme,idGrupoEntidad,idCategoriaEntidad,idActividadEntidad,limitePersonalOcupadoInicial,limitePersonalOcupadoFinal) VALUES (  2, 1, 1, 2, 1,  46,  590);
INSERT INTO RangoPersonal (id,idSepyme,idGrupoEntidad,idCategoriaEntidad,idActividadEntidad,limitePersonalOcupadoInicial,limitePersonalOcupadoFinal) VALUES (  3, 1, 1, 3, 1, 591, null);
-- Servicios
INSERT INTO RangoPersonal (id,idSepyme,idGrupoEntidad,idCategoriaEntidad,idActividadEntidad,limitePersonalOcupadoInicial,limitePersonalOcupadoFinal) VALUES (  4, 1, 1, 1, 2,   0,   30);
INSERT INTO RangoPersonal (id,idSepyme,idGrupoEntidad,idCategoriaEntidad,idActividadEntidad,limitePersonalOcupadoInicial,limitePersonalOcupadoFinal) VALUES (  5, 1, 1, 2, 2,  31,  535);
INSERT INTO RangoPersonal (id,idSepyme,idGrupoEntidad,idCategoriaEntidad,idActividadEntidad,limitePersonalOcupadoInicial,limitePersonalOcupadoFinal) VALUES (  6, 1, 1, 3, 2, 536, null);
-- Comercio
INSERT INTO RangoPersonal (id,idSepyme,idGrupoEntidad,idCategoriaEntidad,idActividadEntidad,limitePersonalOcupadoInicial,limitePersonalOcupadoFinal) VALUES (  7, 1, 1, 1, 3,   0,   35);
INSERT INTO RangoPersonal (id,idSepyme,idGrupoEntidad,idCategoriaEntidad,idActividadEntidad,limitePersonalOcupadoInicial,limitePersonalOcupadoFinal) VALUES (  8, 1, 1, 2, 3,  36,  345);
INSERT INTO RangoPersonal (id,idSepyme,idGrupoEntidad,idCategoriaEntidad,idActividadEntidad,limitePersonalOcupadoInicial,limitePersonalOcupadoFinal) VALUES (  9, 1, 1, 3, 3, 346, null);
-- Industria y Mineria
INSERT INTO RangoPersonal (id,idSepyme,idGrupoEntidad,idCategoriaEntidad,idActividadEntidad,limitePersonalOcupadoInicial,limitePersonalOcupadoFinal) VALUES ( 10, 1, 1, 1, 4,   0,   60);
INSERT INTO RangoPersonal (id,idSepyme,idGrupoEntidad,idCategoriaEntidad,idActividadEntidad,limitePersonalOcupadoInicial,limitePersonalOcupadoFinal) VALUES ( 11, 1, 1, 2, 4,  61,  655);
INSERT INTO RangoPersonal (id,idSepyme,idGrupoEntidad,idCategoriaEntidad,idActividadEntidad,limitePersonalOcupadoInicial,limitePersonalOcupadoFinal) VALUES ( 12, 1, 1, 3, 4, 656, null);
-- Agropecuario
INSERT INTO RangoPersonal (id,idSepyme,idGrupoEntidad,idCategoriaEntidad,idActividadEntidad,limitePersonalOcupadoInicial,limitePersonalOcupadoFinal) VALUES ( 13, 1, 1, 1, 5,   0,   10);
INSERT INTO RangoPersonal (id,idSepyme,idGrupoEntidad,idCategoriaEntidad,idActividadEntidad,limitePersonalOcupadoInicial,limitePersonalOcupadoFinal) VALUES ( 14, 1, 1, 2, 5,  11,  215);
INSERT INTO RangoPersonal (id,idSepyme,idGrupoEntidad,idCategoriaEntidad,idActividadEntidad,limitePersonalOcupadoInicial,limitePersonalOcupadoFinal) VALUES ( 15, 1, 1, 3, 5, 216, null);
SET IDENTITY_INSERT RangoPersonal OFF

SET IDENTITY_INSERT RangoPersonal ON
INSERT INTO RangoPersonal (id,idSepyme,idGrupoEntidad,idCategoriaEntidad,idActividadEntidad,limitePersonalOcupadoInicial,limitePersonalOcupadoFinal) SELECT id + 15,idSEPyME,2,idCategoriaEntidad,idActividadEntidad,limitePersonalOcupadoInicial,limitePersonalOcupadoFinal FROM RangoPersonal WHERE idGrupoEntidad = 1;
INSERT INTO RangoPersonal (id,idSepyme,idGrupoEntidad,idCategoriaEntidad,idActividadEntidad,limitePersonalOcupadoInicial,limitePersonalOcupadoFinal) SELECT id + 30,idSEPyME,3,idCategoriaEntidad,idActividadEntidad,limitePersonalOcupadoInicial,limitePersonalOcupadoFinal FROM RangoPersonal WHERE idGrupoEntidad = 1;
SET IDENTITY_INSERT RangoPersonal OFF


CREATE TABLE Clasificacion (
  id int IDENTITY(1,1) NOT NULL,
  idUsuario int NOT NULL,
  idGrupoEntidad int,
  idTipoEntidad int,
  idActividadEntidad int,
  idRangoVenta int,
  idRangoPersonal int,
  idCategoriaEntidad int,
  fechaAlta date,
  fechaBaja date,
  PRIMARY KEY (id),
  FOREIGN KEY (idUsuario) REFERENCES Usuario(id),
  FOREIGN KEY (idGrupoEntidad) REFERENCES GrupoEntidad(id),
  FOREIGN KEY (idTipoEntidad) REFERENCES TipoEntidad(id),
  FOREIGN KEY (idActividadEntidad) REFERENCES ActividadEntidad(id),
  FOREIGN KEY (idRangoVenta) REFERENCES RangoVenta(id),
  FOREIGN KEY (idRangoPersonal) REFERENCES RangoPersonal(id),
  FOREIGN KEY (idCategoriaEntidad) REFERENCES CategoriaEntidad(id)
)

-- Cuestionario -----------------------------------------------------------------------

CREATE TABLE Cuestionario (
  id int IDENTITY(1,1) NOT NULL,
  descripcion varchar(255) NOT NULL,
  PRIMARY KEY (id)
)

SET IDENTITY_INSERT Cuestionario ON
INSERT INTO Cuestionario (id,descripcion) VALUES (1,'Programa Integidad');
INSERT INTO Cuestionario (id,descripcion) VALUES (2,'Debida Diligencia');
SET IDENTITY_INSERT Cuestionario OFF

CREATE TABLE CuestionarioVersion (
  id int IDENTITY(1,1) NOT NULL,
  idCuestionario int NOT NULL,
  descripcion varchar(255) NOT NULL,
  fechaAlta date,
  fechaBaja date,
  PRIMARY KEY(id)
)

SET IDENTITY_INSERT CuestionarioVersion ON
INSERT INTO CuestionarioVersion (id,idCuestionario,descripcion,fechaAlta) VALUES (1,1,'Version 1.0','2022-01-01');
INSERT INTO CuestionarioVersion (id,idCuestionario,descripcion,fechaAlta) VALUES (2,2,'Version 1.0','2022-01-01');
SET IDENTITY_INSERT CuestionarioVersion OFF

-- Pregunta ---------------------------------------------------------------------------

/*
DROP TABLE Tema;
*/
CREATE TABLE Tema (
  id int IDENTITY(1,1) NOT NULL,
  idCuestionarioVersion int NOT NULL,
  orden int,
  descripcion varchar(255) NOT NULL,
  PRIMARY KEY(id),
  FOREIGN KEY (idCuestionarioVersion) REFERENCES CuestionarioVersion(id)
)

SET IDENTITY_INSERT Tema ON
INSERT INTO Tema (id,idCuestionarioVersion,orden,descripcion) VALUES (1,1,1,'Evaluación de Riesgos');
INSERT INTO Tema (id,idCuestionarioVersion,orden,descripcion) VALUES (2,1,2,'Políticas y Procedimientos');
INSERT INTO Tema (id,idCuestionarioVersion,orden,descripcion) VALUES (3,1,3,'Capacitación y Comunicación');
INSERT INTO Tema (id,idCuestionarioVersion,orden,descripcion) VALUES (4,1,4,'Compromiso de la Alta Dirección');
INSERT INTO Tema (id,idCuestionarioVersion,orden,descripcion) VALUES (5,1,5,'Función de Cumplimiento');
INSERT INTO Tema (id,idCuestionarioVersion,orden,descripcion) VALUES (6,1,6,'Incentivos y Medidas disciplinarias');
INSERT INTO Tema (id,idCuestionarioVersion,orden,descripcion) VALUES (7,1,7,'Debida diligencia hacia terceras partes');
INSERT INTO Tema (id,idCuestionarioVersion,orden,descripcion) VALUES (8,1,8,'Debida Diligencia en Procesos de Transformación Societaria');
INSERT INTO Tema (id,idCuestionarioVersion,orden,descripcion) VALUES (9,1,9,'Gestión del Canal de Integridad');
INSERT INTO Tema (id,idCuestionarioVersion,orden,descripcion) VALUES (10,1,10,'Mejora continua, pruebas periódicas y revisión');
INSERT INTO Tema (id,idCuestionarioVersion,orden,descripcion) VALUES (11,1,11,'Investigación interna');
INSERT INTO Tema (id,idCuestionarioVersion,orden,descripcion) VALUES (21,2,1,'Debida diligencia');
INSERT INTO Tema (id,idCuestionarioVersion,orden,descripcion) VALUES (22,2,2,'Antecedentes judiciales y acciones de remediación'); 
SET IDENTITY_INSERT Tema OFF


CREATE TABLE TipoPregunta (
  id int IDENTITY(1,1) NOT NULL,
  orden int,
  descripcion varchar(255) NOT NULL,
  PRIMARY KEY (id)
)

SET IDENTITY_INSERT TipoPregunta ON
INSERT INTO TipoPregunta (id,orden,descripcion) VALUES (1,1,'Dicotómica');
INSERT INTO TipoPregunta (id,orden,descripcion) VALUES (2,2,'Tricotómica');
INSERT INTO TipoPregunta (id,orden,descripcion) VALUES (3,3,'Respuesta única');
INSERT INTO TipoPregunta (id,orden,descripcion) VALUES (4,4,'Respuesta múltiple');
INSERT INTO TipoPregunta (id,orden,descripcion) VALUES (5,5,'Fecha calendario');
INSERT INTO TipoPregunta (id,orden,descripcion) VALUES (6,6,'Texto Libre');
SET IDENTITY_INSERT TipoPregunta OFF

CREATE TABLE Nivel (
  id int IDENTITY(1,1) NOT NULL,
  orden int,
  descripcion varchar(255) NOT NULL,
  PRIMARY KEY (id)
)

SET IDENTITY_INSERT Nivel ON
INSERT INTO Nivel (id,orden,descripcion) VALUES (1,1,'Moderado');
INSERT INTO Nivel (id,orden,descripcion) VALUES (2,2,'Medio');
INSERT INTO Nivel (id,orden,descripcion) VALUES (3,3,'Avanzado');
SET IDENTITY_INSERT Nivel OFF

/*
DROP TABLE PreguntaNivel;
DROP TABLE PreguntaOpcion;
DROP TABLE Pregunta;
*/
CREATE TABLE Pregunta (
  id int IDENTITY(1,1) NOT NULL,
  idCuestionarioVersion int NOT NULL,
  numero int NOT NULL,
  idPreguntaPadre int,
  idTema int NOT NULL,
  pregunta varchar(8000) NOT NULL,
  idTipoPregunta int NOT NULL,
  respuestaDisparadorSubpregunta varchar(10),
  impactoNivelAvance bit NOT NULL,
  requiereEvidencia varchar(10),
  opcionesSugeridas varchar(8000),
  cantidadMesesVencimiento int,
  fechaAlta date,
  fechaBaja date,
  PRIMARY KEY (id),
  FOREIGN KEY (idCuestionarioVersion) REFERENCES CuestionarioVersion(id),
  FOREIGN KEY (idPreguntaPadre) REFERENCES Pregunta(id),
  FOREIGN KEY (idTema) REFERENCES Tema(id),
  FOREIGN KEY (idTipoPregunta) REFERENCES TipoPregunta(id)
)

--DROP INDEX Pregunta_i1 ON Pregunta;
CREATE UNIQUE INDEX Pregunta_i1 ON Pregunta(idCuestionarioVersion,numero);


CREATE TABLE PreguntaOpcion (
  id int IDENTITY(1,1) NOT NULL,
  idPregunta int NOT NULL,
  orden int,
  descripcion varchar(1000),
  PRIMARY KEY (id),
  FOREIGN KEY (idPregunta) REFERENCES Pregunta(id)
)

CREATE TABLE PreguntaNivel (
  id int IDENTITY(1,1) NOT NULL,
  idPregunta int NOT NULL,
  idGrupoEntidad int NOT NULL,
  idCategoriaEntidad int NOT NULL,
  idNivel int NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (idPregunta) REFERENCES Pregunta(id),
  FOREIGN KEY (idGrupoEntidad) REFERENCES GrupoEntidad(id),
  FOREIGN KEY (idCategoriaEntidad) REFERENCES CategoriaEntidad(id),
  FOREIGN KEY (idNivel) REFERENCES Nivel(id)
)


-- Presentacion -----------------------------------------------------------------------
/*
DROP TABLE Adjunto;
DROP TABLE Respuesta;
DROP TABLE Presentacion;
*/

CREATE TABLE EstadoPresentacion (
  id int IDENTITY(1,1) NOT NULL,
  orden int,
  descripcion varchar(255),
  PRIMARY KEY (id)
)

SET IDENTITY_INSERT EstadoPresentacion ON
INSERT INTO EstadoPresentacion (id,orden,descripcion) VALUES (1,1,'Borrador');
INSERT INTO EstadoPresentacion (id,orden,descripcion) VALUES (2,2,'Presentado');
SET IDENTITY_INSERT EstadoPresentacion OFF

CREATE TABLE Presentacion (
  id int IDENTITY(1,1) NOT NULL,
  idUsuario int NOT NULL,
  idEstadoPresentacion int NOT NULL,
  fechaEstado date NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (idUsuario) REFERENCES Usuario(id),
  FOREIGN KEY (idEstadoPresentacion) REFERENCES EstadoPresentacion(id)
)

CREATE TABLE Respuesta (
  id int IDENTITY(1,1) NOT NULL,
  idPresentacion int NOT NULL,
  idPregunta int NOT NULL,
  valorNumerico int,
  ValorFecha date,
  valorTexto varchar(8000),
  PRIMARY KEY (id),
  FOREIGN KEY (idPresentacion) REFERENCES Presentacion(id),
  FOREIGN KEY (idPregunta) REFERENCES Pregunta(id)
)

CREATE TABLE Adjunto (
  id int IDENTITY(1,1) NOT NULL,
  idRespuesta int NOT NULL,
  pathAdjunto varchar(1000) NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (idRespuesta) REFERENCES Respuesta(id)
)





