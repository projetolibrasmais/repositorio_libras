<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Sinal;
use Illuminate\Http\Request;

class GlobalSearchController extends Controller
{
    private const SINAL_SEARCH_COLUMNS = [
        'palavra_portugues',
        'slug',
        'definicao',
        'config_mao',
        'ponto_articulacao',
        'orientacao_palma_mao',
        'movimento',
        'expressao_nao_manual',
        'contexto_utilizacao',
        'categorias.nome',
    ];

    /**
     * Autocomplete search - returns JSON for dropdown.
     */
    public function autocomplete(Request $request)
    {
        $query = trim((string) $request->input('query'));

        if (mb_strlen($query) < 2) {
            return response()->json(['results' => []]);
        }

        $results = [];

        $sinais = Sinal::whereIn('status', ['catalogado', 'publicado'])
            ->with('categorias')
            ->search($query, self::SINAL_SEARCH_COLUMNS)
            ->limit(5)
            ->get();

        foreach ($sinais as $sinal) {
            $results[] = [
                'title' => $sinal->palavra_portugues,
                'description' => $this->buildSinalDescription($sinal),
                'url' => route('public.sinal.show', $sinal->slug),
                'type' => 'sinal',
                'type_label' => 'Sinal',
                'icon' => 'ph ph-hand-waving',
            ];
        }

        $categorias = Categoria::search($query, ['nome'])
            ->limit(3)
            ->get();

        foreach ($categorias as $categoria) {
            $results[] = [
                'title' => $categoria->nome,
                'description' => '',
                'url' => route('public.categoria.show', $categoria->slug),
                'type' => 'categoria',
                'type_label' => 'Categoria',
                'icon' => 'ph ph-folder',
            ];
        }

        return response()->json(['results' => $results]);
    }

    /**
     * Full search results page.
     */
    public function results(Request $request)
    {
        $query = trim((string) $request->input('query'));

        $sinais = collect();
        $categorias = collect();
        $materiais = collect();

        if (mb_strlen($query) >= 2) {
            $sinais = Sinal::whereIn('status', ['catalogado', 'publicado'])
                ->search($query, self::SINAL_SEARCH_COLUMNS)
                ->with('video', 'categorias')
                ->paginate(12, ['*'], 'sinais_page');

            $categorias = Categoria::search($query, ['nome'])
                ->withCount('sinais')
                ->paginate(12, ['*'], 'categorias_page');
        }

        return view('search.results', compact('query', 'sinais', 'categorias', 'materiais'));
    }

    private function buildSinalDescription(Sinal $sinal): string
    {
        $description = collect([
            $sinal->definicao,
            $sinal->config_mao ? 'Configuração de mão: ' . $sinal->config_mao : null,
            $sinal->movimento ? 'Movimento: ' . $sinal->movimento : null,
            $sinal->ponto_articulacao ? 'Ponto de articulação: ' . $sinal->ponto_articulacao : null,
            $sinal->categorias->isNotEmpty() ? 'Categorias: ' . $sinal->categorias->pluck('nome')->join(', ') : null,
        ])->filter()->join(' | ');

        return mb_strimwidth($description, 0, 140, '...');
    }
}
