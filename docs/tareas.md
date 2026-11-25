# 📝 Checklist del Proyecto: Sistema de Gestión de Matrículas Académicas

**Descripción del Caso:** Institución educativa que requiere administrar estudiantes, asignaturas, grupos y matrículas.

**Módulo principal:** Registro y consulta de matrículas.

**Usuarios:** Administrador y Estudiante.

---

## Etapa 1: Formulación

- [x] Selección del caso (Caso 2: Sistema de gestión de matrículas académicas).
- [x] Redactar la descripción de la empresa / contexto organizacional.
- [x] Redactar el planteamiento del problema o necesidad.
- [x] Definir la justificación de la solución propuesta.
- [x] Redactar el Objetivo General.
- [x] Redactar los Objetivos Específicos.
- [x] Definir el alcance del proyecto.

## Etapa 2: Análisis

- [x] Identificar actores y usuarios del sistema (Administrador y Estudiante).
- [x] Listar los Requerimientos Funcionales (gestión de estudiantes, asignaturas, grupos, matrículas y activación de cuentas).
- [x] Listar los Requerimientos No Funcionales.
- [x] Definir los Casos de Uso principales (activación de cuentas, registro y consulta de matrículas).

## Etapa 3: Diseño

- [x] Elaborar Diagrama de Arquitectura o componentes de la aplicación.
- [ ] Elaborar Diagrama de Clases o modelo conceptual.
- [x] Elaborar Diagrama Entidad-Relación (BD: Usuarios, Estudiantes, Asignaturas, Grupos, Matrículas y tabla pivote).
- [ ] Describir formalmente la estructura MVC y el flujo de funcionamiento del sistema.
- [ ] Justificar las tecnologías, herramientas y decisiones de diseño.
- [x] Definir las relaciones entre las entidades y la estructura general de la base de datos.

## Etapa 4: Desarrollo

- [x] Crear el proyecto Laravel e instalar las dependencias mediante Composer.
- [x] Configurar el archivo `.env` y la conexión a la base de datos.
- [x] Crear las migraciones (Usuarios, Estudiantes, Asignaturas, Grupos, Matrículas y tabla pivote).
- [x] Configurar los modelos Eloquent y sus relaciones (HasMany, BelongsTo, BelongsToMany, HasOne).
- [x] Crear los controladores y definir la organización de las rutas.
- [x] Implementar la estructura general del módulo de matrículas.
- [x] Implementar funcionalidades de gestión administrativa de estudiantes, asignaturas y grupos.
- [x] Implementar el portal de acceso para estudiantes.
- [x] Diseñar y construir las vistas Blade con una interfaz funcional.
- [ ] Revisar y completar las funcionalidades del módulo principal de registro y consulta de matrículas.
- [ ] Verificar que las relaciones entre matrículas, grupos y asignaturas se reflejen correctamente en todas las vistas.
- [ ] Comprobar el comportamiento de los cupos disponibles al registrar y cancelar matrículas.
- [ ] Revisar y completar los mensajes de confirmación, validación y error de las operaciones.

## Etapa 5: Seguridad

- [x] Implementar autenticación (inicio y cierre de sesión).
- [x] Implementar los roles Administrador y Estudiante.
- [x] Proteger las rutas administrativas mediante Middleware.
- [x] Configurar restricciones de acceso según el rol del usuario.
- [x] Implementar mecanismos de almacenamiento seguro de contraseñas mediante Laravel.
- [x] Configurar la protección CSRF en los formularios.
- [ ] Revisar y completar las reglas de validación de datos en los formularios.
- [x] Implementar el servicio de activación de cuentas mediante enlaces enviados por correo electrónico.
- [ ] Verificar el envío real de los correos electrónicos de activación utilizando SMTP gratuito.
- [ ] Comprobar que los enlaces de activación validen correctamente los tokens y su expiración.
- [ ] Verificar que los estudiantes solamente puedan consultar su propia información académica.
- [ ] Realizar pruebas de acceso no autorizado a las rutas y operaciones administrativas.

## Etapa 6: Verificación

