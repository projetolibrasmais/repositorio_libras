<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoriaRequest;
use App\Http\Requests\UpdateCategoriaRequest;
use App\Models\Categoria;
use App\Repositories\Eloquent\CategoriaRepository;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class CategoriaController extends Controller implements HasMiddleware
{

    protected $categoriaRepository;

    public function __construct(CategoriaRepository $categoriaRepository){
        $this->categoriaRepository = $categoriaRepository;
    }

    /**
     * Middleware assignment.
     */
    public static function middleware()
    {
        return [
            new Middleware('permission:view_categorias', ['only' => ['index', 'show']]),
            new Middleware('permission:create_categorias', ['only' => ['create', 'store']]),
            new Middleware('permission:edit_categorias', ['only' => ['edit', 'update']]),
            new Middleware('permission:delete_categorias', ['only' => ['destroy']]),
            new Middleware('permission:restore_categorias', ['only' => ['restore']]),
            new Middleware('permission:force_delete_categorias', ['only' => ['forceDelete']]),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categorias = $this->categoriaRepository->all($request, 15);
        return view('categorias.index', compact('categorias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Categoria $categoria)
    {
        return view('categorias.create', compact('categoria'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoriaRequest $request)
    {
        $categoria = $this->categoriaRepository->create($request->validated());
        return redirect()->route('categorias.index')->with('success', 'Categoria criada com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Categoria $categoria)
    {
        return view('categorias.show', compact('categoria'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Categoria $categoria)
    {
        return view('categorias.edit', compact('categoria'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoriaRequest $request, Categoria $categoria)
    {
        $categoria = $this->categoriaRepository->update($categoria->id, $request->validated());
        return redirect()->route('categorias.show', $categoria)->with('success', 'Categoria atualizada com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categoria $categoria)
    {
        $deleted = $this->categoriaRepository->delete($categoria->id);

        if (!$deleted) {
            return redirect()->route('categorias.index')->with('error', 'Não é possível remover a categoria porque ela está associada a um ou mais sinais.');
        }
        
        return redirect()->route('categorias.index')->with('success', 'Categoria removida com sucesso.');
    }
    
    /**
     * Restore the specified resource from storage.
     */
    public function restore($id)
    {
        $this->categoriaRepository->restore($id);
        return redirect()->route('categorias.index')->with('success', 'Categoria restaurada com sucesso.');
    }

    /**
     * Force delete the specified resource from storage.
     */
    public function forceDelete($id)
    {
        $this->categoriaRepository->forceDelete($id);
        return redirect()->route('categorias.index')->with('success', 'Categoria excluída permanentemente com sucesso.');
    }
}
