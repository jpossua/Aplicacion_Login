-- ============================================
-- SCRIPT SQL PARA AÑADIR CAMPO 'ADMITIDO'
-- ============================================
-- Este script añade la columna 'admitido' a la tabla 'usuarios'
-- para implementar el sistema de autorización por admin.

-- Añadir la columna 'admitido' (BOOLEAN/TINYINT)
-- Por defecto será FALSE (0) para nuevos usuarios
ALTER TABLE usuarios ADD COLUMN admitido TINYINT(1) DEFAULT 0;

-- Actualizar todos los usuarios existentes a admitido = TRUE (1)
-- para que puedan seguir accediendo sin problemas
UPDATE usuarios SET admitido = 1;

-- ============================================
-- VERIFICAR LOS CAMBIOS
-- ============================================
-- Ejecutar esta consulta para verificar la estructura de la tabla
-- DESCRIBE usuarios;

-- Ejecutar esta consulta para ver los usuarios y su estado de admisión
-- SELECT idUser, nombre, apellidos, admitido FROM usuarios;
