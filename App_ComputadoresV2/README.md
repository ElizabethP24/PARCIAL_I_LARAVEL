# App Computadores

Esta aplicación es un sistema de gestión para venta de computadores desarrollada con Laravel. Permite administrar el inventario de computadores, gestionar empleados, registrar ventas y visualizar información relevante de manera sencilla y eficiente.

## Características principales
- Gestión de computadores: crear, listar, editar y eliminar inventario de equipos.
- Gestión de empleados: crear y listar personal de ventas.
- Gestión de ventas: registrar y listar ventas de computadores.
- Dashboard principal con resumen de información relevante.
- Interfaz web amigable utilizando Blade.
- Base de datos SQLite lista para pruebas y desarrollo.
- Generación de reportes en PDF.
- Visualización de gráficos estadísticos.

## Páginas principales
- **Dashboard:** Página principal con resumen de computadores, empleados, ventas y gráficos.
- **Computadores:** Gestión completa del inventario de equipos (CRUD).
- **Empleados:** Listado, creación de empleados, generación de reportes en PDF.
- **Ventas:** Registro y lista de ventas, generación de reportes en PDF.

## Paquetes utilizados
- **dompdf/dompdf:** Generación de archivos PDF.
- **laraveldaily/laravel-charts** Visualización de gráficos y estadísticas.

## Estructura del proyecto
- `app/Models/`: Modelos Eloquent (`Computador`, `Empleado`, `User`, `Venta`).
- `app/Http/Controllers/`: Controladores para manejar la lógica de negocio.
- `resources/views/`: Vistas Blade para la interfaz de usuario.
- `routes/web.php`: Definición de rutas web.
- `database/migrations/`: Migraciones para la estructura de la base de datos.
- `database/seeders/`: Seeders para poblar la base de datos de computadores con datos de ejemplo.

## Instalación y configuración
1. **Clona el repositorio**
   ```bash
   git clone <url-del-repositorio>
   cd App_Computadores
   ```
2. **Instala dependencias**
   ```bash
   composer install
   ```
3. **Instala los paquetes adicionales**
   ```bash
   composer require dompdf/dompdf
   composer require laraveldaily/laravel-charts
   ```
4. **Configura el entorno**
   - Copia el archivo `.env.example` a `.env` y configura las variables necesarias.
   - Por defecto, la base de datos es SQLite (`database/database.sqlite`).
5. **Ejecuta migraciones y seeders**
   ```bash
   php artisan migrate --seed
   ```
7. **Inicia el servidor de desarrollo**
   ```bash
   php artisan serve
   ```

## Uso de la aplicación
- Accede a la aplicación en [http://localhost:8000]
- Navega por las secciones de Dashboard, Computadores, Empleados y Ventas para gestionar el inventario, personal y ventas.
- Utiliza la sección de Computadores para administrar el inventario de equipos disponibles.

## Notas adicionales
- El archivo `public/documents/ventas.pdf` es un ejemplo de documento generado.
- Puedes modificar los seeders para agregar más datos de ejemplo.

## Estructura de carpetas relevante
```
app/Models/           # Modelos Eloquent
app/Http/Controllers/ # Controladores
resources/views/      # Vistas Blade
routes/web.php        # Rutas web
```

## Créditos
Desarrollado por ElizabethP24.
