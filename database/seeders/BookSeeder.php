<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        $books = [
            // Teknologi
            [
                'category_slug' => 'teknologi',
                'title' => 'Clean Code: A Handbook of Agile Software Craftsmanship',
                'author' => 'Robert C. Martin',
                'publisher' => 'Prentice Hall',
                'isbn' => '9780132350884',
                'published_year' => 2008,
                'synopsis' => 'Buku legendaris untuk programmer yang ingin menulis kode yang bersih, mudah dibaca, dan mudah dipelihara.',
                'total_stock' => 5,
                'borrow_count' => 12,
            ],
            [
                'category_slug' => 'teknologi',
                'title' => 'The Pragmatic Programmer: Your Journey to Mastery',
                'author' => 'David Thomas, Andrew Hunt',
                'publisher' => 'Addison-Wesley Professional',
                'isbn' => '9780135957059',
                'published_year' => 2019,
                'synopsis' => 'Buku panduan praktis untuk membantu programmer menjadi lebih efisien, efektif, dan profesional dalam pekerjaannya.',
                'total_stock' => 4,
                'borrow_count' => 8,
            ],
            // Sejarah
            [
                'category_slug' => 'sejarah',
                'title' => 'Sapiens: Riwayat Singkat Umat Manusia',
                'author' => 'Yuval Noah Harari',
                'publisher' => 'Kepustakaan Populer Gramedia',
                'isbn' => '9786024240165',
                'published_year' => 2011,
                'synopsis' => 'Buku yang mengeksplorasi riwayat umat manusia dari zaman batu hingga abad ke-21 melalui sudut pandang sejarah, biologi, dan antropologi.',
                'total_stock' => 8,
                'borrow_count' => 25,
            ],
            // Sastra
            [
                'category_slug' => 'sastra',
                'title' => 'Bumi Manusia',
                'author' => 'Pramoedya Ananta Toer',
                'publisher' => 'Lentera Dipantara',
                'isbn' => '9799731232',
                'published_year' => 2005,
                'synopsis' => 'Novel mahakarya Pramoedya Ananta Toer yang berlatar belakang kebangkitan nasional pada awal abad ke-20.',
                'total_stock' => 10,
                'borrow_count' => 30,
            ],
            [
                'category_slug' => 'sastra',
                'title' => 'Ronggeng Dukuh Paruk',
                'author' => 'Ahmad Tohari',
                'publisher' => 'Gramedia Pustaka Utama',
                'isbn' => '9789792277289',
                'published_year' => 1982,
                'synopsis' => 'Novel trilogi yang menggambarkan kisah cinta antara Srintil (seorang ronggeng) dan Rasus (tentara) di tengah hiruk-pikuk Dukuh Paruk.',
                'total_stock' => 6,
                'borrow_count' => 15,
            ],
            // Fiksi
            [
                'category_slug' => 'fiksi',
                'title' => 'Laskar Pelangi',
                'author' => 'Andrea Hirata',
                'publisher' => 'Bentang Pustaka',
                'isbn' => '9793062797',
                'published_year' => 2005,
                'synopsis' => 'Novel inspiratif tentang perjuangan 10 anak sekolah Laskar Pelangi di Belitung demi mendapatkan pendidikan yang layak.',
                'total_stock' => 12,
                'borrow_count' => 45,
            ],
            // Sains
            [
                'category_slug' => 'sains',
                'title' => 'A Brief History of Time',
                'author' => 'Stephen Hawking',
                'publisher' => 'Bantam Books',
                'isbn' => '9780553380163',
                'published_year' => 1988,
                'synopsis' => 'Buku sains populer yang menjelaskan konsep-konsep kosmologi rumit seperti Big Bang, Lubang Hitam, dan Teori Relativitas dengan bahasa sederhana.',
                'total_stock' => 5,
                'borrow_count' => 10,
            ],
            [
                'category_slug' => 'sains',
                'title' => 'Cosmos',
                'author' => 'Carl Sagan',
                'publisher' => 'Random House',
                'isbn' => '9780394502946',
                'published_year' => 1980,
                'synopsis' => 'Penjelajahan kosmik yang megah tentang asal-usul kehidupan, bumi, sains, dan peradaban manusia.',
                'total_stock' => 4,
                'borrow_count' => 9,
            ],
            // Biografi
            [
                'category_slug' => 'biografi',
                'title' => 'Steve Jobs by Walter Isaacson',
                'author' => 'Walter Isaacson',
                'publisher' => 'Simon & Schuster',
                'isbn' => '9781451648539',
                'published_year' => 2011,
                'synopsis' => 'Biografi resmi pendiri Apple, Steve Jobs, yang ditulis berdasarkan ratusan wawancara pribadi.',
                'total_stock' => 6,
                'borrow_count' => 14,
            ],
            [
                'category_slug' => 'biografi',
                'title' => 'Habibie & Ainun',
                'author' => 'B.J. Habibie',
                'publisher' => 'THC Mandiri',
                'isbn' => '9789791255141',
                'published_year' => 2010,
                'synopsis' => 'Memoar mengharukan kisah cinta sejati antara Presiden RI ke-3, B.J. Habibie, dengan istrinya, Hasri Ainun Habibie.',
                'total_stock' => 7,
                'borrow_count' => 18,
            ],
            // Non-Fiksi
            [
                'category_slug' => 'non-fiksi',
                'title' => 'Atomic Habits',
                'author' => 'James Clear',
                'publisher' => 'Gramedia Pustaka Utama',
                'isbn' => '9786020633176',
                'published_year' => 2018,
                'synopsis' => 'Panduan praktis untuk membangun kebiasaan baik dan menghilangkan kebiasaan buruk melalui perubahan-perubahan kecil 1% setiap hari.',
                'total_stock' => 15,
                'borrow_count' => 50,
            ],
            [
                'category_slug' => 'non-fiksi',
                'title' => 'Thinking, Fast and Slow',
                'author' => 'Daniel Kahneman',
                'publisher' => 'Farrar, Straus and Giroux',
                'isbn' => '9780374275631',
                'published_year' => 2011,
                'synopsis' => 'Buku psikologi kognitif tentang dua sistem yang mengendalikan cara kita berpikir: Sistem 1 (cepat & intuitif) dan Sistem 2 (lambat & logis).',
                'total_stock' => 5,
                'borrow_count' => 11,
            ],
            // Komik
            [
                'category_slug' => 'komik',
                'title' => 'Detective Conan Vol. 100',
                'author' => 'Gosho Aoyama',
                'publisher' => 'Elex Media Komputindo',
                'isbn' => '9786230032950',
                'published_year' => 2021,
                'synopsis' => 'Volume ke-100 dari petualangan detektif SMA Shinichi Kudo yang terperangkap dalam tubuh anak-anak bernama Conan Edogawa.',
                'total_stock' => 10,
                'borrow_count' => 40,
            ],
            // Agama
            [
                'category_slug' => 'agama',
                'title' => 'La Tahzan (Jangan Bersedih)',
                'author' => 'Dr. Aidh al-Qarni',
                'publisher' => 'Qisthi Press',
                'isbn' => '9793715057',
                'published_year' => 2002,
                'synopsis' => 'Buku motivasi Islam terlaris yang menawarkan solusi dan panduan hidup Islami dalam menghadapi berbagai kesedihan dan cobaan hidup.',
                'total_stock' => 9,
                'borrow_count' => 22,
            ],
        ];

        foreach ($books as $b) {
            $category = Category::where('slug', $b['category_slug'])->first();
            if ($category) {
                Book::create([
                    'category_id' => $category->id,
                    'title' => $b['title'],
                    'slug' => Str::slug($b['title']),
                    'author' => $b['author'],
                    'publisher' => $b['publisher'],
                    'isbn' => $b['isbn'],
                    'published_year' => $b['published_year'],
                    'synopsis' => $b['synopsis'],
                    'cover_image' => null, // Placeholder cover bisa diatur nanti
                    'total_stock' => $b['total_stock'],
                    'available_stock' => $b['total_stock'], // Stok awal sama dengan total_stock
                    'borrow_count' => $b['borrow_count'],
                ]);
            }
        }
    }
}
