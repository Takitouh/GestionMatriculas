# Etapa 2: Análisis del Sistema

## 1. Identificación de Actores y Usuarios del Sistema

Los actores representan los roles que interactúan directamente con el sistema. Se definen de acuerdo con sus niveles de acceso y responsabilidades dentro de la gestión académica.

**Administrador:**

Usuario con privilegios administrativos encargado de configurar y gestionar los recursos académicos del sistema. Sus responsabilidades incluyen la administración del catálogo de asignaturas, la creación y gestión de grupos académicos, la administración de los perfiles de estudiantes y la ejecución de los procesos de matrícula. También es responsable de crear las cuentas de acceso de los estudiantes y gestionar el envío de los enlaces de activación.

**Estudiante:**

Usuario que accede al sistema mediante una cuenta creada previamente por el administrador. Para habilitar su acceso, recibe un enlace de activación en su correo electrónico, mediante el cual establece su propia contraseña. Una vez activada su cuenta, puede autenticarse y acceder a la información académica que le corresponda, sin disponer de permisos para modificar la configuración general del sistema ni administrar otros estudiantes.

---

## 2. Requerimientos Funcionales (RF)

Detallan los comportamientos y servicios específicos que el sistema debe proporcionar para cumplir con los objetivos de la gestión académica.

| ID | Descripción del Requerimiento | Prioridad | Actor |
| :--- | :--- | :--- | :--- |
| **RF-01** | El sistema debe permitir iniciar y cerrar sesión mediante la validación de las credenciales del usuario (correo electrónico y contraseña). | Alta | Todos |
| **RF-02** | El sistema debe permitir registrar, consultar, modificar y eliminar asignaturas académicas. | Alta | Administrador |
| **RF-03** | El sistema debe permitir gestionar grupos académicos, asociándolos a una asignatura y estableciendo su capacidad máxima de estudiantes. | Alta | Administrador |
| **RF-04** | El sistema debe permitir registrar, consultar, actualizar y desactivar los perfiles de los estudiantes. | Alta | Administrador |
| **RF-05** | El sistema debe permitir al administrador crear una cuenta de usuario asociada al perfil de un estudiante, utilizando sus datos de identificación y correo electrónico. | Alta | Administrador |
| **RF-06** | El sistema debe enviar al correo electrónico del estudiante un enlace seguro de activación para que pueda establecer su contraseña y habilitar su cuenta de acceso. | Alta | Sistema |
| **RF-07** | El sistema debe permitir registrar una matrícula asociando a un estudiante con uno o varios grupos académicos para un periodo determinado. | Alta | Administrador |
| **RF-08** | El sistema debe validar que los grupos seleccionados tengan cupos disponibles antes de confirmar una matrícula. | Alta | Sistema |
| **RF-09** | El sistema debe actualizar la ocupación y disponibilidad de los grupos de acuerdo con las matrículas registradas, evitando superar su capacidad máxima. | Alta | Sistema |
| **RF-10** | El sistema debe permitir consultar el historial de matrículas de un estudiante mediante su número de documento de identidad. | Media | Administrador |
| **RF-11** | El sistema debe restringir el acceso de los estudiantes a la información académica que les corresponde, impidiendo que consulten o modifiquen información de otros estudiantes. | Alta | Sistema |

---

## 3. Requerimientos No Funcionales (RNF)

Especifican los criterios de calidad, las restricciones técnicas y los estándares de seguridad y arquitectura que debe cumplir el sistema.

**RNF-01 (Arquitectura):** El sistema debe desarrollarse utilizando el patrón arquitectónico Modelo-Vista-Controlador (MVC), implementado mediante el framework PHP Laravel.

**RNF-02 (Seguridad - Autenticación):** Las contraseñas de los usuarios deben almacenarse mediante mecanismos seguros de hashing, utilizando las funcionalidades proporcionadas por Laravel, como Bcrypt o Argon2.

**RNF-03 (Seguridad - Autorización):** El acceso a los módulos administrativos, como la gestión de asignaturas, grupos, estudiantes y matrículas, debe estar restringido mediante mecanismos de autorización y middleware que permitan el acceso únicamente a los usuarios con el rol correspondiente.

**RNF-04 (Seguridad - Integridad):** Los formularios que ejecuten operaciones de modificación de información deben implementar tokens de protección contra ataques de falsificación de peticiones en sitios cruzados (CSRF).

