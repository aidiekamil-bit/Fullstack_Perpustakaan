<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        $books = [
            // Genre: Teknologi
            ['title' => 'Pemrograman Laravel untuk Pemula', 'genre' => 'Teknologi', 'stock' => 10],
            ['title' => 'Belajar Dasar JavaScript & DOM', 'genre' => 'Teknologi', 'stock' => 8],
            ['title' => 'Arsitektur RESTful API dengan PHP', 'genre' => 'Teknologi', 'stock' => 5],

            // Genre: Fiksi
            ['title' => 'Pulang Pergi oleh Tere Liye', 'genre' => 'Fiksi', 'stock' => 12],
            ['title' => 'Bumi Manusia - Pramoedya Ananta Toer', 'genre' => 'Fiksi', 'stock' => 7],
            ['title' => 'Filosofi Teras - Henry Manampiring', 'genre' => 'Fiksi', 'stock' => 6],

            // Genre: Sains & Pengetahuan
            ['title' => 'Sejarah Singkat Umat Manusia (Sapiens)', 'genre' => 'Sains', 'stock' => 9],
            ['title' => 'Fisika Kuantum untuk Orang Awam', 'genre' => 'Sains', 'stock' => 4],
        ];

        foreach ($books as $book) {
            Book::create($book);
        }
    }
}