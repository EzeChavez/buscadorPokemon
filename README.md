La WebApp se puede ver funcionando en la siguiente dirección https://ezechavez.tech/
Opción 1
Para utilizar la WebApp en un entorno de prueba seguir los siguientes pasos.
1. Descargar el repositorio desde https://github.com/EzeChavez/buscadorPokemon
2.Ejecutar Xampp o habilitar el servidor local para poder trabajar con phpMyAdmin. En el caso de utilizar Xampp habilitar MySql y Apache.
3.Instalar composer en el repositorio descargado. Primero abrir el repositorio con VsCode y despues ejecutar en un terminal composer intall
4.Ejecutar la migracion para crear la BD (php artisan migrate) o importarla directamente desde el archivo pokemon.sql
5. Modificar el archivo .env que se encuentra en la raiz del repositorio y colocar el nombre de la bd, usuario y clave de acceso por defecto:
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pokemon
DB_USERNAME=root
DB_PASSWORD=

5. Acceder directamente al sitio local ejecutanto php artisan serve en el terminal de vsCode

Nota. Es necesario tener una version >= 8.2 de PHP en el servidor.

