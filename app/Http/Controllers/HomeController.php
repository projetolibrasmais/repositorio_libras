<?php

namespace App\Http\Controllers;

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
        return view('public.sobre');
    }

    /**
     * Show sinais page.
     */
    public function sinais()
    {
        $sinais = $this->sinalRepository->all();
        return view('public.sinais', compact('sinais'));
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
    public function catalog()
    {
        return view('public.catalogo');
    }

    /**
     * Show the categories page.
     */
    public function categorias()
    {
        $categorias = $this->categoriaRepository->all();
        return view('public.categorias', compact('categorias'));
    }
}
