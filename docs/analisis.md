# Etapa 2: Análisis del Sistema

## 1. Identificación de Actores y Usuarios del Sistema
Los actores representan los roles que interactuarán directamente con el sistema. Se definen en función de sus niveles de acceso y responsabilidades dentro de la institución.

*   **Administrador:** Usuario con privilegios absolutos. Es responsable de parametrizar el sistema. Sus funciones abarcan la gestión del catálogo de asignaturas, la creación de grupos académicos y la administración de los usuarios del sistema (creación de cuentas para funcionarios).
*   **Funcionario Académico:** Usuario de carácter operativo. Es el encargado de la atención directa a las necesidades académicas del alumno. Sus funciones principales incluyen la gestión de la información de los estudiantes y la ejecución de los procesos de matrícula.

---

## 2. Requerimientos Funcionales (RF)
Detallan los comportamientos y servicios específicos que el sistema debe proveer de forma obligatoria.

| ID | Descripción del Requerimiento | Prioridad | Actor |
| :--- | :--- | :--- | :--- |
| **RF-01** | El sistema debe permitir iniciar y cerrar sesión validando credenciales (email y contraseña). | Alta | Todos |
| **RF-02** | El sistema debe permitir registrar, consultar, modificar y eliminar (CRUD) asignaturas académicas. | Alta | Administrador |
| **RF-03** | El sistema debe permitir gestionar grupos, asignándolos a una asignatura y definiendo su capacidad máxima (cupos). | Alta | Administrador |
| **RF-04** | El sistema debe permitir registrar, consultar, actualizar y desactivar perfiles de estudiantes. | Alta | Funcionario |
| **RF-05** | El sistema debe permitir registrar una matrícula asociando a un estudiante activo con uno o múltiples grupos. | Alta | Funcionario |
| **RF-06** | El sistema debe validar que existan cupos disponibles en un grupo antes de permitir la inscripción de un estudiante. | Alta | Sistema |
| **RF-07** | El sistema debe descontar automáticamente un cupo del grupo una vez la matrícula se haya guardado exitosamente. | Alta | Sistema |
| **RF-08** | El sistema debe permitir consultar el historial de matrículas buscando por el documento de identidad del estudiante. | Media | Funcionario / Admin |

---

## 3. Requerimientos No Funcionales (RNF)
Especifican los criterios de calidad, restricciones técnicas y estándares de arquitectura del sistema.

*   **RNF-01 (Arquitectura):** El sistema debe ser desarrollado estrictamente bajo el patrón arquitectónico Modelo-Vista-Controlador (MVC) utilizando el framework PHP Laravel.
*   **RNF-02 (Seguridad - Autenticación):** Las contraseñas de los usuarios deben ser almacenadas utilizando algoritmos de encriptación seguros (Bcrypt/Hash) propios de Laravel.
*   **RNF-03 (Seguridad - Autorización):** El acceso a los módulos de configuración (Asignaturas, Grupos) debe estar restringido mediante *Middleware* exclusivo para el rol "Administrador".
*   **RNF-04 (Seguridad - Integridad):** Todos los formularios del sistema deben implementar tokens de protección contra ataques de falsificación de peticiones en sitios cruzados (CSRF).
*   **RNF-05 (Usabilidad):** Las interfaces deben construirse utilizando el motor de plantillas Blade de Laravel, garantizando validación de datos en el servidor (Form Requests) y mostrando mensajes de retroalimentación claros ante errores.
*   **RNF-06 (Gestión de Datos):** La estructura de la base de datos debe ser versionada y construida a través de *Migrations* en Laravel.

---

## 4. Especificación de Casos de Uso Principales

A continuación se detallan los flujos de los dos procesos críticos del módulo principal de matrículas.

### CU-01: Registrar Matrícula
*   **Actor Principal:** Funcionario Académico.
*   **Descripción:** Permite oficializar la inscripción de un estudiante en los grupos de diferentes asignaturas para un periodo determinado.
*   **Precondiciones:** El estudiante debe existir en el sistema. Los grupos deben estar creados y tener cupos mayor a cero. El Funcionario debe estar autenticado.
*   **Postcondiciones:** Se genera un registro de matrícula, se asocia el estudiante a los grupos seleccionados y se actualiza (resta) la cantidad de cupos disponibles en dichos grupos.
*   **Flujo Principal (Éxito):**
    1. El Funcionario selecciona la opción "Nueva Matrícula".
    2. El sistema muestra un formulario solicitando el ID del estudiante.
    3. El Funcionario ingresa el ID y el sistema carga los datos del estudiante y el listado de grupos disponibles.
    4. El Funcionario selecciona los grupos a matricular y confirma la operación.
    5. El sistema valida la disponibilidad de cupos en tiempo real.
    6. El sistema guarda la matrícula en la base de datos.
    7. El sistema muestra un mensaje de "Matrícula registrada exitosamente".
*   **Flujos Alternativos:**
    *   *5a. Cupos Insuficientes:* Si un grupo seleccionado ya no tiene cupos, el sistema aborta la transacción de guardado, muestra un mensaje de error ("El grupo X no tiene cupos disponibles") y devuelve al usuario al paso 4.

### CU-02: Consultar Matrícula
*   **Actor Principal:** Funcionario Académico (también accesible para Administrador).
*   **Descripción:** Permite visualizar los detalles de las matrículas registradas a nombre de un estudiante específico.
*   **Precondiciones:** El usuario debe estar autenticado. Debe existir al menos una matrícula registrada para el estudiante consultado.
*   **Postcondiciones:** Ninguna (Operación de solo lectura).
*   **Flujo Principal (Éxito):**
    1. El Actor ingresa al módulo de "Consulta de Matrículas".
    2. El sistema muestra una barra de búsqueda.
    3. El Actor ingresa el número de documento del estudiante y ejecuta la búsqueda.
    4. El sistema valida el documento y retorna el historial del estudiante.
    5. El Actor hace clic en una matrícula específica.
    6. El sistema despliega el detalle completo: Fecha de registro, asignaturas, grupos asociados y el nombre del funcionario que procesó el registro.
*   **Flujos Alternativos:**
    *   *4a. Estudiante sin matrículas / No encontrado:* Si el documento no existe o no tiene registros asociados, el sistema muestra el mensaje "No se encontraron matrículas para el documento ingresado" y permite realizar una nueva búsqueda (regresa al paso 2).