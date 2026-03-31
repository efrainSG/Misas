# Especificación de las tablas
```uml
Ciudades := <#Id, *Nombre>
Roles := <#Id, *Nombre, Descripcion>
TipoLocaciones := <#Id, *Nombre, Descripcion>
Colonias := <#Id, *Nombre, *CiudadId>
Usuarios := <#Id, *Usuario, *Nombre, *Password, *RolId>
Locaciones := <#Id, *Nombre, *Direccion, *ColoniaId, Telefono, *TipoLocacionId>
UsuariosLocaciones := <#Id, *UsuarioId, *LocacionId>
Horarios := <#Id, *LocacionId, *DiaSemana, *Hora, *Activo, Notas>
```
# Especificación de las relaciones
```uml
Roles - 1:N - Usuarios
TipoLocaciones - 1:N - Locaciones
Ciudades - 1:N - Colonias
Colonias - 1:N - Locaciones
Usuarios - 1:N - UsuariosLocaciones
Locaciones - 1:N - UsuariosLocaciones
```
# Diccionario de datos
```sql
Id: INT AUT_INCREMENT
Usuario: VARCHAR(20) -- Nombre fácil de recordar, como "juanitasanjuan", "efrainlamargarita", o algo que los usuarios definan, y sí, será único.
Nombre: VARCHAR(100)
Descripcion: VARCHAR(255)
Password: VARCHAR(255) -- encriptado
RolId: INT
Direccion: VARCHAR(500)
Telefono: VARCHAR(20)
TipoLocacionId: INT
CiudadId: INT
ColoniaId: INT
UsuarioId: INT
LocacionId: INT
DiaSemana: TINYINT
Hora: TIME -- Gracias por el consejo
Activo: TINYINT(1)
Notas: TEXT
```

## Especificación de índices y criterios de unicidad
```uml
Roles UNIQUE(Nombre)
TiposLocaciones UNIQUE(Nombre)
Usuarios UNIQUE(Usuario)
Locaciones UNIQUE(Nombre, TipoLocacionId, ColoniaId) -- En una colonia no existen dos locaciones del mismo tipo con el mismo nombre. Causa confusión real en los feligreses.
Horarios UNIQUE(LocacionId, DiaSemana, Hora)

Locaciones INDEX (Nombre)
Horarios INDEX (LocacionId, DiaSemana)
Horarios INDEX (DiaSemana, Hora)
```