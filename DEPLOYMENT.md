# Diagnostic Centre & Doctor Chamber Management System
## Deployment Guide for Endor LAMP Runtime

### System Requirements
- PHP 8.3+
- MySQL 8.0+
- Composer
- Node.js 18+
- Redis (optional, for queues)
- Supervisor (for queue worker)

### Quick Deployment on Endor LAMP

1. **Clone the repository**
```bash
git clone <repository-url> /var/www/diagnostic
cd /var/www/diagnostic
```

2. **Environment Setup**
```bash
cp .env.example .env
php artisan key:generate
```
Edit `.env` file with your database credentials and app settings.

3. **Database Setup**
```bash
php artisan migrate --seed
```

4. **Storage & Permissions**
```bash
php artisan storage:link
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

5. **Queue Setup (Supervisor)**
```bash
sudo cp supervisor/diagnostic-worker.conf /etc/supervisor/conf.d/
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start diagnostic-worker:*
```

6. **Cron Setup**
```bash
crontab -e
# Add: * * * * * cd /var/www/diagnostic && php artisan schedule:run >> /dev/null 2>&1
```

### Nginx Configuration
```nginx
server {
    listen 80;
    server_name diagnostic.example.com;
    root /var/www/diagnostic/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;
    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

### Endor LAMP Runtime Deployment
```yaml
# endor-runtime.yml
runtime: lamp
php: 8.3
mysql: 8.0
composer: true
node: 18
redis: true

env:
  APP_ENV: production
  APP_DEBUG: false
  DB_CONNECTION: mysql

hooks:
  build:
    - composer install --no-dev --optimize-autoloader
    - npm install && npm run build
    - php artisan optimize
    - php artisan storage:link
  
  deploy:
    - php artisan migrate --force
    - php artisan config:cache
    - php artisan route:cache
    - php artisan view:cache

cron:
  - command: "php artisan schedule:run"
    frequency: "* * * * *"

workers:
  - command: "php artisan queue:work --sleep=3 --tries=3 --max-time=3600"
    processes: 2
```

### Post-Deployment Steps
1. **Create Super Admin**: Login and create first admin user
2. **Configure Branches**: Add main branch configuration
3. **Setup Services**: Add diagnostic services and test categories
4. **Add Doctors**: Register doctors with schedules
5. **Configure SMS**: Set up SMS provider credentials
6. **Configure Storage**: Set up S3 or local storage for reports

### Backup Strategy
```bash
# Daily backup script
#!/bin/bash
BACKUP_DIR="/backups/diagnostic"
DATE=$(date +%Y%m%d_%H%M%S)
mysqldump -u root -p diagnostic_centre > $BACKUP_DIR/db_$DATE.sql
tar -czf $BACKUP_DIR/files_$DATE.tar.gz storage/app/public
php artisan backup:run

# Keep backups for 30 days
find $BACKUP_DIR -type f -mtime +30 -delete
```

### Monitoring
- Configure Laravel Telescope or Log viewer
- Set up health checks: `/health` endpoint
- Monitor queue worker with Supervisor
- Configure error reporting (Sentry/Flare)

### Security Checklist
- [x] HTTPS enabled
- [x] Environment variables secured
- [x] Debug mode disabled
- [x] File permissions restricted
- [x] Database access restricted
- [x] API rate limiting enabled
- [x] CORS configured properly
- [x] Session security configured
- [x] Two-factor authentication ready

### Troubleshooting

**Issue**: 500 Internal Server Error
```bash
# Check logs
tail -f storage/logs/laravel.log
# Fix permissions
chmod -R 775 storage bootstrap/cache
```

**Issue**: Database Connection Failed
```bash
# Check MySQL status
systemctl status mysql
# Verify credentials in .env
```

**Issue**: Queue Not Processing
```bash
# Check supervisor status
sudo supervisorctl status
# Restart worker
sudo supervisorctl restart diagnostic-worker:*
```

### Performance Optimization
- Enable OPcache in PHP
- Use Redis for cache and sessions
- Enable query cache in MySQL
- Optimize images with Intervention
- Use CDN for static assets
- Implement database query optimization

### Version
1.0.0 - Production Ready

### Support
For technical support, contact: support@diagnostic.com