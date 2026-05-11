# Ubuntu Server Deployment Guide - Rex's Rents

vboxuser

## 1. System Requirements
- Ubuntu 20.04 or 22.04 LTS
- Apache 2.4+
- MySQL 8.0+ or MariaDB 10.5+
- PHP 7.4 or 8.x (Recommended: 8.2)
- PHP Extensions: `mysqli`, `fileinfo`, `gd`

## 2. Install LAMP Stack
```bash
sudo apt update
sudo apt install apache2 mysql-server php php-mysqli libapache2-mod-php php-gd -y
```

## 3. Clone and Setup Files
1. Navigate to the web root:
   ```bash
   cd /var/www/html
   ```
2. Clone your repository (make sure to specify the main branch):
   ```bash
   sudo git clone -b main https://github.com/ahmdraihn/rexrent-web-app.git .
   ```
3. Set permissions for the image upload folder:
   ```bash
   sudo chown -R www-data:www-data /var/www/html/web-app/assets/images/mobil/
   sudo chmod -R 775 /var/www/html/web-app/assets/images/mobil/
   ```

## 4. Configure Database
1. Log into MySQL:
   ```bash
   sudo mysql
   ```
2. Create the database and user:
   ```sql
   CREATE DATABASE db_rexrents;
   CREATE USER 'rexuser'@'localhost' IDENTIFIED BY 'your_secure_password';
   GRANT ALL PRIVILEGES ON db_rexrents.* TO 'rexuser'@'localhost';
   FLUSH PRIVILEGES;
   EXIT;
   ```
3. Import the seed data:
   ```bash
   mysql -u rexuser -p db_rexrents < web-app/database.sql
   ```

## 5. Update Config
Edit `web-app/config.php` to match your production database credentials:
```bash
sudo nano web-app/config.php
```

## 6. Apache Configuration (Optional but Recommended)
Enable `.htaccess` if you plan to use clean URLs in the future:
```bash
sudo a2enmod rewrite
sudo systemctl restart apache2
```

---
**Deployment Success!** You can now access the site via your server's IP address.