**RNF-05 (Usabilidad):** Las interfaces deben construirse utilizando el motor de plantillas Blade de Laravel. Deben proporcionar validación de datos en el servidor y presentar mensajes claros de confirmación, advertencia y error para facilitar la interacción del usuario.

**RNF-06 (Gestión de Datos):** La estructura de la base de datos debe estar versionada y administrada mediante migraciones (*Migrations*) de Laravel, garantizando la consistencia de las tablas y sus relaciones.

**RNF-07 (Seguridad - Activación de Cuentas):** El proceso de activación de cuentas debe utilizar enlaces con tokens de seguridad para permitir que cada estudiante establezca su contraseña sin que esta sea asignada o conocida por el administrador. Los tokens deben gestionarse mediante los mecanismos de autenticación y restablecimiento de contraseñas de Laravel.

**RNF-08 (Integridad Referencial):** La base de datos debe garantizar la integridad de las relaciones entre usuarios, estudiantes, matrículas, asignaturas y grupos mediante claves primarias, claves foráneas y restricciones de integridad.

**RNF-09 (Control de Acceso):** El sistema debe garantizar que cada usuario únicamente pueda realizar las operaciones autorizadas para su rol, protegiendo especialmente la información personal y académica de los estudiantes.

---

## 4. Especificación de Casos de Uso Principales

A continuación, se detallan los flujos de los procesos principales del sistema: activación de cuentas, registro de matrículas y consulta de información académica.

### CU-01: Activar Cuenta de Estudiante

**Actor Principal:** Estudiante.

**Descripción:** Permite que un estudiante habilite su cuenta de acceso al sistema mediante un enlace de activación enviado previamente a su correo electrónico por solicitud del administrador.

**Precondiciones:**
- El administrador debe haber creado el perfil del estudiante y su cuenta de usuario.
- El correo electrónico del estudiante debe estar registrado correctamente.
- El estudiante debe haber recibido el enlace de activación.

**Postcondiciones:**
- La contraseña del usuario queda establecida de forma segura.
- La cuenta queda habilitada para iniciar sesión, de acuerdo con el estado de verificación configurado por el sistema.

**Flujo Principal (Éxito):**

1. El administrador registra los datos del estudiante y crea su cuenta de usuario.
2. El sistema genera y envía un enlace de activación al correo electrónico registrado.
3. El estudiante accede a su bandeja de entrada y abre el enlace recibido.
4. El sistema valida el token de activación.
5. El sistema presenta un formulario para establecer una contraseña.
6. El estudiante ingresa y confirma su nueva contraseña.
7. El sistema valida y almacena la contraseña mediante un mecanismo seguro de hashing.
8. El sistema confirma que la cuenta ha sido activada correctamente.

**Flujos Alternativos:**

- **4a. Enlace inválido o expirado:** Si el token no es válido o ya no está vigente, el sistema rechaza la operación y muestra un mensaje informativo. El estudiante deberá solicitar al administrador que gestione un nuevo enlace de activación.

- **2a. Error en el envío del correo:** Si ocurre un problema durante el envío de la notificación, el sistema informa que no fue posible enviar el enlace para que el administrador pueda gestionar el inconveniente.

### CU-02: Registrar Matrícula

**Actor Principal:** Administrador.

**Descripción:** Permite registrar oficialmente la inscripción de un estudiante en uno o varios grupos de diferentes asignaturas para un periodo académico determinado.

**Precondiciones:**
- El administrador debe estar autenticado.
- El estudiante debe existir en el sistema y contar con un perfil habilitado.
- Las asignaturas y los grupos correspondientes deben estar registrados.
- Los grupos seleccionados deben disponer de cupos suficientes.

**Postcondiciones:**
- Se genera un registro de matrícula asociado al estudiante y al periodo académico.
- Se establecen las relaciones entre la matrícula y los grupos seleccionados.
- La ocupación y disponibilidad de los grupos se actualizan de acuerdo con las nuevas inscripciones.

**Flujo Principal (Éxito):**

