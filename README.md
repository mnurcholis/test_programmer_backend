<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

## PHP

Aplikasi di bangun dengan menggunakan PHP 8.0.1
Di bangun dengan menggunakan Framework Laravel versi 9.48.0
Di untuk penyimpan menggunakan mysqi yang diljalankan di xampp

## Penggunaa Aplikasi

Pertama Jalankan

```bash
$ git clone https://github.com/mnurcholis/test_programmer_backend
$ cd test_programmer_backend/
```

Selanjutnya Bikin Data Base dengan Nama "test_programmer"

Kedua Jalankan

```bash
$ composer install
```

Terus jalakan

```bash
$ php artisan migrate --seed
```

Terus jalakan

```bash
$ php artisan serve
```

Dan kunjungi ke http://127.0.0.1:8000/