- [ ] Realizar pruebas de los principales casos de uso (operaciones exitosas).
- [ ] Realizar pruebas de registro, actualización y consulta de estudiantes.
- [ ] Realizar pruebas de creación, modificación y consulta de asignaturas y grupos.
- [ ] Realizar pruebas del registro y consulta de matrículas.
- [ ] Realizar pruebas de control de cupos disponibles.
- [ ] Realizar pruebas de activación de cuentas mediante correo electrónico.
- [ ] Realizar pruebas de seguridad (intentos de acceso no autorizado y validaciones).
- [ ] Tomar capturas y evidencias de las pruebas realizadas.
- [ ] Aplicar correcciones y mejoras basadas en los resultados de las pruebas.
- [x] Crear factories y seeders para generar datos de prueba.
- [x] Preparar la generación de datos de demostración (administrador, estudiantes, asignaturas, grupos y matrículas).
- [ ] Ejecutar y verificar correctamente el proceso completo de `php artisan migrate:fresh --seed`.
- [ ] Comprobar que los datos generados respeten las relaciones y los cupos máximos de los grupos.
- [ ] Preparar la demostración funcional del sistema.

## Etapa 7: Entrega Final (Condiciones de Entrega)

- [ ] **Código Fuente:** Consolidar el código completo del proyecto Laravel, excluyendo archivos innecesarios como `node_modules` y `vendor` si se entrega en ZIP.
- [ ] **Base de Datos:** Asegurar que las migraciones y seeders estén listos para preparar la base de datos desde cero.
- [ ] **Instrucciones:** Crear un archivo con instrucciones paso a paso para instalar y ejecutar el proyecto, configurar el entorno y crear o utilizar el usuario de demostración (README.md).
- [ ] **Documento Técnico (Formato Word):**
    - [ ] Portada e identificación de los integrantes.
    - [ ] Introducción, contexto, problema, justificación y objetivos (Etapa 1).
    - [ ] Requerimientos, actores y casos de uso (Etapa 2).
    - [ ] Arquitectura, explicación MVC y tecnologías utilizadas (Etapa 3).
    - [ ] Diagramas, modelos de diseño y modelo de base de datos (Etapa 3).
    - [ ] Descripción de la implementación y funcionalidades (Etapa 4).
    - [ ] Explicación de mecanismos de seguridad, autenticación y roles (Etapa 5).
    - [ ] Descripción del proceso de activación de cuentas mediante correo electrónico.
    - [ ] Evidencias de pruebas realizadas y resultados (Etapa 6).
    - [ ] Conclusiones, limitaciones y posibles mejoras.
- [ ] **Sustentación:** Preparar la defensa y exposición del proyecto.

---

## Observaciones sobre el estado actual

1. Las etapas 1 y 2 están documentadas y actualizadas conforme a los roles y funcionalidades actuales del sistema.

2. En la etapa 3 ya se cuenta con el diagrama de arquitectura trabajado anteriormente y el diagrama ER actualizado. Todavía falta elaborar el diagrama de clases y completar la documentación del diseño.

3. En la etapa 4 ya existe una estructura funcional desarrollada en Laravel, con migraciones, modelos, relaciones, controladores, rutas y módulos administrativos. Es necesario continuar verificando las funcionalidades y su integración.

4. En la etapa 5 ya se cuenta con autenticación, roles, protección de rutas y el desarrollo del mecanismo de activación de cuentas. Quedan pendientes las pruebas completas de seguridad y del envío de correos.

5. En la etapa 6 se han preparado factories y seeders para generar datos de prueba, incluyendo 500 estudiantes, 25 asignaturas y 75 grupos. Sin embargo, el último intento de `migrate:fresh --seed` presentó un error al actualizar la ocupación de los grupos mediante una Collection. Se propuso corregirlo utilizando `put()`, pero todavía falta confirmar que la ejecución completa finalice correctamente.

6. La etapa 7 permanece pendiente, ya que requiere consolidar el código, verificar la instalación desde cero, preparar el documento técnico y reunir las evidencias necesarias para la entrega.