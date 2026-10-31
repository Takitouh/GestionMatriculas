Diagrama Entidad-Relación (ER)

A continuación se presenta el modelo relacional de la base de datos diseñado para el Sistema de Gestión de Matrículas. El diagrama detalla las entidades principales, sus atributos clave y la cardinalidad de sus relaciones.

erDiagram
    %% Relaciones
    USERS ||--o{ MATRICULAS : "registra (funcionario)"
    ESTUDIANTES ||--o{ MATRICULAS : "tiene"
    ASIGNATURAS ||--o{ GRUPOS : "se divide en"
    MATRICULAS ||--|{ MATRICULA_GRUPO : "incluye"
    GRUPOS ||--o{ MATRICULA_GRUPO : "inscrito en"

    %% Entidades y Atributos
    USERS {
        bigint id PK
        string name
        string email UK
        string password
        string role "Enum: admin, funcionario"
        timestamp created_at
    }

    ESTUDIANTES {
        bigint id PK
        string documento UK
        string nombre
        string apellido
        string email UK
        string telefono
        boolean estado "Activo / Inactivo"
        timestamp created_at
    }

    ASIGNATURAS {
        bigint id PK
        string codigo UK
        string nombre
        integer creditos
        timestamp created_at
    }

    GRUPOS {
        bigint id PK
        bigint asignatura_id FK
        string codigo_grupo
        integer cupo_maximo
        integer cupo_disponible
        timestamp created_at
    }

    MATRICULAS {
        bigint id PK
        bigint estudiante_id FK
        bigint user_id FK
        date fecha_matricula
        string periodo_academico
        timestamp created_at
    }

    %% Tabla Pivote para relación Muchos a Muchos
    MATRICULA_GRUPO {
        bigint matricula_id FK
        bigint grupo_id FK
    }
