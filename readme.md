## Laravel 5 : Blog
Contoh blog dengan laravel 5
## Instalasi
- Lakukan "composer install"
- Lakukan ini jika di linux "chgrp -R www-data /var/www/[folder_laravel_anda]"
- Lakukan ini jika di linux "chmod -R 775 /var/www/[folder_laravel_anda]/storage"
- Buat database terlebih dahulu
- Copy file ".env.example" dan ganti menjadi ".env"
- Ganti database dengan database yang anda gunakan
- Generate key dengan perintah "php artisan key:generate"
- Migrasi database dengan command "php artisan migrate --seed"
- [NEW] buat database tracker dan lakukan perintah berikut "php artisan migrate --path=database/migrations/tracker --database=tracker". Pastikan anda sudah menginstall "sudo apt-get purge php5-geoip"

## Admin
Masuk ke http://[IP_ANDA]/admin

user : admin@admin

password : admin