1. El administrador ingresa al módulo de matrículas y selecciona la opción "Nueva Matrícula".
2. El sistema presenta un formulario para identificar al estudiante.
3. El administrador ingresa el número de documento de identidad.
4. El sistema busca y muestra la información del estudiante correspondiente.
5. El sistema presenta las asignaturas y sus grupos disponibles.
6. El administrador selecciona los grupos en los que se inscribirá el estudiante.
7. El administrador confirma el registro de la matrícula.
8. El sistema valida la disponibilidad de cupos en todos los grupos seleccionados.
9. El sistema guarda la matrícula y asocia los grupos seleccionados.
10. El sistema actualiza la ocupación de los grupos y refleja los cupos disponibles.
11. El sistema muestra un mensaje de confirmación: "Matrícula registrada exitosamente".

**Flujos Alternativos:**

- **3a. Estudiante no encontrado:** Si el documento ingresado no corresponde a ningún estudiante registrado, el sistema muestra un mensaje indicando que no se encontró el estudiante y permite realizar una nueva búsqueda.

- **8a. Cupos insuficientes:** Si alguno de los grupos seleccionados no dispone de cupos, el sistema impide confirmar la matrícula, muestra un mensaje identificando el grupo sin disponibilidad y permite al administrador modificar la selección.

- **9a. Error durante el registro:** Si ocurre un error al guardar la matrícula o sus asociaciones, el sistema debe evitar que la operación quede registrada parcialmente y notificar al administrador que no fue posible completar el proceso.

### CU-03: Consultar Matrícula

**Actor Principal:** Administrador.

**Actor Secundario:** Estudiante.

**Descripción:** Permite consultar la información de las matrículas registradas en el sistema. El administrador puede buscar el historial académico de cualquier estudiante mediante su documento de identidad. El estudiante únicamente puede acceder a la información asociada a su propia cuenta.

**Precondiciones:**
- El usuario debe estar autenticado.
- Para realizar una consulta, debe existir un perfil de estudiante registrado.
- El estudiante consultado debe tener matrículas registradas para visualizar su historial.

**Postcondiciones:**
- El sistema presenta la información académica correspondiente al usuario autorizado.
- No se modifica ningún registro de la base de datos.

**Flujo Principal (Éxito):**

1. El administrador ingresa al módulo de "Consulta de Matrículas". El estudiante accede a la sección de consulta de su información académica.
2. Si se trata del administrador, el sistema muestra una barra de búsqueda para ingresar el documento de identidad. Si se trata del estudiante, el sistema identifica automáticamente su perfil.
3. El administrador ingresa el documento y ejecuta la búsqueda.
4. El sistema valida la búsqueda y recupera los registros de matrícula asociados al estudiante.
5. El administrador selecciona una matrícula específica, o el estudiante consulta sus propios registros.
6. El sistema presenta el detalle disponible de la matrícula, incluyendo el periodo académico, la fecha de registro, el estado, las asignaturas y los grupos asociados.

**Flujos Alternativos:**

- **3a. Documento no encontrado:** Si el documento ingresado no corresponde a un estudiante registrado, el sistema muestra el mensaje "No se encontró un estudiante con el documento ingresado" y permite realizar una nueva búsqueda.

- **4a. Estudiante sin matrículas:** Si el estudiante existe, pero no tiene matrículas registradas, el sistema muestra el mensaje "No se encontraron matrículas para el estudiante consultado".

- **5a. Acceso no autorizado:** Si un estudiante intenta consultar información perteneciente a otro usuario, el sistema debe denegar la operación y evitar que se expongan datos académicos de terceros.

---

## 5. Consideraciones de Actualización

La actualización de esta etapa contempla las siguientes decisiones del sistema:

1. **Roles del sistema:** Se establecen dos roles principales: Administrador y Estudiante. Se elimina el rol de Funcionario Académico de la especificación.

2. **Creación de cuentas:** El administrador es responsable de crear las cuentas de los estudiantes y asociarlas con sus respectivos perfiles académicos.

3. **Activación por correo electrónico:** Los estudiantes establecen sus propias contraseñas mediante un enlace de activación enviado a su correo electrónico. El administrador no asigna ni conoce dichas contraseñas.

4. **Gestión de matrículas:** El administrador es el encargado de registrar las matrículas y asociar a los estudiantes con los grupos académicos correspondientes.

5. **Control de cupos:** La disponibilidad de los grupos se determina considerando su capacidad máxima y las matrículas asociadas. El sistema debe impedir que se supere la capacidad establecida.

6. **Restricción de acceso:** Los estudiantes pueden consultar exclusivamente su propia información académica, mientras que el administrador tiene acceso a los módulos de gestión y consulta general.