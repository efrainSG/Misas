# Mi compresión

Por lo que entiendo, Laravel es un Framework de PHP que me permite crear aplicaciones web MVC. Me ayuda generando la API y demás componentes.

Mi experiencia me ha mostrado las capacidades de PHP: tipado, gramática clara, diseño eficiente, OOP, conexiones a BB. DD., servicios web (SOAP) y manejo de JSON.

# Laravel en Docker

Con el siguiente comando estoy creando mi proyecto de Laravel mediante Docker
```PS
docker run --rm -v ${PWD}:/app -w /app laravelsail/php84-composer:latest composer create-project laravel/laravel mi-proyecto-api
```

Luego, dentro del proyecto de la API.

Con el siguiente comando estoy instalando Laravel Sail mediante imágenes de Docker
```PS
docker run --rm -v ${PWD}:/app -w /app laravelsail/php84-composer:latest composer require laravel/sail --dev
```

Con este comando estoy instalando Sail para Laravel
```PS
docker run --rm -v ${PWD}:/app -w /app laravelsail/php84-composer:latest php artisan sail:install
```

Tuve que actualizar mi archivo **.env** agregando los siguientes datos al final, si es que no existen:
> WWWGROUP=1000

> WWWUSER=1000

Como ya tengo una instancia de mySql corriendo en otro contenedor y no requiero el mySQl de Sail, modifico el archivo *compose.yaml* ubicado en la carpeta de mi API para eliminar todo el bloque del servicio de **mysql**.

Después, tuve que ejecutar este comando
```PS
docker compose up -d
```

Entonces, obtuve un mensaje de error por problema de permisos en el contenedor. Mismo que de momento resolví con esto:
```bash
docker exec -it misas-api-laravel.test-1 bash
chmod -R 777 storage
chmod -R 777 bootstrap/cache
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

Mencionado previamente que requería mi instancia propia de **mysql**. Entonces actualicé la configuración del archivo **.env** de esta forma:
> DB_CONNECTION=mysql
> DB_HOST=host.docker.internal
> DB_PORT=3306
> DB_DATABASE=mi_db
> DB_USERNAME=mi_user
> DB_PASSWORD=mi_pass

# Construyendo...
## Creación de controladores
> Recordando que todo está manejado por contenedores de *Docker*, la mayoría (si no es que todos) de los comandos están escritos para ser ejecutados hacia Docker desde *PowerShell*.

```PS
docker exec -it misas-api-laravel.test-1 php artisan make:controller LocacionController