## Docs

- Este código requiere que PHP y Node.js y Mysql estén instalados en tu sistema.
-
- Versión de PHP requerida: 7.4 o superior
- Versión de Node.js requerida: 16 o superior
- Versión de Mysql Client requerida: 8 o superior
-
- Además, asegúrate de tener un archivo php.ini configurado correctamente.
-
- Habilita la extensión MySQL en tu archivo php.ini descomentando la siguiente línea:
- extension=pdo_mysql.
-
- Esta extensión es necesaria para conectarse a una base de datos MySQL de forma segura y flexible.

### Backend

Para ejecutar el backend, sigue estos pasos:

1. Abre una terminal y navega hasta la carpeta "backend".
2. Ejecuta el siguiente comando para iniciar el servidor PHP en el puerto 8000:
   ```
   php -S localhost:8000
   ```

### Base de datos

Antes de ejecutar el backend, asegúrate de configurar la base de datos siguiendo estos pasos:

1. Abre una terminal y navega hasta la carpeta "backend".
2. Ejecuta el siguiente comando para crear la base de datos y las tablas necesarias:
   ```
   mysql -u <usuario> -p < init.sql
   ```
   Reemplaza `<usuario>` con tu nombre de usuario de MySQL y asegúrate de tener el archivo `init.sql` en la carpeta "backend".

**Se utilizo el usuario: root y password: root**

### Frontend

Para ejecutar el frontend, sigue estos pasos:

1. Abre otra terminal y navega hasta la carpeta "frontend".
2. Ejecuta el siguiente comando para instalar las dependencias:
   ```
   npm install
   ```
3. Luego, ejecuta el siguiente comando para iniciar la aplicación en el puerto 3000:
   ```
   npm start
   ```

Ten en cuenta que el backend se ejecuta en el puerto 8000 y el frontend en el puerto 3000.
