-- ==========================================
-- INSERTAR USUARIOS
-- ==========================================
INSERT INTO users (name, email, email_verified_at, password, created_at, updated_at) VALUES
('Usuario Demo', 'demo@promptvault.com', NOW(), '$2y$12$LQv3c1yycaUExs4Qj.tCcu7b/j/e8fFfqMqE7c5b0p3Q3b0b0b0b0', NOW(), NOW()),
('Administrador', 'admin@promptvault.com', NOW(), '$2y$12$LQv3c1yycaUExs4Qj.tCcu7b/j/e8fFfqMqE7c5b0p3Q3b0b0b0b0', NOW(), NOW());

-- ==========================================
-- INSERTAR CATEGORÍAS
-- ==========================================
INSERT INTO categorias (nombre, descripcion, color, icono, created_at, updated_at) VALUES
('Programación', 'Prompts para ayuda con código', '#3b82f6', '💻', NOW(), NOW()),
('Redacción', 'Prompts para escritura y contenido', '#10b981', '✍️', NOW(), NOW()),
('Análisis', 'Prompts para análisis de datos', '#f59e0b', '📊', NOW(), NOW()),
('Traducción', 'Prompts para traducción de idiomas', '#8b5cf6', '🌐', NOW(), NOW()),
('Creatividad', 'Prompts para ideas creativas', '#ec4899', '🎨', NOW(), NOW()),
('Educación', 'Prompts para enseñanza y aprendizaje', '#06b6d4', '📚', NOW(), NOW()),
('Productividad', 'Prompts para organización y eficiencia', '#84cc16', '⚡', NOW(), NOW()),
('Investigación', 'Prompts para investigación académica', '#6366f1', '🔬', NOW(), NOW());

-- ==========================================
-- INSERTAR ETIQUETAS
-- ==========================================
INSERT INTO etiquetas (nombre, created_at, updated_at) VALUES
('Python', NOW(), NOW()),
('JavaScript', NOW(), NOW()),
('PHP', NOW(), NOW()),
('Laravel', NOW(), NOW()),
('React', NOW(), NOW()),
('SQL', NOW(), NOW()),
('Debug', NOW(), NOW()),
('Optimización', NOW(), NOW()),
('Tutorial', NOW(), NOW()),
('Resumen', NOW(), NOW()),
('Explicación', NOW(), NOW()),
('Ideas', NOW(), NOW());

-- ==========================================
-- INSERTAR PROMPTS
-- ==========================================
INSERT INTO prompts (user_id, categoria_id, titulo, contenido, descripcion, ia_destino, es_favorito, es_publico, veces_usado, version_actual, created_at, updated_at) VALUES
(1, 1, 'Sci-Fi Short Story Starter', 'Generate a compelling opening paragraph for a sci-fi short story about time travel paradoxes', 'Perfect for starting creative sci-fi narratives', 'ChatGPT', 1, 1, 24, 1, NOW(), NOW()),
(1, 2, 'AI Art Landscape Generator', 'Create a vivid description for an AI art generator: A mystical landscape with floating islands', 'Detailed prompts for AI art generation', 'Gemini', 0, 1, 18, 1, NOW(), NOW()),
(1, 3, 'AI Art Generapse Generator', 'Generate a detailed portrait description for AI art: Professional headshot with cinematic lighting', 'Professional AI-generated portraits', 'ChatGPT', 1, 1, 32, 1, NOW(), NOW()),
(1, 4, 'Python Assistant', 'Help me debug this Python code and explain the error:\n\n[YOUR CODE HERE]', 'For debugging Python code with explanations', 'Claude', 0, 0, 15, 1, NOW(), NOW()),
(1, 5, 'Python Debuglitant', 'Write Python unit tests for the following function using pytest:\n\n[YOUR FUNCTION]', 'Generate comprehensive unit tests', 'ChatGPT', 0, 1, 8, 1, NOW(), NOW()),
(1, 6, 'Coding Assistant', 'Explain this code line by line in simple terms:\n\n[YOUR CODE]', 'Step-by-step code explanations', 'Claude', 1, 1, 45, 1, NOW(), NOW()),
(1, 7, 'Plan de Estudio', 'Crea un plan de estudio de 30 días para aprender [TEMA], nivel principiante', 'Planes de estudio estructurados', 'ChatGPT', 0, 0, 12, 1, NOW(), NOW()),
(1, 8, 'Resumen Ejecutivo', 'Resume el siguiente texto en un párrafo de 100 palabras:\n\n[TEXTO AQUÍ]', 'Para crear resúmenes ejecutivos', 'Claude', 1, 1, 28, 1, NOW(), NOW()),
(1, 1, 'Optimizar SQL', 'Analiza esta query SQL y sugiere optimizaciones:\n\n[SQL QUERY]', 'Optimización de consultas SQL', 'Gemini', 0, 1, 19, 1, NOW(), NOW()),
(1, 5, 'Ideas Creativas', 'Dame 10 ideas creativas e innovadoras para: [TEMA]', 'Brainstorming y generación de ideas', 'ChatGPT', 1, 0, 35, 1, NOW(), NOW());

-- ==========================================
-- INSERTAR RELACIONES PROMPT-TAG
-- ==========================================
INSERT INTO prompt_tag (prompt_id, tag_id) VALUES
(1, 9), (1, 11),
(2, 12),
(3, 12),
(4, 1), (4, 7),
(5, 1),
(6, 9), (6, 11),
(7, 9),
(8, 10),
(9, 6), (9, 8),
(10, 12);
