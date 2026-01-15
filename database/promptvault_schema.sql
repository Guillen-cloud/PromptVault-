/* =========================================================
   SCRIPT COMPLETO BASE DE DATOS: promptvault
   Compatible: MySQL / MariaDB
   ========================================================= */

-- 1️⃣ Crear base de datos
CREATE DATABASE IF NOT EXISTS promptvault
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

-- 2️⃣ Seleccionar base de datos
USE promptvault;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

START TRANSACTION;

-- =========================================================
-- TABLA: users
-- =========================================================
CREATE TABLE IF NOT EXISTS users (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL UNIQUE,
  email_verified_at TIMESTAMP NULL,
  password VARCHAR(255) NOT NULL,
  remember_token VARCHAR(100),
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL
) ENGINE=InnoDB;

-- =========================================================
-- TABLA: categorias
-- =========================================================
CREATE TABLE IF NOT EXISTS categorias (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(120) NOT NULL UNIQUE,
  descripcion TEXT,
  color VARCHAR(20),
  icono VARCHAR(60),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- =========================================================
-- TABLA: prompts
-- =========================================================
CREATE TABLE IF NOT EXISTS prompts (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id BIGINT UNSIGNED NOT NULL,
  categoria_id BIGINT UNSIGNED NOT NULL,
  titulo VARCHAR(180) NOT NULL,
  contenido LONGTEXT NOT NULL,
  descripcion TEXT,
  ia_destino VARCHAR(60) NOT NULL,
  es_favorito TINYINT(1) DEFAULT 0,
  es_publico TINYINT(1) DEFAULT 0,
  veces_usado INT UNSIGNED DEFAULT 0,
  version_actual INT UNSIGNED DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  CONSTRAINT fk_prompts_users FOREIGN KEY (user_id)
    REFERENCES users(id) ON DELETE CASCADE,

  CONSTRAINT fk_prompts_categorias FOREIGN KEY (categoria_id)
    REFERENCES categorias(id)
) ENGINE=InnoDB;

-- =========================================================
-- TABLA: etiquetas
-- =========================================================
CREATE TABLE IF NOT EXISTS etiquetas (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(80) NOT NULL UNIQUE,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- =========================================================
-- TABLA: prompt_tag (N:N)
-- =========================================================
CREATE TABLE IF NOT EXISTS prompt_tag (
  prompt_id BIGINT UNSIGNED NOT NULL,
  tag_id BIGINT UNSIGNED NOT NULL,
  PRIMARY KEY (prompt_id, tag_id),

  CONSTRAINT fk_prompt_tag_prompt FOREIGN KEY (prompt_id)
    REFERENCES prompts(id) ON DELETE CASCADE,

  CONSTRAINT fk_prompt_tag_tag FOREIGN KEY (tag_id)
    REFERENCES etiquetas(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- =========================================================
-- TABLA: compartidos
-- =========================================================
CREATE TABLE IF NOT EXISTS compartidos (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  prompt_id BIGINT UNSIGNED NOT NULL,
  nombre_destinatario VARCHAR(140) NOT NULL,
  email_destinatario VARCHAR(160) NOT NULL,
  fecha_compartido DATETIME NOT NULL,
  notas TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  CONSTRAINT fk_compartidos_prompt FOREIGN KEY (prompt_id)
    REFERENCES prompts(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- =========================================================
-- TABLA: actividades
-- =========================================================
CREATE TABLE IF NOT EXISTS actividades (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id BIGINT UNSIGNED NOT NULL,
  prompt_id BIGINT UNSIGNED DEFAULT NULL,
  accion VARCHAR(40) NOT NULL,
  descripcion TEXT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

  CONSTRAINT fk_actividades_user FOREIGN KEY (user_id)
    REFERENCES users(id) ON DELETE CASCADE,

  CONSTRAINT fk_actividades_prompt FOREIGN KEY (prompt_id)
    REFERENCES prompts(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- =========================================================
-- TABLA: versiones
-- =========================================================
CREATE TABLE IF NOT EXISTS versiones (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  prompt_id BIGINT UNSIGNED NOT NULL,
  numero_version INT UNSIGNED NOT NULL,
  contenido_anterior LONGTEXT NOT NULL,
  motivo_cambio VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

  UNIQUE KEY uk_version_prompt_num (prompt_id, numero_version),

  CONSTRAINT fk_versiones_prompt FOREIGN KEY (prompt_id)
    REFERENCES prompts(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- =========================================================
-- DATOS INICIALES
-- =========================================================
INSERT INTO categorias (nombre, descripcion, color, icono)
VALUES 
  ('Desarrollo', 'Prompts relacionados con programación y desarrollo de software', '#2563eb', 'code'),
  ('Diseño', 'Prompts para diseño UI/UX y creatividad visual', '#10b981', 'palette'),
  ('Marketing', 'Prompts para estrategias de marketing y contenido', '#f97316', 'bullhorn'),
  ('Análisis', 'Prompts para análisis de datos y reportes', '#8b5cf6', 'chart-bar')
ON DUPLICATE KEY UPDATE nombre = nombre;

INSERT INTO etiquetas (nombre)
VALUES 
  ('SQL'), ('Python'), ('React'), ('Testing'), 
  ('UX/UI'), ('Backend'), ('Frontend'), ('DevOps')
ON DUPLICATE KEY UPDATE nombre = nombre;

-- Usuario demo
INSERT INTO users (name, email, password, created_at, updated_at)
VALUES ('Usuario Demo', 'demo@promptvault.com', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NOW(), NOW())
ON DUPLICATE KEY UPDATE name = name;

COMMIT;
