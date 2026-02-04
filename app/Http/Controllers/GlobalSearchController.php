<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Material;
use App\Models\Sinal;
use Illuminate\Http\Request;

class GlobalSearchController extends Controller
{
    /**
     * Autocomplete search - returns JSON for dropdown
     */
    public function autocomplete(Request $request)
    {
        $query = $request->input('query');
        
        if (strlen($query) < 2) {
            return response()->json(['results' => []]);
        }

        $results = [];

        // Search Sinais usando o trait Searchable
        // Incluindo sinais catalogados e publicados para visualização pública
        $sinais = Sinal::whereIn('status', ['catalogado', 'publicado'])
            ->search($query, ['palavra_portugues', 'definicao', 'parametros'])
            ->limit(5)
            ->get();

        foreach ($sinais as $sinal) {
            $results[] = [
                'title' => $sinal->palavra_portugues,
                'description' => $sinal->definicao ? substr($sinal->definicao, 0, 100) : '',
                'url' => route('public.sinal.show', $sinal->slug),
                'type' => 'sinal',
                'type_label' => 'Sinal',
                'icon' => 'ph ph-hand-waving'
            ];
        }

        // Search Categorias usando o trait Searchable
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
                'icon' => 'ph ph-folder'
            ];
        }

        return response()->json(['results' => $results]);
    }

    /**
     * Full search results page
     */
    public function results(Request $request)
    {
        $query = $request->input('query');
        
        $sinais = collect();
        $categorias = collect();
        $materiais = collect();

        if (strlen($query) >= 2) {
            // Buscar sinais usando o trait Searchable
            // Incluindo sinais catalogados e publicados para visualização pública
            $sinais = Sinal::whereIn('status', ['catalogado', 'publicado'])
                ->search($query, ['palavra_portugues', 'definicao', 'parametros', 'contexto_utilizacao'])
                ->with('video', 'categorias')
                ->paginate(12, ['*'], 'sinais_page');

            // Buscar categorias usando o trait Searchable
            $categorias = Categoria::search($query, ['nome'])
                ->withCount('sinais')
                ->paginate(12, ['*'], 'categorias_page');
        }

        return view('search.results', compact('query', 'sinais', 'categorias', 'materiais'));
    }
}
