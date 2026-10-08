<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sinal>
 */
class SinalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $termos = [
            'Aprendizagem', 'Comunicação', 'Conhecimento', 'Cultura',
            'Educação', 'Linguagem', 'Pesquisa', 'Tecnologia',
            'Universidade', 'Inclusão', 'Ciência', 'História',
            'Geografia', 'Matemática', 'Literatura', 'Natureza',
        ];
        $termo = $termos[array_rand($termos)];
        $palavra = $termo . ' ' . Str::upper(Str::random(8));

        return [
            'palavra_portugues' => $palavra,
            'slug' => Str::slug($palavra),
            'definicao' => "Registro de teste relacionado a {$termo} para visualização da plataforma.",
            'config_mao' => 'Configuração de mão ilustrativa para este sinal de teste.',
            'ponto_articulacao' => 'Região à frente do corpo.',
            'orientacao_palma_mao' => 'Palma voltada para a frente.',
            'movimento' => 'Movimento curto e contínuo.',
            'expressao_nao_manual' => 'Expressão facial neutra.',
            'contexto_utilizacao' => "Exemplo de uso de {$termo} em uma atividade acadêmica.",
            'status' => 'publicado',
        ];
    }
}
