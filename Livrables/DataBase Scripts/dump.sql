/** sauvegarde **/

mysqldump -u root -p kgb > C:\Users\Najib\Desktop\backup.sql

/** Restauration  **/

mysql -u root -p kgb < C:\Users\Najib\Desktop\backup.sql
