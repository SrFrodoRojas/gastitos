#!/bin/bash
set -e

# ==========================
# CONFIGURACIÓN
# ==========================

RUTA="/var/www/gastitos"
RUTA_BACKUP="/var/www/backups/gastitos"
DB_NAME="gastitos"
TIMESTAMP=$(date +"%Y-%m-%d_%H-%M-%S")
PROYECTO="backup_gastitos_$TIMESTAMP"
ZIP_NAME="$PROYECTO.zip"
SQL_NAME="$PROYECTO.sql"

USER_DEV="dario"
GROUP_WEB="nginx"

# Leer credenciales de BD desde .env
if [ -f "$RUTA/.env" ]; then
    DB_USER=$(grep -E '^DB_USERNAME=' "$RUTA/.env" | cut -d '=' -f2- | tr -d '"' | tr -d "'")
    DB_PASS=$(grep -E '^DB_PASSWORD=' "$RUTA/.env" | cut -d '=' -f2- | tr -d '"' | tr -d "'")
    DB_HOST=$(grep -E '^DB_HOST=' "$RUTA/.env" | cut -d '=' -f2- | tr -d '"' | tr -d "'")
    DB_PORT=$(grep -E '^DB_PORT=' "$RUTA/.env" | cut -d '=' -f2- | tr -d '"' | tr -d "'")
else
    echo "ERROR: No se encuentra el archivo .env en $RUTA"
    exit 1
fi

# Valores por defecto
DB_USER=${DB_USER:-root}
DB_PASS=${DB_PASS:-}
DB_HOST=${DB_HOST:-localhost}
DB_PORT=${DB_PORT:-3306}

# ==========================
# VALIDAR ENTORNO
# ==========================

echo "Validando entorno..."
[ -d "$RUTA" ] || { echo "No existe $RUTA"; exit 1; }
[ -f "$RUTA/artisan" ] || { echo "No se encontró artisan"; exit 1; }

# ==========================
# PERMISOS OPTIMIZADOS (una sola pasada)
# ==========================

echo "Ajustando permisos de forma optimizada..."

# Cambiar propietario (una sola vez)
chown -R $USER_DEV:$GROUP_WEB "$RUTA"

# Asignar permisos: rw para usuario y grupo, r para otros, ejecución solo a directorios y archivos ya ejecutables
chmod -R u=rwX,g=rwX,o=rX "$RUTA"

# Permisos especiales para storage y cache (ya son 775 con la regla anterior, pero forzamos)
chmod -R 775 "$RUTA/storage"
chmod -R 775 "$RUTA/bootstrap/cache"

# ==========================
# LARAVEL (cache y optimización)
# ==========================

cd "$RUTA"

echo "Limpiando caches..."
php artisan optimize:clear || true

echo "Regenerando caches..."
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

echo "Storage link..."
#php artisan storage:link || true

# ==========================
# BACKUP DE BASE DE DATOS Y PROYECTO
# ==========================

echo "Creando directorio de backups..."
mkdir -p "$RUTA_BACKUP"
chown -R $USER_DEV:$GROUP_WEB "$RUTA_BACKUP"

# Backup de la base de datos (optimizado con single-transaction)
echo "Dump SQL (usuario $DB_USER)..."
if mariadb-dump -h"$DB_HOST" -P"$DB_PORT" -u"$DB_USER" -p"$DB_PASS" --single-transaction --skip-lock-tables --routines "$DB_NAME" > "$RUTA_BACKUP/$SQL_NAME" 2>/dev/null; then
    echo "Dump completo con rutinas (procedimientos/funciones)."
else
    echo "El usuario $DB_USER no tiene permisos para --routines. Haciendo dump sin rutinas..."
    mariadb-dump -h"$DB_HOST" -P"$DB_PORT" -u"$DB_USER" -p"$DB_PASS" --single-transaction --skip-lock-tables "$DB_NAME" > "$RUTA_BACKUP/$SQL_NAME"
    echo "Dump realizado sin procedimientos almacenados (estructura + datos)."
fi

echo "Empaquetando proyecto (excluyendo vendor, node_modules, logs, backups)..."
zip -rq "$RUTA_BACKUP/$ZIP_NAME" "$RUTA" \
    -x "$RUTA/node_modules/*" \
    -x "$RUTA/vendor/*" \
    -x "$RUTA/.git/*" \
    -x "$RUTA/storage/logs/*" \
    -x "$RUTA/public/storage/*" \
    -x "$RUTA_BACKUP/*" \
    -x "*.zip" \
    -x "*.sql"

# ==========================
# COMMIT AUTOMÁTICO A GIT
# ==========================

echo "Actualizando repositorio Git..."

cd "$RUTA"
if [ -d ".git" ]; then
    git add .
    if ! git diff --cached --quiet; then
        git commit -m "Backup automático $TIMESTAMP"
        # git push origin main  # Opcional: descomentar para hacer push
        echo "✅ Commit realizado con mensaje: Backup automático $TIMESTAMP"
    else
        echo "ℹ️ No hay cambios para commit."
    fi
else
    echo "⚠️ No es un repositorio Git. Omitiendo commit."
fi

# ==========================
# FINAL
# ==========================

cd "$RUTA"
echo "✅ Proceso finalizado correctamente."
echo "Sitio: http://gastitos.online"

chmod +x node_modules/.bin/vite 2>/dev/null || true
chmod +x xartisan.sh
