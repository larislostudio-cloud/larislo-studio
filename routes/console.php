<?php

use Illuminate\Support\Facades\Schedule;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| Di sini Anda dapat mendefinisikan jadwal (schedule) untuk semua Command
| yang telah kita buat di `app/Console/Commands`.
|
*/

// 1. Jadwalkan Publishing Post
// Jalankan setiap menit untuk mengecek post yang waktunya sudah tiba.
// withoutOverlapping() mencegah command berjalan ganda jika proses sebelumnya belum selesai.
Schedule::command('posts:publish')
    ->everyMinute()
    ->withoutOverlapping();

// 2. Jadwalkan Generate Analytics
// Jalankan setiap hari tengah malam (00:00) untuk menghitung statistik hari sebelumnya.
Schedule::command('analytics:generate')
    ->daily();

// 3. Jadwalkan Cleanup Temporary Files
// Jalankan setiap hari jam 3 pagi untuk membersihkan file sampah.
Schedule::command('cleanup:temporary')
    ->dailyAt('03:00');

// 4. (Opsional) Jalankan Backup Database
// Schedule::command('backup:clean')->daily()->at('01:00');
// Schedule::command('backup:run')->daily()->at('02:00');
