# API - Endpoints

## 📍 Locaciones

### Obtener todas las locaciones
- **GET** `/locaciones`

### Obtener locación por ID
- **GET** `/locaciones/{id}`

### Buscar locaciones por nombre
- **GET** `/locaciones/nombre/{nombre}`

### Obtener locaciones por colonia
- **GET** `/locaciones/colonia/{coloniaId}`

### Obtener locaciones por tipo
- **GET** `/locaciones/tipo/{tipoLocacionId}`

### Obtener horarios de una locación
- **GET** `/locaciones/{id}/horarios`

### Crear una locación
- **POST** `/locaciones`


---

## 🌆 Ciudades

### Obtener todas las ciudades
- **GET** `/ciudades`

### Obtener ciudad por ID
- **GET** `/ciudades/{id}`

### Buscar ciudad por nombre
- **GET** `/ciudades/nombre/{nombre}`

### Crear una ciudad
- **POST** `/ciudades`


---

## 🏘️ Colonias

### Obtener todas las colonias
- **GET** `/colonias`

### Obtener colonia por ID
- **GET** `/colonias/{id}`

### Buscar colonia por nombre
- **GET** `/colonias/nombre/{nombre}`

### Obtener colonias por ciudad
- **GET** `/colonias/ciudad/{ciudadId}`

### Crear una colonia
- **POST** `/colonias`


---

## ⏰ Horarios

### Obtener todos los horarios
- **GET** `/horarios`

### Obtener horario por ID
- **GET** `/horarios/{id}`

### Buscar horarios por hora
- **GET** `/horarios/hora/{hora}`

### Buscar horarios por día de la semana
- **GET** `/horarios/diaSemana/{diaSemana}`

### Filtrar horarios por estado (activo/inactivo)
- **GET** `/horarios/activo/{activo}`

### Obtener horarios por locación
- **GET** `/horarios/locacion/{locacionId}`

### Crear un horario
- **POST** `/horarios`


---

## 📌 Notas

- Todos los endpoints retornan datos en formato JSON.
- Los endpoints `POST` requieren un body con los datos necesarios para la creación.
- Los parámetros entre `{}` son dinámicos.
