<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Material;
use App\Models\Sinal;
use App\Repositories\Eloquent\CategoriaRepository;
use App\Repositories\Eloquent\SinalRepository;
use Illuminate\Http\Request;

class HomeController extends Controller
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

    /**
     * @var SinalRepository
     * @var CategoriaRepository
     */
    protected $sinalRepository;
    protected $categoriaRepository;

    /**
     * Create a new controller instance.
     */
    public function __construct(SinalRepository $sinalRepository, CategoriaRepository $categoriaRepository)
    {
        $this->sinalRepository = $sinalRepository;
        $this->categoriaRepository = $categoriaRepository;
    }

    /**
     * Show the application dashboard.
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Show the about page.
     */
    public function about()
    {
        $materiais = Material::all();
        return view('public.sobre', compact('materiais'));
    }

    /**
     * Show sinais page.
     */
    public function sinais(Request $request)
    {
        $search = trim((string) $request->input('query'));
        $query = Sinal::whereIn('status', ['catalogado', 'publicado'])
            ->with('video', 'imagens', 'categorias');

        if (mb_strlen($search) >= 2) {
            $query->search($search);
        }

        foreach (self::SIGNAL_TEXT_FILTERS as $field) {
            $value = $request->input($field);

            if (is_string($value) && trim($value) !== '') {
                $query->where($field, 'LIKE', '%' . trim($value) . '%');
            }
        }

        $categoriaAtual = null;
        $categoriaNome = $request->input('categorias.nome');

        if (is_string($categoriaNome) && trim($categoriaNome) !== '') {
            $categoriaAtual = Categoria::where('nome', trim($categoriaNome))->first();

            if ($categoriaAtual) {
                $query->whereHas('categorias', fn ($categoryQuery) => $categoryQuery->whereKey($categoriaAtual->id));
            }
        } elseif ($request->filled('categoria')) {
            // Compatibilidade com links antigos que utilizavam o slug.
            $categoriaAtual = Categoria::where('slug', (string) $request->string('categoria'))->first();

            if ($categoriaAtual) {
                $query->whereHas('categorias', fn ($categoryQuery) => $categoryQuery->whereKey($categoriaAtual->id));
            }
        }

        $sinais = $query->orderBy('palavra_portugues')
            ->paginate(12, ['*'], 'sinais_page')
            ->withQueryString();

        $categorias = mb_strlen($search) >= 2
            ? Categoria::search($search, ['nome'])
                ->withCount(['sinais' => fn ($signalQuery) => $signalQuery->whereIn('status', ['catalogado', 'publicado'])])
                ->orderBy('nome')
                ->paginate(6, ['*'], 'categorias_page')
                ->withQueryString()
            : collect();

        return view('public.sinais', compact('sinais', 'categorias', 'categoriaAtual', 'search'));
    }

    /**
     * Show the specific sinal detail page.
     */
    public function sinalDetail($slug)
    {
        $sinal = $this->sinalRepository->findBySlug($slug);
        return view('public.sinal-detail', compact('sinal'));
    }

    /**
     * Show the catalog page.
     */
    public function catalog(Request $request)
    {
        $query = Sinal::whereIn('status', ['catalogado', 'publicado'])
            ->with('video', 'categorias');

        // Filter by letter if provided
        if ($request->filled('letra')) {
            $letra = strtoupper($request->letra);
            $query->where('palavra_portugues', 'LIKE', $letra . '%');
        }

        // Search filter
        if ($request->filled('query')) {
            $searchQuery = $request->query;
            $query->search($searchQuery, [
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
            ]);
        }

        $sinais = $query->orderBy('palavra_portugues', 'asc')
            ->paginate(12)
            ->withQueryString();

        return view('public.catalogo', compact('sinais'));
    }

    /**
     * Show the categories page.
     */
    public function categorias()
    {
        $categorias = Categoria::withCount([
            'sinais' => fn ($query) => $query->whereIn('status', ['catalogado', 'publicado']),
        ])->orderBy('nome')->get();

        return view('public.categorias', compact('categorias'));
    }

    public function faq()
    {
        return view('public.faq');
    }
}
