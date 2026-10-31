# 📝 Checklist del Proyecto: Sistema de Gestión de Matrículas Académicas

**Descripción del Caso:** Institución educativa que requiere administrar estudiantes, asignaturas, grupos y matrículas.
**Módulo principal:** Registro y consulta de matrículas.
**Usuarios:** Administrador y Funcionario Académico.

---

## Etapa 1: Formulación
- [x] Selección del caso (Caso 2: Sistema de gestión de matrículas académicas).
- [ ] Redactar la descripción de la empresa / contexto organizacional.
- [ ] Redactar el planteamiento del problema o necesidad.
- [ ] Definir la justificación de la solución propuesta.
- [ ] Redactar el Objetivo General.
- [ ] Redactar los Objetivos Específicos.
- [ ] Definir el alcance del proyecto.

## Etapa 2: Análisis
- [ ] Identificar actores y usuarios del sistema (Administrador, Funcionario Académico).
- [ ] Listar los Requerimientos Funcionales (enfocados en gestión de estudiantes, asignaturas, grupos y matrículas).
- [ ] Listar los Requerimientos No Funcionales.
- [ ] Definir los Casos de Uso principales (especialmente el registro y consulta de matrículas).

## Etapa 3: Diseño
- [ ] Elaborar Diagrama de Arquitectura o componentes de la aplicación.
- [ ] Elaborar Diagrama de Clases o modelo conceptual.
- [ ] Elaborar Diagrama Entidad-Relación (BD: Usuarios, Estudiantes, Asignaturas, Grupos, Matrículas).
- [ ] Describir la estructura MVC y el flujo de funcionamiento propuesto.
- [ ] Justificar las tecnologías, herramientas y decisiones de diseño.

## Etapa 4: Desarrollo
- [ ] Crear el proyecto Laravel e instalar dependencias (Composer).
- [ ] Configurar el archivo `.env` y la conexión a la base de datos.
- [ ] Crear las Migraciones (Estudiantes, Asignaturas, Grupos, Matrículas).
- [ ] Configurar los Modelos (Eloquent) y sus relaciones (HasMany, BelongsTo, etc.).
- [ ] Crear los Controladores y definir la organización de las rutas.
- [ ] **Módulo Principal:** Implementar CRUD funcional para el registro y consulta de Matrículas.
- [ ] Implementar CRUDs secundarios (Estudiantes, Asignaturas, Grupos).
- [ ] Diseñar y construir las Vistas (Blade) con una interfaz funcional.

## Etapa 5: Seguridad
- [ ] Implementar Autenticación (Inicio/Cierre de sesión) usando Laravel Breeze (u otro).
- [ ] Proteger rutas mediante Middleware.
- [ ] Configurar autorización (Roles/Permisos/Policies) para diferenciar Administrador de Funcionario Académico.
- [ ] Implementar reglas de validación de datos en los formularios (Form Requests).
- [ ] Verificar medidas de seguridad base (Protección CSRF, contraseñas encriptadas).
- [ ] Restringir el acceso a operaciones específicas según el usuario autenticado.

## Etapa 6: Verificación
- [ ] Realizar pruebas de los principales casos de uso (operaciones exitosas).
- [ ] Realizar pruebas de seguridad (intentos de acceso no autorizado, validaciones).
- [ ] Tomar capturas/evidencias de las pruebas realizadas.
- [ ] Aplicar correcciones y mejoras basadas en las pruebas.
- [ ] Crear *Seeders* o datos de prueba (instrucciones para crear un usuario de demostración).
- [ ] Preparar la demostración funcional del sistema.

## Etapa 7: Entrega final (Condiciones de Entrega)
- [ ] **Código Fuente:** Consolidar el código completo del proyecto Laravel (limpio de archivos innecesarios como `node_modules` o `vendor` si se entrega en ZIP).
- [ ] **Base de Datos:** Asegurar que las migraciones y seeders estén listos para preparar la base de datos de cero.
- [ ] **Instrucciones:** Crear archivo con instrucciones paso a paso para instalar, ejecutar el proyecto y crear el usuario de demo (ej. un `README.md`).
- [ ] **Documento Técnico (Formato Word):**
    - [ ] Portada e identificación de los integrantes.
    - [ ] Introducción, contexto, problema, justificación y objetivos (De Etapa 1).
    - [ ] Requerimientos, actores y casos de uso (De Etapa 2).
    - [ ] Arquitectura, explicación MVC, y tecnologías utilizadas (De Etapa 3).
    - [ ] Diagramas, modelos de diseño y modelo de base de datos (De Etapa 3).
    - [ ] Descripción de la implementación y funcionalidades (De Etapa 4).
    - [ ] Explicación de mecanismos de seguridad y roles (De Etapa 5).
    - [ ] Evidencias de pruebas realizadas y resultados (De Etapa 6).
    - [ ] Conclusiones, limitaciones y posibles mejoras.
- [ ] **Sustentación:** Preparar la defensa y exposición del proyecto.