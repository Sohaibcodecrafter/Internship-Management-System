1. Install XAMPP (Apache + MySQL)
2. Start Apache and MySQL in XAMPP Control Panel
3. Copy the 'ims' folder into C:\xampp\htdocs\
4. Open http://localhost/phpmyadmin
5. Create a new database named: ims_db
6. Import these SQL files IN ORDER:
   - sql/01_schema.sql
   - sql/02_sample_data.sql
   - sql/03_views_indexes.sql
   - sql/04_extra_data.sql
   - sql/05_alter_companies.sql
7. Open includes/db.php and set:
   $host = 'localhost';
   $db   = 'ims_db';
   $user = 'root';
   $pass = '';        ← blank for default XAMPP
8. Visit: http://localhost/ims/
9. Login with: admin / password123
