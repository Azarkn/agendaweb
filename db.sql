-- db.sql · AgendaWeb · esquema desde CERO (versión P8)
-- Si ya tienes datos, NO uses este: usa migracion_p8.sql
CREATE DATABASE IF NOT EXISTS agenda CHARACTER SET utf8mb4;
USE agenda;

CREATE TABLE IF NOT EXISTS usuarios (
  id         INT AUTO_INCREMENT PRIMARY KEY,
  nombre     VARCHAR(80)  NOT NULL,
  correo     VARCHAR(120) NOT NULL UNIQUE,
  clave_hash VARCHAR(255) NOT NULL,
  creado_en  DATETIME     DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS eventos (
  id          INT AUTO_INCREMENT PRIMARY KEY,
  usuario_id  INT          NOT NULL,
  titulo      VARCHAR(120) NOT NULL,
  fecha       DATE         NOT NULL,
  hora        TIME         NULL,
  categoria   VARCHAR(20)  NOT NULL,
  descripcion VARCHAR(500) NULL,
  creado_en   TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_eventos_usuario
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
    ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;