<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('home')->insert([
            'content' => 'Hai! Saya Farid Annas, lulusan SMK Angkasa 1 Margahayu tahun 2024 jurusan Rekayasa Perangkat Lunak (RPL). Saya memiliki minat yang kuat dalam pengembangan perangkat lunak dan web, serta dedikasi untuk terus belajar dan berkembang di bidang teknologi.',
            'foto' => 'img/myfoto.png',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('port')->insert([
            [
                'foto' => 'img/atr.png',
                'judul' => 'Website Antrian Klinik Online',
                'isi' => 'Aplikasi ini dibuat menggunakan Framework Laravel 9 dan Bootsrap 5. Fitur Aplikasi ini terdapat halaman login 2 level yaitu pasien dan admin. Fitur User adalah daftar antrian, edit data antrian, cetak dan batal. Fitur Admin adalah memanggil antrian, dan melihat laporan antrian.',
                'link' => 'https://github.com/faridannas1196/Antrian-online',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'foto' => 'img/hotel.png',
                'judul' => 'Website Reservasi Hotel',
                'isi' => 'Aplikasi ini dibuat menggunakan CodeIgniter 3 dan Bootsrap 5. Fitur Aplikasi ini terdapat halaman login 3 level yaitu user, resepsionis, admin dan halaman utama dengan teks selamat datang. Pada fitur User ini bisa melihat tentang hotel, reservasi berdasarkan tipe, melihat informasi dari resepsionis, dan menghubungi kontak ke admin. Fitur Resepsionis adalah mengisi informasi ke user, melihat info reservasi dan riwayat. Fitur admin adalah meng update tentang hotel dan melihat informasi kontak dari user.',
                'link' => 'https://github.com/faridannas1196/reservasi-hotel',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'foto' => 'img/bio.png',
                'judul' => 'Website Identitas diri',
                'isi' => 'Aplikasi ini dibuat menggunakan CodeIgniter 3 dan Bootsrap 5. Fitur Aplikasi ini terdapat halaman login dan halaman utama dengan teks selamat datang kepada user yang login. Halaman identitas yaitu menampilkan data seluru user dan bisa menambah atau menghapus, halaman profil yaitu menampilkan data diri dengan lebih lengkap dan bisa di edit. Aplikasi ini juga memiliki pengujian otomatis menggunakan Cypress.',
                'link' => 'https://github.com/faridannas1196/bio-login',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'foto' => 'img/porto.png',
                'judul' => 'Website Portofolio',
                'isi' => 'Aplikasi ini dibuat menggunakan Framework Laravel 11 dan Tailwind CSS. Fitur Aplikasi ini juga terdapat halaman utama yang isinya ringkasan diri dan foto pribadi. Halaman about yang isinya tentang diri, pendidikan, keahlian. Halaman Blog tentang pengalaman. Dan kontak untuk menghubungi pemilik.',
                'link' => 'https://github.com/faridannas1196/portofolio',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        DB::table('blog')->insert([
            [
                'title' => 'Praktik Kerja Lapangan (PKL)',
                'subtitle' => 'PT. Neuronworks Indonesia | 15 Januari 2024 - 30 April 2024',
                'description' => 'Selama masa studi di SMK, saya berkesempatan untuk Praktik Kerja Lapangan di PT. Neuronworks Indonesia sebagai Quality Assurance (QA). Perusahaan ini bergerak di bidang Informasi dan Teknologi. Pengalaman ini sangat berharga dan memberikan banyak pelajaran berharga. Saat melaksanakan PKL saya mendapatkan pengetahuan dan keterampilan baru terkait QA, Cypress, dan Pengelolaan Test Case dengan menggunakan excel atau speadsheet.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
