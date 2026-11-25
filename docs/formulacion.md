# Etapa 1: Formulación del Proyecto

## Caso 2: Sistema de Gestión de Matrículas Académicas

### 1. Descripción de la Empresa / Contexto Organizacional

El **Instituto Educativo Horizonte** es una institución de educación que ofrece diversos programas académicos. Cuenta con un volumen creciente de estudiantes y una oferta variada de asignaturas y grupos por cada periodo académico, lo que requiere un control organizado de sus procesos administrativos y académicos.

La institución necesita gestionar adecuadamente la información de sus estudiantes, las asignaturas disponibles, los grupos académicos y los procesos de matrícula, garantizando la disponibilidad, integridad y organización de los datos.

### 2. Planteamiento del Problema o Necesidad

Actualmente, la institución realiza sus procesos de matrícula de forma manual, utilizando hojas de cálculo y documentos físicos. Esta metodología genera redundancia de información, lentitud en los trámites administrativos, posibles errores en el registro de estudiantes y dificultades para controlar los cupos disponibles en los grupos académicos.

Además, la consulta del historial de matrículas requiere revisar diferentes registros, lo que dificulta obtener información de manera rápida y organizada.

Otro inconveniente es la administración de las cuentas de acceso de los estudiantes, debido a la necesidad de establecer un mecanismo seguro que permita habilitar sus usuarios sin que el personal administrativo tenga que asignar o conocer sus contraseñas.

Por estas razones, surge la necesidad de implementar un sistema web que centralice la información y facilite la administración de los procesos relacionados con las matrículas académicas.

### 3. Justificación de la Solución Propuesta

La implementación de un sistema web desarrollado con el framework Laravel permitirá centralizar y organizar la gestión académica del Instituto Educativo Horizonte, facilitando la administración de estudiantes, asignaturas, grupos y matrículas desde una única plataforma.

La solución permitirá reducir la redundancia de datos, optimizar los tiempos de registro y consulta de información, mejorar el control de los cupos disponibles y disminuir los errores asociados a los procesos manuales.

Asimismo, incorporará un mecanismo de autenticación y autorización basado en roles, diferenciando los permisos del administrador y de los estudiantes.

Para fortalecer la seguridad en la gestión de usuarios, el administrador podrá crear las cuentas de los estudiantes y el sistema enviará un enlace de activación a sus respectivos correos electrónicos. Mediante este enlace, cada estudiante podrá establecer su propia contraseña y habilitar su cuenta de acceso.

De esta manera, el sistema contribuirá a mejorar la eficiencia administrativa, la organización de la información y la seguridad de los datos académicos de la institución.

### 4. Objetivo General

Desarrollar un sistema de información web para gestionar de manera eficiente los procesos de administración de estudiantes, asignaturas, grupos académicos y matrículas del Instituto Educativo Horizonte, mediante una plataforma centralizada que garantice la integridad de la información, el control de cupos y la seguridad en el acceso de los usuarios.

### 5. Objetivos Específicos

- Diseñar e implementar un modelo relacional de base de datos que permita organizar la información de usuarios, estudiantes, asignaturas, grupos y matrículas, estableciendo las relaciones y restricciones necesarias para garantizar la integridad de los datos.

- Desarrollar módulos de gestión que permitan realizar operaciones de registro, consulta, actualización y eliminación de asignaturas, grupos y estudiantes, de acuerdo con los permisos del administrador.

- Implementar el módulo de matrícula para registrar estudiantes en uno o varios grupos académicos, considerando el periodo correspondiente y la disponibilidad de cupos.

- Desarrollar funcionalidades de consulta que permitan al administrador revisar el historial de matrículas de los estudiantes y a cada estudiante consultar su propia información académica, conforme a sus permisos de acceso.

- Implementar un sistema de autenticación y autorización con roles diferenciados de Administrador y Estudiante, garantizando el acceso a las funcionalidades correspondientes a cada tipo de usuario.

- Incorporar un mecanismo de activación de cuentas mediante correo electrónico que permita a los estudiantes establecer sus propias contraseñas de manera segura.

### 6. Alcance del Proyecto

El sistema abarcará la digitalización y centralización de los principales procesos administrativos relacionados con la gestión de matrículas académicas del Instituto Educativo Horizonte.

La aplicación estará desarrollada como un sistema web utilizando Laravel, con una base de datos relacional y una interfaz construida mediante las tecnologías de presentación del framework.

**Incluye:**

- **Gestión de usuarios:** Administración de las cuentas de acceso mediante roles de Administrador y Estudiante. El administrador podrá crear las cuentas de los estudiantes y gestionar su acceso al sistema.

- **Activación de cuentas:** Envío de enlaces de activación al correo electrónico de los estudiantes para que puedan establecer sus propias contraseñas.

- **Gestión de estudiantes:** Registro, consulta y actualización de los perfiles de los estudiantes, incluyendo sus datos de identificación y personales.

- **Gestión de asignaturas:** Administración del catálogo académico, incluyendo códigos, nombres y créditos de las asignaturas.

- **Gestión de grupos:** Creación y administración de grupos asociados a las asignaturas, estableciendo su capacidad máxima de estudiantes.

- **Gestión de matrículas:** Registro de matrículas asociadas a los estudiantes y a uno o varios grupos académicos para un periodo determinado.

- **Control de cupos:** Validación de la disponibilidad de los grupos antes de registrar una matrícula y actualización de su ocupación.

- **Consulta de matrículas:** Visualización del historial y los detalles de las matrículas, con restricciones de acceso según el rol del usuario.

- **Autenticación y autorización:** Inicio y cierre de sesión, protección de rutas y control de acceso a los módulos según los permisos establecidos.

**No incluye:**

- Pasarelas de pago electrónico ni procesamiento de pagos de matrícula.
- Desarrollo de aulas virtuales o plataformas de educación en línea.
- Liquidación de nómina docente o administrativa.
- Registro, seguimiento y publicación de calificaciones académicas.
- Gestión de horarios de clases y asistencia de estudiantes.
- Administración de procesos de contratación o gestión del personal docente.
- Integración con plataformas externas de gestión académica que no formen parte del alcance definido.

---

### 7. Tecnologías y Herramientas

Para el desarrollo del sistema se emplean las siguientes tecnologías y herramientas:

- **Laravel:** Framework PHP utilizado para implementar la lógica del sistema siguiendo el patrón arquitectónico Modelo-Vista-Controlador (MVC).
- **PHP:** Lenguaje de programación utilizado en el desarrollo del backend.
- **MySQL:** Sistema de gestión de bases de datos relacional para almacenar la información académica y administrativa.
- **Blade:** Motor de plantillas de Laravel utilizado para construir las interfaces del sistema.
- **HTML, CSS y JavaScript:** Tecnologías utilizadas para estructurar, diseñar y proporcionar interactividad a las interfaces.
- **Composer:** Administrador de dependencias utilizado para gestionar los paquetes y componentes de PHP.
- **Git:** Sistema de control de versiones utilizado para gestionar los cambios realizados durante el desarrollo del proyecto.