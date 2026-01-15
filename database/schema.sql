-- ==========================================
-- USUARIOS (Laravel default - Breeze)
-- ==========================================
CREATE TABLE users (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL UNIQUE,
  email_verified_at TIMESTAMP NULL,
  password VARCHAR(255) NOT NULL,
  remember_token VARCHAR(100) NULL,
  created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ==========================
-- CATEGORIAS
-- ==========================
CREATE TABLE categorias (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(120) NOT NULL UNIQUE,
  descripcion TEXT NULL,
  color VARCHAR(20) NULL,
  icono VARCHAR(60) NULL,
  created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ==========================
-- PROMPTS
-- ==========================
CREATE TABLE prompts (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id BIGINT UNSIGNED NOT NULL,
  categoria_id BIGINT UNSIGNED NOT NULL,

  titulo VARCHAR(180) NOT NULL,
  contenido LONGTEXT NOT NULL,
  descripcion TEXT NULL,

  ia_destino VARCHAR(60) NOT NULL,

  es_favorito TINYINT(1) NOT NULL DEFAULT 0,
  es_publico TINYINT(1) NOT NULL DEFAULT 0,

  veces_usado INT UNSIGNED NOT NULL DEFAULT 0,
  version_actual INT UNSIGNED NOT NULL DEFAULT 1,

  created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  CONSTRAINT fk_prompts_users
    FOREIGN KEY (user_id) REFERENCES users(id)
    ON DELETE CASCADE,

  CONSTRAINT fk_prompts_categorias
    FOREIGN KEY (categoria_id) REFERENCES categorias(id)
    ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE INDEX idx_prompts_user ON prompts(user_id);
CREATE INDEX idx_prompts_categoria ON prompts(categoria_id);
CREATE INDEX idx_prompts_ia ON prompts(ia_destino);
CREATE INDEX idx_prompts_favorito ON prompts(es_favorito);
CREATE INDEX idx_prompts_publico ON prompts(es_publico);
CREATE INDEX idx_prompts_created_at ON prompts(created_at);


-- ==========================
-- ETIQUETAS
-- ==========================
CREATE TABLE etiquetas (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(80) NOT NULL UNIQUE,
  created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ==========================
-- PIVOT prompt_tag (N:M)
-- ==========================
CREATE TABLE prompt_tag (
  prompt_id BIGINT UNSIGNED NOT NULL,
  tag_id BIGINT UNSIGNED NOT NULL,
  PRIMARY KEY (prompt_id, tag_id),

  CONSTRAINT fk_prompt_tag_prompt
    FOREIGN KEY (prompt_id) REFERENCES prompts(id)
    ON DELETE CASCADE,

  CONSTRAINT fk_prompt_tag_tag
    FOREIGN KEY (tag_id) REFERENCES etiquetas(id)
    ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE INDEX idx_prompt_tag_tag ON prompt_tag(tag_id);


-- ==========================
-- VERSIONES
-- ==========================
CREATE TABLE versiones (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  prompt_id BIGINT UNSIGNED NOT NULL,
  numero_version INT UNSIGNED NOT NULL,
  contenido_anterior LONGTEXT NOT NULL,
  motivo_cambio VARCHAR(255) NOT NULL,
  created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,

  CONSTRAINT fk_versiones_prompt
    FOREIGN KEY (prompt_id) REFERENCES prompts(id)
    ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE INDEX idx_versiones_prompt ON versiones(prompt_id);
CREATE UNIQUE INDEX uk_version_prompt_num ON versiones(prompt_id, numero_version);


-- ==========================
-- COMPARTIDOS
-- ==========================
CREATE TABLE compartidos (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  prompt_id BIGINT UNSIGNED NOT NULL,
  nombre_destinatario VARCHAR(140) NOT NULL,
  email_destinatario VARCHAR(160) NOT NULL,
  fecha_compartido DATETIME NOT NULL,
  notas TEXT NULL,
  created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  CONSTRAINT fk_compartidos_prompt
    FOREIGN KEY (prompt_id) REFERENCES prompts(id)
    ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE INDEX idx_compartidos_prompt ON compartidos(prompt_id);
CREATE INDEX idx_compartidos_email ON compartidos(email_destinatario);


-- ==========================
-- ACTIVIDADES (AUDITORIA)
-- ==========================
CREATE TABLE actividades (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id BIGINT UNSIGNED NOT NULL,
  prompt_id BIGINT UNSIGNED NULL,
  accion VARCHAR(40) NOT NULL,
  descripcion TEXT NOT NULL,
  created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,

  CONSTRAINT fk_actividades_user
    FOREIGN KEY (user_id) REFERENCES users(id)
    ON DELETE CASCADE,

  CONSTRAINT fk_actividades_prompt
    FOREIGN KEY (prompt_id) REFERENCES prompts(id)
    ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE INDEX idx_actividades_user ON actividades(user_id);
CREATE INDEX idx_actividades_accion ON actividades(accion);
CREATE INDEX idx_actividades_created ON actividades(created_at);
