# 📝 DEPLOYMENT MEMO - Rex's Rents on Ubuntu Server

## Project Overview
**Rex's Rents** - Car Rental Management System (Brutalist Design)
- **Tech Stack:** PHP 8.x + MySQL 8.x + Apache2
- **Design:** Brutalist (black, white, neon green #ccff00)
- **Fleet:** 27 cars with realistic Indonesian pricing
- **Users:** Admin + Employee (Pegawai) roles

---

## 🎯 NEXT STEPS FOR CLOUD COMPUTING ASSIGNMENT

### Goal: Deploy to Ubuntu Server with Apache + MySQL

---

## 📦 PRE-DEPLOYMENT CHECKLIST

### Files Ready in `web-app/` folder:
- ✅ `index.php` - Landing page (shows all 27 cars)
- ✅ `login.php` - Login page
- ✅ `config.php` - Database configuration
- ✅ `database.sql` - Complete database schema + data
- ✅ `assets/css/style.css` - Brutalist theme
- ✅ `assets/images/mobil/` - All 27 car images
- ✅ `admin/` - Admin panel (dashboard, cars, customers, transactions)
- ✅ `employee/` - Employee panel (dashboard, rental, return)

### Default Login Credentials:
| Role | Username | Password |
|------|----------|----------|
| Admin | `admin` | `admin123` |
| Pegawai | `pegawai` | `pegawai123` |

---

## 🚀 UBUNTU SERVER DEPLOYMENT STEPS

### Step 1: Connect to Ubuntu Server
```bash
# SSH into your Ubuntu server
ssh user@your-server-ip
# Or use cloud console (AWS EC2, Google Cloud, Azure, etc.)
```

### Step 2: Update System Packages
```bash
sudo apt update && sudo apt upgrade -y
```

### Step 3: Install Apache Web Server
```bash
sudo apt install apache2 -y
sudo systemctl start apache2
sudo systemctl enable apache2
sudo systemctl status apache2  # Verify it's running
```

### Step 4: Install MySQL Server
```bash
sudo apt install mysql-server -y
sudo systemctl start mysql
sudo systemctl enable mysql
sudo mysql_secure_installation
```
**When prompted:**
- Set root password: (choose a strong password)
- Remove anonymous users: `Y`
- Disallow root login remotely: `Y`
- Remove test database: `Y`
- Reload privilege tables: `Y`

### Step 5: Install PHP + Extensions
```bash
sudo apt install php libapache2-mod-php php-mysql php-cli php-curl php-gd php-mbstring php-xml php-zip -y
```

### Step 6: Verify PHP Installation
```bash
php -v  # Should show PHP 8.x
```

### Step 7: Create MySQL Database
```bash
# Login to MySQL
sudo mysql -u root -p

# Run these SQL commands:
CREATE DATABASE db_rexrents CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

CREATE USER 'rexrents_user'@'localhost' IDENTIFIED BY 'YourStrongPassword123!';

GRANT ALL PRIVILEGES ON db_rexrents.* TO 'rexrents_user'@'localhost';

FLUSH PRIVILEGES;

EXIT;
```

### Step 8: Upload Application Files

**Option A: Using SCP (from your local machine)**
```bash
# From your Windows/Mac terminal (NOT SSH session)
scp -r web-app/* user@your-server-ip:/var/www/html/
```

**Option B: Using Git**
```bash
# In /var/www/html on Ubuntu
sudo cd /var/www/html
sudo git clone <your-repo-url> .
```

**Option C: Using Nano to create files manually**
```bash
sudo nano /var/www/html/index.php
# Paste content, Ctrl+X, Y, Enter to save
```

### Step 9: Set Correct Permissions
```bash
sudo chown -R www-data:www-data /var/www/html/
sudo chmod -R 755 /var/www/html/
sudo chmod -R 777 /var/www/html/assets/images/mobil/  # For image uploads
```

### Step 10: Configure Database Connection
```bash
sudo nano /var/www/html/config.php
```

**Update these lines:**
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'rexrents_user');     // Changed from 'root'
define('DB_PASS', 'YourStrongPassword123!');  // Your MySQL password
define('DB_NAME', 'db_rexrents');
```

### Step 11: Import Database Schema
```bash
sudo mysql -u root -p db_rexrents < /var/www/html/database.sql
```

### Step 12: Configure Apache (Optional - for custom domain)
```bash
sudo nano /etc/apache2/sites-available/rexsrents.conf
```

**Add this configuration:**
```apache
<VirtualHost *:80>
    ServerName your-domain.com
    ServerAlias www.your-domain.com
    DocumentRoot /var/www/html
    
    <Directory /var/www/html>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
    
    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
