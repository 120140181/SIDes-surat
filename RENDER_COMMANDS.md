# Render.com Commands Cheat Sheet

## Akses Shell di Render

Setelah service running, buka Render Dashboard → Service → Shell tab, atau:
```bash
# Via Render CLI (install dulu: npm install -g render)
render shell
```

---

## Laravel Artisan Commands

### Database

```bash
# Show database info
php artisan db:show

# Run migrations
php artisan migrate --force

# Rollback migration
php artisan migrate:rollback --force

# Fresh migrate (drop all tables and re-migrate)
php artisan migrate:fresh --force

# Run seeder
php artisan db:seed --force
php artisan db:seed --class=UserSeeder --force
```

### Cache Management

```bash
# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Cache config for better performance
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Clear specific cache
php artisan cache:forget key_name
```

### Application

```bash
# Generate application key
php artisan key:generate --force

# Show application info
php artisan about

# Put application in maintenance mode
php artisan down
php artisan down --secret="my-secret-token"

# Bring application up
php artisan up
```

### Storage

```bash
# Create storage symlink
php artisan storage:link

# List all storage disks
php artisan storage:disk-list
```

### Queue

```bash
# Run queue worker
php artisan queue:work

# Run specific queue
php artisan queue:work --queue=high,default

# Process only one job
php artisan queue:work --once

# List failed jobs
php artisan queue:failed

# Retry failed job
php artisan queue:retry {id}
php artisan queue:retry all

# Clear failed jobs
php artisan queue:flush
```

### User Management

```bash
# Create user interactively
php artisan tinker
>>> $user = App\Models\User::create(['name' => 'Admin', 'email' => 'admin@example.com', 'password' => bcrypt('password')]);

# Reset user password
php artisan tinker
>>> $user = App\Models\User::where('email', 'admin@example.com')->first();
>>> $user->password = bcrypt('new-password');
>>> $user->save();
```

---

## Environment Management

### Check Environment Variables

```bash
# Show all env vars
printenv

# Show specific env var
echo $APP_ENV
echo $DB_HOST
echo $APP_URL

# Show Laravel config
php artisan config:show database
php artisan config:show app
```

### Update Environment Variables

1. Via Render Dashboard:
   - Service → Environment
   - Add/Edit variable
   - Save Changes → Auto redeploy

2. Via Render CLI:
   ```bash
   render env:set APP_DEBUG=false
   ```

---

## Database Commands

### MySQL Commands

```bash
# Connect to MySQL (credentials from env vars)
mysql -h $DB_HOST -u $DB_USERNAME -p$DB_PASSWORD $DB_DATABASE

# Inside MySQL:
# Show tables
SHOW TABLES;

# Describe table
DESCRIBE users;

# Show table data
SELECT * FROM users LIMIT 10;

# Count records
SELECT COUNT(*) FROM users;

# Export database
mysqldump -h $DB_HOST -u $DB_USERNAME -p$DB_PASSWORD $DB_DATABASE > backup.sql

# Import database
mysql -h $DB_HOST -u $DB_USERNAME -p$DB_PASSWORD $DB_DATABASE < backup.sql
```

---

## Logs & Debugging

### View Logs

```bash
# Laravel logs
tail -f storage/logs/laravel.log
tail -n 100 storage/logs/laravel.log

# Apache logs
tail -f /var/log/apache2/error.log
tail -f /var/log/apache2/access.log

# System logs
journalctl -u apache2 -n 50
```

### Debug Info

```bash
# Check PHP version
php -v

# Check PHP extensions
php -m

# Check Composer version
composer --version

# Check Laravel version
php artisan --version

# Check disk usage
df -h

# Check memory usage
free -h

# Check running processes
ps aux | grep apache
ps aux | grep php
```

---

## File Permissions

```bash
# Fix Laravel permissions
chown -R www-data:www-data storage
chown -R www-data:www-data bootstrap/cache
chmod -R 775 storage
chmod -R 775 bootstrap/cache

# Check permissions
ls -la storage/
ls -la bootstrap/cache/
```

---

## Git Commands (for manual deploy)

```bash
# Check current branch
git branch

# Pull latest changes
git pull origin main

# Check status
git status

# Show last commit
git log -1
```

---

## Performance Testing

```bash
# Test response time
curl -o /dev/null -s -w "Time: %{time_total}s\n" https://your-app.onrender.com

# Test with headers
curl -I https://your-app.onrender.com

# Test database connection speed
time php artisan db:show
```

---

## Render CLI Commands

Install: `npm install -g render`

```bash
# Login
render login

# List services
render services

# Get service info
render services:info sides-surat

# View logs
render logs sides-surat

# Open shell
render shell sides-surat

# Deploy latest
render deploy sides-surat

# Set environment variable
render env:set sides-surat APP_DEBUG=false

# Get environment variables
render env:get sides-surat
```

---

## Emergency Commands

### Application Down

```bash
# Put in maintenance mode with secret access
php artisan down --secret="emergency-access-2024"

# Access: https://your-app.onrender.com/emergency-access-2024

# Bring back up
php artisan up
```

### Reset Everything

```bash
# Clear all caches
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Fresh migrate (CAREFUL: drops all data!)
php artisan migrate:fresh --force

# Reseed data
php artisan db:seed --force
```

### Fix Permission Issues

```bash
# Reset all permissions
chown -R www-data:www-data /var/www/html
chmod -R 755 /var/www/html
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

---

## Backup & Restore

### Backup

```bash
# Backup database
php artisan db:show
mysqldump -h $DB_HOST -u $DB_USERNAME -p$DB_PASSWORD $DB_DATABASE > backup-$(date +%Y%m%d).sql

# Backup uploaded files (if any)
tar -czf storage-backup-$(date +%Y%m%d).tar.gz storage/app/public/
```

### Restore

```bash
# Restore database
mysql -h $DB_HOST -u $DB_USERNAME -p$DB_PASSWORD $DB_DATABASE < backup-20250110.sql

# Restore files
tar -xzf storage-backup-20250110.tar.gz
```

---

## Health Check

```bash
# Quick health check script
php artisan db:show && \
php artisan about && \
php artisan route:list --compact && \
echo "✅ Application is healthy!"
```

---

## Tips

1. **Always use `--force` flag** for artisan commands in production
2. **Backup before migrations** especially in production
3. **Check logs** if something goes wrong
4. **Use maintenance mode** when doing major updates
5. **Test in staging** before production deploy

---

## Quick Links

- Render Dashboard: https://dashboard.render.com
- Render Docs: https://render.com/docs
- Laravel Docs: https://laravel.com/docs
- Service URL: https://your-app.onrender.com
