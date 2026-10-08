<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Sinal;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SinalSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Categoria::count() === 0) {
            $this->call(CategoriaSeeder::class);
        }

        $categorias = Categoria::pluck('id');

        for ($numero = 1; $numero <= 200; $numero++) {
            $atributos = Sinal::factory()->make([
                'palavra_portugues' => sprintf('Sinal de teste %03d', $numero),
                'slug' => sprintf('sinal-de-teste-%03d', $numero),
            ])->getAttributes();

            $sinal = Sinal::firstOrCreate(['slug' => $atributos['slug']], $atributos);
            $sinal->categorias()->syncWithoutDetaching(
                $categorias->random(min(2, $categorias->count()))->all()
            );
        }
    }
}
