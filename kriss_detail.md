# Pasos para la Implementación del Microservicio de Pagos

Este documento detalla todos los pasos técnicos que se siguieron para crear e integrar el nuevo microservicio de Pagos (`LumenPaymentsApi`).

---

### 1. Creación de Archivos de Documentación

- Se crearon los archivos `kriss_detail.md` y `kriss_document.md` en la raíz del proyecto.
- `kriss_detail.md`: Contendrá el registro de todos los pasos de implementación.
- `kriss_document.md`: Contendrá la documentación final de la API para los usuarios.

### 2. Creación del Microservicio `LumenPaymentsApi`

- Se utilizó Composer para crear un nuevo proyecto Lumen desde la raíz del monorepo.
- **Comando ejecutado:**
  ```bash
  composer create-project --prefer-dist laravel/lumen LumenPaymentsApi
  ```
- Esto generó una estructura de proyecto Lumen estándar dentro de la carpeta `LumenPaymentsApi`.

### 3. Definición de Modelo y Migración para Pagos

1.  **Crear el Archivo de Migración:**
    - Se utilizó `artisan` para generar un nuevo archivo de migración para la tabla `payments`.
    - **Comando:** `php artisan make:migration create_payments_table --create=payments`

2.  **Definir el Esquema de la Tabla:**
    - Se modificó el archivo de migración resultante para agregar todos los campos requeridos.
    - **Campos agregados:** `order_id`, `user_id`, `amount`, `payment_method`, `status`, `transaction_id`.

3.  **Crear el Modelo `Payment`:**
    - Se creó el archivo del modelo Eloquent `LumenPaymentsApi/app/Payment.php`.
    - Se configuró la propiedad `$fillable` en el modelo para permitir la asignación masiva de los campos de la tabla.

### 4. Configuración y Ejecución de la Migración

1.  **Configurar el Entorno (`.env`):**
    - Se copió `.env.example` a `.env`.
    - Se modificó el archivo `.env` para utilizar SQLite, especificando la ruta absoluta a la base de datos.
      ```env
      DB_CONNECTION=sqlite
      DB_DATABASE="C:/septimo ciclo/arquitectura de software/segundo/arquitecturaMicroServicios/LumenPaymentsApi/database/database.sqlite"
      ```

2.  **Habilitar Componentes de Lumen:**
    - En `bootstrap/app.php`, se descomentaron las siguientes líneas para habilitar Facades, Eloquent y el `AppServiceProvider`, necesarios para las migraciones y el ORM.
      ```php
      $app->withFacades();
      $app->withEloquent();
      $app->register(App\Providers\AppServiceProvider::class);
      ```

3.  **Ejecutar la Migración:**
    - Se ejecutó el comando de migración para crear la tabla `payments` en la base de datos SQLite.
    - **Comando:** `php artisan migrate --force` (se usó `--force` para evitar el diálogo interactivo de creación de la base de datos).

### 5. Implementación de Rutas y Controlador

1.  **Copiar el Trait `ApiResponser`:**
    - Para mantener respuestas consistentes, se copió el trait `ApiResponser.php` desde `LumenAuthorsApi` al nuevo servicio.
    - **Ubicación:** `LumenPaymentsApi/app/Traits/ApiResponser.php`

2.  **Crear `PaymentController`:**
    - Se creó el controlador `LumenPaymentsApi/app/Http/Controllers/PaymentController.php`.
    - Se añadieron métodos `placeholder` para cada uno de los endpoints requeridos, utilizando el trait `ApiResponser` para las respuestas.

3.  **Definir las Rutas:**
    - Se modificó el archivo `LumenPaymentsApi/routes/web.php` para definir todas las rutas de la API de pagos y conectarlas con sus respectivos métodos en el `PaymentController`.
    - **Endpoints definidos:**
      - `POST /payments`
      - `GET /payments/{id}`
      - `GET /payments/order/{order_id}`
      - `POST /payments/{id}/refund`
      - `GET /payments/user/{user_id}`

### 6. Implementación de la Lógica de Negocio

1.  **Crear `PaymentService`:**
    - Se creó el directorio `app/Services` y el archivo `PaymentService.php` dentro de él.
    - Esta clase se encarga de toda la lógica de negocio, como la creación y consulta de pagos en la base de datos.
    - Los métodos del servicio simulan interacciones con una pasarela de pago (ej. `status = 'completed'`, `transaction_id = 'txn_...'`).

2.  **Inyectar Servicio en el Controlador:**
    - Se refactorizó el `PaymentController` para inyectar `PaymentService` a través del constructor.
    - Cada método del controlador ahora llama al método correspondiente en el servicio para manejar la lógica, manteniendo el controlador "delgado" (thin controller).

3.  **Añadir Validación:**
    - Se agregaron reglas de validación en el método `store` del `PaymentController` para asegurar la integridad de los datos de entrada al crear un pago.

### 7. Integración con el API Gateway

Para que el nuevo `LumenPaymentsApi` sea accesible a través del Gateway, se realizaron los siguientes cambios en el proyecto `LumenGatewayApi`:

1.  **Crear `PaymentService` en el Gateway:**
    - Se creó el archivo `LumenGatewayApi/app/Services/PaymentService.php`.
    - Este servicio utiliza el trait `ConsumesExternalService` para realizar peticiones HTTP hacia el microservicio de pagos.
    - Se encarga de obtener la URL base y el `secret` desde la configuración.

2.  **Crear `PaymentController` en el Gateway:**
    - Se creó el controlador `LumenGatewayApi/app/Http/Controllers/PaymentController.php`.
    - Este controlador inyecta el `PaymentService` del gateway y expone sus métodos, actuando como un simple passthrough hacia el microservicio final.

3.  **Añadir Rutas al Gateway:**
    - Se agregaron las rutas de pagos al archivo `LumenGatewayApi/routes/web.php` bajo el prefijo `/payments`.

4.  **Actualizar Configuración de Servicios:**
    - Se añadió la configuración del nuevo servicio en `LumenGatewayApi/config/services.php` para que el gateway pueda resolver su `base_uri` y `secret`.

5.  **Actualización Manual del `.env` (Usuario):**
    - Se debe agregar la siguiente línea al archivo `.env` del `LumenGatewayApi` para que pueda conectarse al nuevo microservicio.
      ```env
      PAYMENTS_SERVICE_BASE_URL=http://localhost:8010
      ```

### 8. Finalización y Próximos Pasos

- **Implementación Completa:** Se ha completado la creación, configuración e integración del microservicio de Pagos.
- **Documentación Generada:**
  - `kriss_detail.md`: Contiene todos los pasos técnicos realizados.
  - `kriss_document.md`: Contiene la documentación de la API para su uso.
- **Próximos Pasos para el Usuario:**
  1.  Asegurarse de haber añadido la variable `PAYMENTS_SERVICE_BASE_URL` al `.env` del Gateway.
  2.  Iniciar los tres servidores en terminales separadas (Authors, Books, Gateway) y el nuevo servidor de Pagos:
      ```bash
      # En la carpeta LumenPaymentsApi
      php -S localhost:8010 -t public
      ```
  3.  Utilizar un cliente de API (como Postman o curl) para probar los nuevos endpoints a través del Gateway (ej. `POST http://localhost:8000/payments`).
