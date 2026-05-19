<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Fiksi', 'color' => '#EC4899', 'description' => 'Buku cerita rekaan, novel, dongeng, dan karya imajinatif lainnya.'],
            ['name' => 'Non-Fiksi', 'color' => '#F59E0B', 'description' => 'Karya tulis ilmiah, esai, opini, dan informasi berbasis fakta.'],
            ['name' => 'Sains', 'color' => '#10B981', 'description' => 'Buku tentang ilmu pengetahuan alam, matematika, fisika, kimia, dan biologi.'],
            ['name' => 'Teknologi', 'color' => '#3B82F6', 'description' => 'Informasi seputar komputer, pemrograman, rekayasa, dan inovasi digital.'],
            ['name' => 'Sejarah', 'color' => '#8B5CF6', 'description' => 'Rekam jejak peristiwa masa lalu, peradaban, dan tokoh-tokoh penting.'],
            ['name' => 'Biografi', 'color' => '#6366F1', 'description' => 'Kisah hidup seseorang yang ditulis oleh orang lain untuk inspirasi.'],
            ['name' => 'Kamus & Bahasa', 'color' => '#EF4444', 'description' => 'Buku referensi kosa kata, tata bahasa, dan pembelajaran bahasa asing.'],
            ['name' => 'Komik', 'color' => '#6B7280', 'description' => 'Buku cerita bergambar yang seru dan menghibur.'],
            ['name' => 'Agama', 'color' => '#14B8A6', 'description' => 'Buku keagamaan, spiritual, moral, dan teologi.'],
            ['name' => 'Sastra', 'color' => '#F43F5E', 'description' => 'Karya sastra klasik, puisi, drama, dan kritik sastra.'],
        ];

        foreach ($categories as $cat) {
            Category::create([
                'name' => $cat['name'],
                'slug' => Str::slug($cat['name']),
                'description' => $cat['description'],
                'color' => $cat['color'],
            ]);
        }
    }
}
