<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Categoria;
use App\Models\Material;
use App\Models\Sinal;
use App\Models\User;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Estatísticas gerais
        $totalSinais = Sinal::count();
        $totalCategorias = Categoria::count();
        $totalMateriais = Material::count();
        $totalUsuarios = User::count();
        $totalVideos = Video::count();

        // Últimos sinais cadastrados
        $ultimosSinais = Sinal::with('categorias')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Categorias mais usadas (com contagem de sinais)
        $categoriasMaisUsadas = Categoria::withCount('sinais')
            ->orderBy('sinais_count', 'desc')
            ->limit(5)
            ->get();

        // Sinais cadastrados nos últimos 30 dias (para o gráfico)
        $sinaisPorDia = Sinal::select(
            DB::raw('DATE(created_at) as data'),
            DB::raw('COUNT(*) as total')
        )
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('data')
            ->orderBy('data', 'asc')
            ->get();

        // Atividades recentes
        $atividadesRecentes = ActivityLog::with('causer')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Materiais por tipo
        $materiaisPorTipo = Material::select('tipo', DB::raw('COUNT(*) as total'))
            ->groupBy('tipo')
            ->get();

        // Crescimento mensal de sinais
        $crescimentoMensal = Sinal::select(
            DB::raw('YEAR(created_at) as ano'),
            DB::raw('MONTH(created_at) as mes'),
            DB::raw('COUNT(*) as total')
        )
            ->groupBy('ano', 'mes')
            ->orderBy('ano', 'desc')
            ->orderBy('mes', 'desc')
            ->limit(6)
            ->get()
            ->reverse();

        return view('dashboard', compact(
            'totalSinais',
            'totalCategorias',
            'totalMateriais',
            'totalUsuarios',
            'totalVideos',
            'ultimosSinais',
            'categoriasMaisUsadas',
            'sinaisPorDia',
            'atividadesRecentes',
            'materiaisPorTipo',
            'crescimentoMensal'
        ));
    }
}
