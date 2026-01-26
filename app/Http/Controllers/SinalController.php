<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSinalRequest;
use App\Http\Requests\UpdateSinalRequest;
use App\Models\Categoria;
use App\Models\Sinal;
use App\Repositories\Eloquent\SinalRepository;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class SinalController extends Controller implements HasMiddleware
{

    protected $sinalRepository;

    public function __construct(SinalRepository $sinalRepository){
        $this->sinalRepository = $sinalRepository;
    }   

    /**
     * Middleware assignment.
     */
    public static function middleware()
    {
        return [
            new Middleware('permission:view_sinais', ['only' => ['index', 'show']]),
            new Middleware('permission:create_sinais', ['only' => ['create', 'store']]),
            new Middleware('permission:edit_sinais', ['only' => ['edit', 'update']]),
            new Middleware('permission:delete_sinais', ['only' => ['destroy']]),
            new Middleware('permission:restore_sinais', ['only' => ['restore']]),
            new Middleware('permission:force_delete_sinais', ['only' => ['forceDelete']]),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $sinais = $this->sinalRepository->all($request, 15);
        $categorias = Categoria::orderBy('nome')->get();
        return view('sinais.index', compact('sinais', 'categorias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categorias = Categoria::select('id', 'nome')->get();
        return view('sinais.create', compact('categorias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSinalRequest $request)
    {
        $sinal = $this->sinalRepository->create($request->validated());
        return redirect()->route('sinais.show', $sinal)->with('success', 'Sinal criado com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Sinal $sinal)
    {
        $video = $sinal->video;
        return view('sinais.show', compact('sinal', 'video'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sinal $sinal)
    {
        $video = $sinal->video;

        $categorias = Categoria::select('id', 'nome')->get();
        return view('sinais.edit', compact('sinal', 'categorias', 'video'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSinalRequest $request, Sinal $sinal)
    {      
        
        $sinal = $this->sinalRepository->update($sinal->id, $request->validated());
        return redirect()->route('sinais.show', $sinal)->with('success', 'Sinal atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sinal $sinal)
    {
        $this->sinalRepository->delete($sinal->id);
        return redirect()->route('sinais.index')->with('success', 'Sinal removido com sucesso.');
    }

    /**
     * Restore a soft deleted resource.
     */
    public function restore(int $id)
    {
        $restored = $this->sinalRepository->restore($id);
        
        if ($restored) {
            return redirect()->route('sinais.index')->with('success', 'Sinal restaurado com sucesso.');
        }
        
        return redirect()->route('sinais.index')->with('error', 'Erro ao restaurar o sinal.');
    }

    /**
     * Permanently delete the specified resource from storage.
     */
    public function forceDelete(int $id)
    {
        $deleted = $this->sinalRepository->forceDelete($id);
        
        if ($deleted) {
            return redirect()->route('sinais.index')->with('success', 'Sinal excluído permanentemente com sucesso.');
        }
        
        return redirect()->route('sinais.index')->with('error', 'Erro ao excluir o sinal permanentemente.');
    }
}
