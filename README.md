# Hotel Oasis

Un proyecto de página web para un hotel creado con PHP, Tailwindcss y JavaScript

## Estructura

- **config.php**: Archivo donde se encuentran las configuraciones de la página
- **routes.php**: Archivo donde se encuentran las rutas de la página
- **/public/index.php**: Archivo principal de la página
- **public/css**: Carpeta donde se encuentra images, fonts, output.css y index.css
- **public/fonts**: Carpeta donde se encuentran las fuentes de la página
- **public/images**: Carpeta donde se encuentran las imágenes de la página
- **Http/controllers**: Carpeta donde se encuentran los controladores de la página. Esto es para manejar las peticiones del usuario
- **views**: Carpeta donde se encuentran las vistas de la página. Esto es para mostrar la información al usuario junto con los controladores
- **views/partials**: Carpeta donde se encuentran las vistas parciales de la página. Esto es para reutilizar código como componentes
- **Core**: Carpeta donde se encuentran las clases principales de la página. Esto es para manejar las rutas entre otras cosas

_Archivos que no se tocan_

- **node_modules**: Carpeta donde se encuentran las dependencias de Node.js
- **vendor**: Carpeta donde se encuentran las dependencias de Composer

## Instalación

1. Clonar el repositorio
2. Abrir la terminal en la carpeta del proyecto
3. Instalar [Node.js](https://nodejs.org/es/) si no lo tienes instalado
4. Instalar pnpm abriendo una terminal fuera de tu editor de código (cmd)
5. Ejecutar el siguiente comando

```bash
# cmd
corepack enable pnpm
```

6. Instalar plugin de [Tailwindcss](https://marketplace.visualstudio.com/items?itemName=bradlc.vscode-tailwindcss) para VSCode
7. Instalar las dependencias de Node.js en la carpeta del proyecto con una terminal dentro de tu editor de código

```bash
# /hoteloasis
pnpm install
```

8. Instalar [PHP](https://www.php.net/manual/en/install.windows.php) si no lo tienes instalado
9. Instalar [Composer](https://getcomposer.org/Composer-Setup.exe) si no lo tienes instalado
10. Instalar las dependencias de Composer en la carpeta del proyecto con una terminal dentro de tu editor de código

```bash
# /hoteloasis
composer install
```

```bash
# /hoteloasis
pnpm install sweetalert2
```

## Desarrollo

1. Descargar cambios de la rama de desarrollo

```bash
git pull
```

2. Iniciar tailwindcss en la carpeta del proyecto

```bash
# /hoteloasis
npx tailwindcss -i ./public/css/index.css -o ./public/css/output.css --watch
```

3. Abrir otra terminal y ejecutar el servidor de PHP en la carpeta `public` del proyecto

```bash
# /hoteloasis/public
php -S localhost:8000
```

4. Abrir el navegador y entrar a [localhost:8000](http://localhost:8000)

## Subir cambios

1. Agregar los cambios

```bash
git add .
```

2. Hacer commit

- tweak: cambios pequeños
- feat: cambios grandes
- fix: corrección de errores
- refactor: refactorización de código

```bash
git commit -m "feat: cosa que se hizo"
```

4. Subir los cambios

```bash
git push
```

## Documentación

- [Tailwindcss](https://tailwindcss.com/docs)
- [PHP](https://www.php.net/docs.php)
- [PNPM](https://pnpm.io/installation#using-corepack)
- [Git](https://git-scm.com/doc)
- [Composer](https://getcomposer.org/doc/)
- [Si no entiendes nada entra aquí](https://youtu.be/dQw4w9WgXcQ?si=L8k8Z0ju-gAdUVsv)
