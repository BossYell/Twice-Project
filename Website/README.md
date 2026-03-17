TWICE fan-themed mini-site

Simple, modern single-page site built with PHP, HTML, CSS and a bit of JavaScript for animations.

Files created:
- index.php — entry point (PHP) that renders the members and a greeting
- assets/css/style.css — modern CSS, responsive layout, animations and shimmer
- assets/js/main.js — lightweight confetti particle animation used on button clicks

How to run locally (requires PHP):

1. Open a terminal (PowerShell on Windows) in the project folder `c:\Users\uriel\OneDrive\Desktop\Website`
2. Start PHP built-in server:

```powershell
php -S localhost:8000
```

3. Open http://localhost:8000 in your browser.

Notes and next steps:
- No copyrighted images are included. Replace avatars with photos if you have the rights.
- You can expand the PHP (templating, contact form) or convert to a full theme.

Alternative (no PHP required)

- A static fallback `index.html` is included. If PHP isn't installed or you prefer not to run a PHP server, just open `index.html` in your browser (double-click or File -> Open).

If you want to run `index.php` but see an error like "'php' is not recognized", PHP isn't in your PATH. Quick options on Windows:

- Install PHP via Chocolatey (if you have Chocolatey):

```powershell
choco install php -y
```

- Install XAMPP or WampServer (bundled Apache+PHP) and place the project in their `htdocs`/www folder, or start the bundled server and point it to this folder.

- Download PHP from https://windows.php.net/download and add the PHP installation folder to your PATH.

After installing PHP, you can run the built-in server from this folder:

```powershell
php -S localhost:8000 -t "c:\\Users\\uriel\\OneDrive\\Desktop\\Website"
```