```

**Enable the site:**
```bash
sudo a2ensite rexsrents.conf
sudo a2dissite 000-default.conf
sudo systemctl reload apache2
```

### Step 13: Configure Firewall (if enabled)
```bash
sudo ufw allow 'Apache Full'
sudo ufw status
```

### Step 14: Test the Application
**Open browser and navigate to:**
```
http://your-server-ip/
http://your-server-ip/login.php
```

**Test Login:**
- Admin: `admin` / `admin123`
- Pegawai: `pegawai` / `pegawai123`

**Test Features:**
1. ✅ Landing page shows all 27 cars
2. ✅ Login works
3. ✅ Admin Dashboard shows statistics
4. ✅ Admin can add/edit/delete cars
5. ✅ Admin can add/edit/delete customers
6. ✅ Employee can create new rental
7. ✅ Employee can process car return

---

## 🔧 TROUBLESHOOTING

### Issue: "Connection refused" to MySQL
```bash
# Check MySQL is running
sudo systemctl status mysql

# Restart if needed
sudo systemctl restart mysql
```

### Issue: "Permission denied" errors
```bash
sudo chown -R www-data:www-data /var/www/html/
sudo chmod -R 755 /var/www/html/
```

### Issue: PHP not executing (shows code instead)
```bash
# Check PHP module is enabled
sudo a2enmod php8.x  # Replace x with your version
sudo systemctl restart apache2
```

### Issue: 404 Not Found
```bash
# Check files are in correct location
ls -la /var/www/html/

# Check Apache config
sudo apache2ctl configtest
```

### Issue: Database connection error
```bash
# Test MySQL connection
mysql -u rexrents_user -p -e "SHOW DATABASES;"

# If fails, check user privileges
sudo mysql -u root -p -e "SHOW GRANTS FOR 'rexrents_user'@'localhost';"
```

### Enable Error Logging (for debugging)
```bash
sudo nano /etc/php/8.x/apache2/php.ini
```

**Find and update:**
```ini
display_errors = On
error_reporting = E_ALL
error_log = /var/log/php_errors.log
```

**Restart Apache:**
```bash
sudo systemctl restart apache2
```

---

## 📊 VERIFICATION CHECKLIST

After deployment, verify:

- [ ] Apache is running: `sudo systemctl status apache2`
- [ ] MySQL is running: `sudo systemctl status mysql`
- [ ] PHP is working: Create `/var/www/html/info.php` with `<?php phpinfo(); ?>`
- [ ] Database exists: `sudo mysql -u root -p -e "SHOW DATABASES;"`
- [ ] Tables imported: `sudo mysql -u root -p db_rexrents -e "SHOW TABLES;"`
- [ ] 27 cars in database: `sudo mysql -u root -p db_rexrents -e "SELECT COUNT(*) FROM tb_mobil;"`
- [ ] Landing page loads: `curl http://localhost/`
- [ ] Login works: Test with admin credentials
- [ ] Rental creation works: Create a test rental
- [ ] Images load: Check car images display correctly

---

## 🔒 SECURITY RECOMMENDATIONS (FOR PRODUCTION)

### 1. Change Default Passwords
```sql
-- In MySQL
UPDATE tb_akun SET password = 'YourNewSecurePassword' WHERE username = 'admin';
UPDATE tb_akun SET password = 'YourNewSecurePassword' WHERE username = 'pegawai';
```

### 2. Enable HTTPS (SSL Certificate)
```bash
sudo apt install certbot python3-certbot-apache -y
sudo certbot --apache -d your-domain.com
```

