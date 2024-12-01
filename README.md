# Gestión de Mesas para Restaurante

Este proyecto es una aplicación web que permite gestionar la disponibilidad de mesas en un restaurante. La aplicación está diseñada para ser utilizada por los camareros y forma parte de una intranet del restaurante.

## Funcionalidades Principales
- Visualización de la disponibilidad de mesas y sillas en cada sala del restaurante.
- Cambio de estado de las mesas (libre/ocupada) según la actividad del restaurante.
- Login/logout para gestionar las ocupaciones asociadas a cada camarero.
- Histórico de la ocupación de mesas con filtros por recurso y ubicación.
- Interfaz homogénea, responsive y fácil de usar.

## Estructura del Restaurante
El restaurante dispone de las siguientes salas:
- 3 terrazas
- 2 comedores
- 4 salas privadas

Cada sala tiene una distribución definida de mesas con capacidad especificada. Esta configuración inicial se puede visualizar y gestionar desde la aplicación.

## Estructura del Proyecto

### MP9 - Diseño de interfaces web
- Mockup creado e implementado.
- Uso de CSS para diseño homogéneo y responsive.
- Interfaz visual intuitiva adaptada a dispositivos móviles y de escritorio.

### MP6 - Desarrollo web en entorno cliente
- Validación dinámica de formularios con JavaScript.
- Uso de SweetAlerts para notificar acciones (ejemplo: cambio de estado de mesa).
- Acciones dinámicas en la página para mejorar la experiencia de usuario.

### MP7 - Desarrollo web en entorno servidor
- Conexión con la base de datos mediante PHP procedural.
- Consultas para seleccionar y filtrar datos.
- Consultas para modificar el estado de las mesas (ocupada/libre).
- Uso de sesiones para gestionar la autenticación de usuarios (login/logout).

### MP2 - Bases de datos
- Base de datos diseñada para gestionar mesas, salas, camareros y ocupaciones.
- Consultas SQL para filtrar y actualizar las ocupaciones.
- Datos iniciales cargados para realizar demostraciones durante la exposición.

### MP8 - Despliegue de aplicaciones web
- Planificación del proyecto con un diagrama Gantt.
- Uso de GitHub para gestionar roles y seguimiento del proyecto:
  - **Ramas:** Separación de funcionalidades en ramas para facilitar la integración.
  - **Issues:** Creación de issues para cada funcionalidad y mejora.
  - **Milestones:** Definición de etapas clave en el desarrollo.
  - **Labels:** Organización de issues con etiquetas.
- Archivo `README.md` con información del proyecto e instrucciones para pruebas.
- Seguimiento diario con reuniones del equipo (Daily Meetings).

## Requisitos Técnicos

### Frontend
- **HTML5, CSS3, Bootstrap.**
- JavaScript para validación e interacciones dinámicas.

### Backend
- PHP procedural.
- Gestión de sesiones para login/logout.

### Base de Datos
- **MySQL** para el almacenamiento de datos del restaurante.
- Consultas optimizadas para la gestión de mesas y ocupaciones.

### Otros
- SweetAlerts para notificaciones visuales.
- Mockup inicial validado por todo el equipo.

