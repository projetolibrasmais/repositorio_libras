<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Sinal;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
            $dataCriacao = now()->startOfDay()->subDays(200 - $numero)->addHours(10);
            $atributos = Sinal::factory()->make([
                'palavra_portugues' => sprintf('Sinal de teste %03d', $numero),
                'slug' => sprintf('sinal-de-teste-%03d', $numero),
                'created_at' => $dataCriacao,
                'updated_at' => $dataCriacao,
            ])->getAttributes();

            $sinal = Sinal::firstOrCreate(['slug' => $atributos['slug']], $atributos);
            if (! $sinal->wasRecentlyCreated) {
                DB::table('sinais')->where('id', $sinal->id)->update(['created_at' => $dataCriacao]);
            }
            $sinal->categorias()->syncWithoutDetaching(
                $categorias->random(min(2, $categorias->count()))->all()
            );
        }
    }
}
