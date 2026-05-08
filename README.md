# 🏛️ Smart Governance Microservices

Sistema integral de gestión y procesamiento inteligente de documentos gubernamentales. Esta arquitectura utiliza microservicios para separar la lógica de negocio (Laravel) del procesamiento pesado de datos e inteligencia de documentos (Python).

## 🚀 Stack Tecnológico

* **Backend:** Laravel 11 (PHP 8.3)
* **Procesamiento:** Flask (Python 3.9) con PyPDF2 para extracción de texto.
* **Base de Datos:** PostgreSQL 15.
* **Contenedores:** Docker & Docker Compose.
* **Seguridad:** API Auth mediante Laravel Sanctum (Bearer Tokens).

## 🛠️ Requisitos Previos

Asegúrate de tener instalado:
* [Docker Desktop](https://www.docker.com/products/docker-desktop/)
* [Git](https://git-scm.com/)
* Un cliente para pruebas de API (Postman recomendado)

## 📦 Instalación y Despliegue

Sigue estos pasos para levantar el entorno completo:

1. **Clonar el repositorio:**
   git clone https://github.com/jos-chiroy-aifan/smart-governance-microservices.git
   cd smart-governance-microservices

2. **Levantar los servicios con Docker:**
   docker-compose up -d --build

3. **Configurar el Backend (Laravel):**
   *El contenedor de Laravel ejecutará automáticamente las migraciones y el enlace de almacenamiento:*
   docker exec -it gov_laravel php artisan migrate
   docker exec -it gov_laravel php artisan storage:link

## 🐳 Comandos Útiles de Docker

* **Ver logs en tiempo real (para ver el procesamiento de Python):**
  docker-compose logs -f

* **Detener todos los servicios:**
  docker-compose down

* **Reiniciar el microservicio de Python:**
  docker-compose restart python_service

* **Entrar a la terminal del servidor Laravel:**
  docker exec -it gov_laravel bash

## 🧪 Flujo de Trabajo (Cómo probar)

1. **Registro/Login:** Crea un usuario en `/api/register` y obtén tu `token` en `/api/login`.
2. **Subida de Documento:** Usa el endpoint `POST /api/documents` enviando un archivo PDF (campo `documento` en form-data) y el Token en el header.
3. **Procesamiento Síncrono:** Laravel enviará el archivo al microservicio de Python y esperará la respuesta.
4. **Extracción de Metadata:** Python devolverá el conteo de páginas y los datos extraídos (Tipo de documento, entidad emisora y fechas) mediante patrones Regex.
5. **Persistencia:** La información se guarda automáticamente en la columna `metadata` de la tabla `documents` en PostgreSQL.

---
Desarrollado por **José Chiroy** - May 2026.
