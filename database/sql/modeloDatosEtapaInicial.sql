-- table users    
CREATE TABLE users(
	id bigint IDENTITY(1,1) NOT NULL,
	name varchar(255) NOT NULL,
	email varchar(255) NOT NULL,
	email_verified_at datetime NULL,
	password varchar(255) NOT NULL,
	remember_token varchar(100) NULL,
	created_at datetime NULL,
	updated_at datetime NULL
	PRIMARY KEY (id)
)

-- table about
CREATE TABLE QueEsRite(
	id bigint IDENTITY(1,1) NOT NULL,
    titulo varchar(500) NOT NULL,
	descripcionLarga varchar(8000) NOT NULL,
    descripcionCorta varchar(8000) NOT NULL,
    enlacePdf varchar(500),
    estado bit NOT NULL,
    fechaAlta date,
	fechaBaja date,
    PRIMARY KEY (id)
)
ALTER TABLE QueEsRite ADD  DEFAULT ('0') FOR estado


-- table faqs
CREATE TABLE PreguntaFrecuente(
	id bigint IDENTITY(1,1) NOT NULL,
    titulo varchar(500) NOT NULL,
	texto varchar(8000) NOT NULL,
    orden int NOT NULL,
    estado bit NOT NULL,
    fechaAlta date,
	fechaBaja date,
	PRIMARY KEY (id)
)
ALTER TABLE PreguntaFrecuente ADD  DEFAULT ('0') FOR estado


-- table home_videos
CREATE TABLE Video(
	id bigint IDENTITY(1,1) NOT NULL,
	titulo varchar(500) NOT NULL,
	enlace varchar(500),
	estado bit NOT NULL,
	fechaAlta date,
	fechaBaja date,
	PRIMARY KEY (id)
)
ALTER TABLE Video ADD  DEFAULT ('0') FOR estado


-- table HomeSlider
CREATE TABLE Carrusel(
	id bigint IDENTITY(1,1) NOT NULL,
	titulo varchar(500),
	enlace varchar(500),
	enlaceImagenPc varchar(500) NOT NULL,
	color varchar(255),
	orden int NOT NULL,
    estado bit NOT NULL,
    fechaAlta date,
	fechaBaja date,
	PRIMARY KEY (id)
)
ALTER TABLE Carrusel ADD  DEFAULT ('0') FOR estado


-- table news
CREATE TABLE Novedades(
	id bigint IDENTITY(1,1) NOT NULL,
	titulo varchar(500),
	slug varchar(500) NOT NULL,
	descripcionLarga varchar(8000) NOT NULL,
    descripcionCorta varchar(8000) NOT NULL,
	fechaPublicacion date NOT NULL,
	orden int NOT NULL,
	imagenPublicacion varchar(500) NOT NULL,
	estado bit NOT NULL,
    fechaAlta date,
	fechaBaja date,
	PRIMARY KEY (id)
)
ALTER TABLE Novedades ADD  DEFAULT ('0') FOR estado


-- table redes
CREATE TABLE RedSocial (
	id bigint IDENTITY(1,1) NOT NULL,
	titulo varchar(200) NOT NULL,
    enlace varchar(500) NOT NULL,
	logotipo varchar(500),
	estado bit NOT NULL,
    fechaAlta date,
	fechaBaja date
	PRIMARY KEY (id)
)
ALTER TABLE RedSocial ADD  DEFAULT ('0') FOR estado


-- table log_activities
CREATE TABLE LogDeActividad(
	id bigint IDENTITY(1,1) NOT NULL,
    titulo varchar(500),
	url varchar(500),
	metodo varchar(1000),
	ip varchar(255),
	agente varchar(1000),
	fechaAlta date,
    idUser bigint
	PRIMARY KEY (id)
    FOREIGN KEY (idUser) REFERENCES users(id)
)

-- =============================================================
-- ==== Sin Modificación por Standard del filtro utilizado =====
-- =============================================================


-- table orientadoRecurso
CREATE TABLE orientadoRecurso(
	id bigint IDENTITY(1,1) NOT NULL,
    titulo varchar(500) NOT NULL,
    descripcion varchar(8000) NOT NULL,
	estado bit NOT NULL,
    fechaAlta date,
	fechaBaja date
    PRIMARY KEY (id)
)
ALTER TABLE orientadoRecurso ADD  DEFAULT ('0') FOR estado


-- table tipoRecurso
CREATE TABLE tipoRecurso(
	id bigint IDENTITY(1,1) NOT NULL,
	titulo varchar(500) NOT NULL,
    descripcion varchar(8000) NOT NULL,
	estado bit NOT NULL,
    fechaAlta date,
	fechaBaja date,
    PRIMARY KEY (id)
)
ALTER TABLE tipoRecurso ADD  DEFAULT ('0') FOR estado
    

-- table origenRecurso
CREATE TABLE origenRecurso(
	id bigint IDENTITY(1,1) NOT NULL,
	titulo varchar(500) NOT NULL,
    descripcion varchar(8000) NOT NULL,
	estado bit NOT NULL,
    fechaAlta date,
	fechaBaja date,
    PRIMARY KEY (id)
)
ALTER TABLE origenRecurso ADD  DEFAULT ('0') FOR estado
    

-- table temaRecurso
CREATE TABLE temaRecurso(
	id bigint IDENTITY(1,1) NOT NULL,
	titulo varchar(500) NOT NULL,
    descripcion varchar(8000) NOT NULL,
	estado bit NOT NULL,
    fechaAlta date,
	fechaBaja date,
    PRIMARY KEY (id)
)
ALTER TABLE temaRecurso ADD  DEFAULT ('0') FOR estado

-- table recursos
CREATE TABLE recursos(
	id bigint IDENTITY(1,1) NOT NULL,
	titulo varchar(500) NOT NULL,
    descripcion varchar(8000) NOT NULL,
    enlaceDescarga varchar(1000) NOT NULL,
	idTipoRecurso bigint NOT NULL,
    idOrigenRecurso bigint NOT NULL,
    idTemaRecurso bigint NOT NULL,
	estado bit NOT NULL,
    fechaAlta date,
	fechaBaja date
    PRIMARY KEY (id),
    FOREIGN KEY (idTipoRecurso) REFERENCES tipoRecurso(id),
    FOREIGN KEY (idOrigenRecurso) REFERENCES origenRecurso(id),
    FOREIGN KEY (idTemaRecurso) REFERENCES temaRecurso(id),
)
ALTER TABLE recursos ADD  DEFAULT ('0') FOR estado

-- table orientado_recursos
CREATE TABLE orientado_recursos(
	id bigint IDENTITY(1,1) NOT NULL,
	idRecurso bigint NOT NULL,
	idOrientadoRecurso bigint NOT NULL,
	estado bit NOT NULL,
    fechaAlta date,
	fechaBaja date
    PRIMARY KEY (id),
	FOREIGN KEY (idRecurso) REFERENCES recursos(id),
    FOREIGN KEY (idOrientadoRecurso) REFERENCES orientadoRecurso(id)
)
ALTER TABLE orientado_recursos ADD  DEFAULT ('0') FOR estado