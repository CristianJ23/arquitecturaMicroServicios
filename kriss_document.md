# Documentación de la API de Pagos

Esta documentación describe los endpoints disponibles para el microservicio de Pagos.

**URL Base:** `http://localhost:8010` (directamente) o `http://localhost:8000/payments` (a través del Gateway).

---

### 1. Procesar un Pago

- **Endpoint:** `POST /payments`
- **Descripción:** Crea y procesa un nuevo pago para un pedido.
- **Body (JSON):**
  ```json
  {
      "order_id": 1,
      "user_id": 1,
      "amount": 99.99,
      "payment_method": "credit_card"
  }
  ```
- **Campos Requeridos:**
  - `order_id` (integer): ID del pedido.
  - `user_id` (integer): ID del usuario que realiza el pago.
  - `amount` (numeric): Monto del pago.
  - `payment_method` (string): Método de pago. Valores permitidos: `credit_card`, `paypal`, `bank_transfer`.
- **Respuesta Exitosa (201 CREATED):**
  ```json
  {
      "data": {
          "order_id": "1",
          "user_id": "1",
          "amount": "99.99",
          "payment_method": "credit_card",
          "status": "completed",
          "transaction_id": "txn_65a4c5a0b1b2c",
          "updated_at": "2026-01-14T22:00:00.000000Z",
          "created_at": "2026-01-14T22:00:00.000000Z",
          "id": 1
      }
  }
  ```

---

### 2. Obtener Estado de un Pago

- **Endpoint:** `GET /payments/{id}`
- **Descripción:** Obtiene los detalles de un pago específico por su ID.
- **Parámetros de URL:**
  - `id` (integer): ID del pago.
- **Respuesta Exitosa (200 OK):**
  ```json
  {
      "data": {
          "id": 1,
          "order_id": 1,
          "user_id": 1,
          "amount": "99.99",
          "payment_method": "credit_card",
          "status": "completed",
          "transaction_id": "txn_65a4c5a0b1b2c",
          "created_at": "2026-01-14T22:00:00.000000Z",
          "updated_at": "2026-01-14T22:00:00.000000Z"
      }
  }
  ```
- **Respuesta de Error (404 NOT FOUND):**
  ```json
  {
      "error": "Payment not found",
      "code": 404
  }
  ```

---

### 3. Obtener Pagos de un Pedido

- **Endpoint:** `GET /payments/order/{order_id}`
- **Descripción:** Obtiene una lista de todos los pagos asociados a un ID de pedido.
- **Parámetros de URL:**
  - `order_id` (integer): ID del pedido.
- **Respuesta Exitosa (200 OK):**
  ```json
  {
      "data": [
          {
              "id": 1,
              "order_id": 1,
              // ... otros campos
          }
      ]
  }
  ```

---

### 4. Procesar un Reembolso

- **Endpoint:** `POST /payments/{id}/refund`
- **Descripción:** Marca un pago como reembolsado.
- **Parámetros de URL:**
  - `id` (integer): ID del pago a reembolsar.
- **Respuesta Exitosa (200 OK):**
  ```json
  {
      "data": {
          "id": 1,
          "status": "refunded",
          // ... otros campos
      }
  }
  ```

---

### 5. Obtener Historial de Pagos de un Usuario

- **Endpoint:** `GET /payments/user/{user_id}`
- **Descripción:** Obtiene el historial de todos los pagos realizados por un usuario.
- **Parámetros de URL:**
  - `user_id` (integer): ID del usuario.
- **Respuesta Exitosa (200 OK):**
  ```json
  {
      "data": [
          {
              "id": 1,
              "user_id": 1,
              // ... otros campos
          },
          {
              "id": 2,
              "user_id": 1,
              // ... otros campos
          }
      ]
  }
  ```
