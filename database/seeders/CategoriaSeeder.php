<?php

namespace Database\Seeders;

use App\Models\Categoria;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categorias = [
            'Letras Português',
            'Letras Inglês',
            'Pedagogia',
            'Matemática',
            'História',
            'Geografia',
            'Ciências Biológicas',
            'Educação Física',
        ];

        foreach ($categorias as $nome) {
            Categoria::updateOrCreate(
                ['slug' => Str::slug($nome)],
                ['nome' => $nome, 'slug' => Str::slug($nome)]
            );
        }
    }
}