### 3. Set Up Automated Backups
```bash
# Create backup script
sudo nano /usr/local/bin/backup-rexsrents.sh
```

**Script content:**
```bash
#!/bin/bash
DATE=$(date +%Y%m%d_%H%M%S)
mysqldump -u rexrents_user -p'YourPassword' db_rexrents > /backups/db_rexrents_$DATE.sql
tar -czf /backups/rexsrents_$DATE.tar.gz /var/www/html/
```

**Make executable and schedule:**
```bash
sudo chmod +x /usr/local/bin/backup-rexsrents.sh
sudo crontab -e
# Add: 0 2 * * * /usr/local/bin/backup-rexsrents.sh
```

### 4. Configure Firewall
```bash
sudo ufw enable
sudo ufw allow ssh
sudo ufw allow http
sudo ufw allow https
sudo ufw status
```

### 5. Disable Directory Listing
```bash
sudo nano /etc/apache2/apache2.conf
# Add: Options -Indexes
sudo systemctl restart apache2
```

---

## 📈 MONITORING & MAINTENANCE

### Check Apache Logs
```bash
sudo tail -f /var/log/apache2/error.log
sudo tail -f /var/log/apache2/access.log
```

### Check MySQL Logs
```bash
sudo tail -f /var/log/mysql/error.log
```

### Monitor Disk Space
```bash
df -h
```

### Monitor Memory
```bash
free -h
```

### Update System Regularly
```bash
sudo apt update && sudo apt upgrade -y
```

---

## 🎓 ASSIGNMENT DELIVERABLES

For your cloud computing assignment, prepare:

1. **Screenshots:**
   - [ ] Landing page with all 27 cars
   - [ ] Login page
   - [ ] Admin dashboard
   - [ ] Employee dashboard
   - [ ] Car management (CRUD)
   - [ ] Rental creation form
   - [ ] Car return processing

2. **Documentation:**
   - [ ] Server specifications (CPU, RAM, Storage)
   - [ ] Installation steps taken
   - [ ] Challenges faced and solutions
   - [ ] Screenshots of terminal commands

3. **Live Demo:**
   - [ ] Server IP / Domain URL
   - [ ] Working login credentials
   - [ ] Demo video (optional)

4. **Report:**
   - [ ] Introduction to LAMP stack
   - [ ] Why Ubuntu Server?
   - [ ] Deployment process explanation
   - [ ] Security measures implemented
   - [ ] Lessons learned

---

## 🆘 QUICK HELP COMMANDS

```bash
# Restart Apache
sudo systemctl restart apache2

# Restart MySQL
sudo systemctl restart mysql

# Check Apache status
sudo systemctl status apache2

# Check MySQL status
sudo systemctl status mysql

# View Apache error log
sudo tail -50 /var/log/apache2/error.log

# Test PHP
echo "<?php phpinfo(); ?>" | sudo tee /var/www/html/test.php
# Then visit: http://your-server-ip/test.php
# Delete after testing: sudo rm /var/www/html/test.php
```

---

## 📞 SUPPORT RESOURCES

- **Apache Docs:** https://httpd.apache.org/docs/
- **MySQL Docs:** https://dev.mysql.com/doc/
- **PHP Docs:** https://www.php.net/docs.php
- **Ubuntu Server Guide:** https://ubuntu.com/server/docs

---

## ✅ FINAL CHECKLIST

Before submitting assignment:

- [ ] Application is accessible via public IP/domain
- [ ] All 27 cars display correctly
- [ ] Login system works
- [ ] Admin can manage cars, customers, transactions
- [ ] Employee can create rentals and process returns
- [ ] Database has realistic Indonesian pricing
- [ ] Brutalist design is consistent across all pages
- [ ] Screenshots taken
- [ ] Documentation written
- [ ] Code uploaded to GitHub (optional)

---

**Good luck with your cloud computing assignment! 🚀**

**Project:** Rex's Rents - Car Rental Management System  
**Design:** Brutalist Theme  
**Deployment:** Ubuntu Server + Apache + MySQL  
**Status:** Ready for Production

---

*Memo created for: Cloud Computing Assignment*  
*Last updated: March 2026*
