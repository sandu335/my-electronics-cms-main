Deployment checklist
====================

This file lists recommended steps and example configs for deploying the project.

1) Environment
- Copy `.env.example` to `.env` and set production values.
- `APP_ENV=production`, `APP_DEBUG=false`, set `APP_URL` to your domain.
- Configure `DB_*`, `MAIL_*`, `QUEUE_CONNECTION`, `CACHE_DRIVER`, and `SESSION_DRIVER`.

2) HTTPS (example using Certbot + nginx)
- Create nginx site config (example below).
- Obtain Let’s Encrypt cert with certbot and configure nginx to use it.

Example nginx server block (adjust root and php-fpm socket):

server {
    listen 80;
    server_name example.com www.example.com;
    root /var/www/my-electronics-cms/public;

    add_header X-Frame-Options DENY;
    add_header X-Content-Type-Options nosniff;

    index index.php index.html;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/run/php/php8.3-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.ht { deny all; }
}

3) Backups
- Use the `scripts/backup.sh` script to backup DB and `public/images` to `storage/backups/`.
- Schedule with cron or systemd timers.

4) Deploy steps (basic)
- Pull code, run `composer install --no-dev --optimize-autoloader`
- `php artisan migrate --force`
- `php artisan config:cache && php artisan route:cache && php artisan view:cache`
- Restart php-fpm and queue workers.

5) Monitoring & logs
- Configure `SENTRY_DSN` in `.env` for error reporting (optional).

Notes
- Adjust PHP-FPM socket path to your system. For Docker deployments create a Dockerfile.
