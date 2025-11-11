# Renta de Maquinaria (proyecto basado en EL-BUENO)

Proyecto Laravel para gestionar la renta de maquinaria. Basado en la estructura de EL-BUENO.

Requisitos
- PHP 8.0+
- Composer
- MySQL (o Docker)
- Node/npm (si usas assets)

Instalación local
1. Clonar:
   git clone <tu-repo-url>
   cd <repo>

2. Instalar dependencias:
   composer install
   cp .env.example .env
   php artisan key:generate

3. Configurar base de datos en .env:
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=el_bueno_db
   DB_USERNAME=elbueno_user
   DB_PASSWORD=TuPass123!

4. Migrar & seeders (opcional):
   php artisan migrate --seed

5. Levantar servidor:
   php artisan serve

Funcionalidades iniciales
- CRUD para Equipments (maquinaria).
- Modelo Rental para registrar rentas (por implementar vistas/flows).
- Básicos: validación, paginación, eliminación con softDeletes.

Cómo contribuir
- Crear una rama feature/mi-cambio
- Hacer commits pequeños
- Abrir un pull request hacia main/master
