<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Sinal;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class GlobalSearchController extends Controller
{
    private const SIGNAL_TEXT_FILTERS = [
        'definicao',
        'config_mao',
        'ponto_articulacao',
        'orientacao_palma_mao',
        'movimento',
        'expressao_nao_manual',
        'contexto_utilizacao',
    ];

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

    public function categories(): JsonResponse
    {
        return response()->json([
            'categories' => Categoria::query()
                ->orderBy('nome')
                ->get(['nome'])
                ->map(fn (Categoria $categoria) => $categoria->nome)
                ->values(),
        ]);
    }

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
        $hasFilters = collect(self::SIGNAL_TEXT_FILTERS)
            ->contains(fn (string $field) => $request->filled($field))
            || $request->filled('categorias.nome');

        $sinais = collect();
        $categorias = collect();
        $materiais = collect();

        if (mb_strlen($query) >= 2 || $hasFilters) {
            $sinaisQuery = Sinal::whereIn('status', ['catalogado', 'publicado'])
                ->search(mb_strlen($query) >= 2 ? $query : null, self::SINAL_SEARCH_COLUMNS)
                ->with('video', 'categorias');

            foreach (self::SIGNAL_TEXT_FILTERS as $field) {
                $value = $request->input($field);

                if (is_string($value) && trim($value) !== '') {
                    $sinaisQuery->where($field, 'LIKE', '%' . trim($value) . '%');
                }
            }

            $categoriaNome = $request->input('categorias.nome');
            if (is_string($categoriaNome) && trim($categoriaNome) !== '') {
                $sinaisQuery->whereHas('categorias', function ($categoriaQuery) use ($categoriaNome) {
                    $categoriaQuery->where('nome', trim($categoriaNome));
                });
            }

            $sinais = $sinaisQuery->paginate(12, ['*'], 'sinais_page')->withQueryString();
        }

        if (mb_strlen($query) >= 2) {
            $categorias = Categoria::search($query, ['nome'])
                ->withCount('sinais')
                ->paginate(12, ['*'], 'categorias_page')
                ->withQueryString();
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
