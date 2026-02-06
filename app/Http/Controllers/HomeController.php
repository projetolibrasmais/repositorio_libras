<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Sinal;
use App\Repositories\Eloquent\CategoriaRepository;
use App\Repositories\Eloquent\SinalRepository;
use Illuminate\Http\Request;

class HomeController extends Controller
{
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
    public function sinais()
    {
        return view('public.sinais');
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
            $query->search($searchQuery, ['palavra_portugues', 'definicao', 'parametros']);
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
        $categorias = $this->categoriaRepository->all();
        return view('public.categorias', compact('categorias'));
    }

    public function faq()
    {
        return view('public.faq');
    }
}
