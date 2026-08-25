<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMaterialRequest;
use App\Http\Requests\UpdateMaterialRequest;
use App\Models\Categoria;
use App\Models\Material;
use App\Repositories\Eloquent\MaterialRepository;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class MaterialController extends Controller implements HasMiddleware
{
    protected $materialRepository;

    public function __construct(MaterialRepository $materialRepository)
    {
        $this->materialRepository = $materialRepository;
    }

    /**
     * Middleware assignment.
     */
    public static function middleware()
    {
        return [
            new Middleware('permission:view_materiais', ['only' => ['index', 'show']]),
            new Middleware('permission:create_materiais', ['only' => ['create', 'store']]),
            new Middleware('permission:edit_materiais', ['only' => ['edit', 'update']]),
            new Middleware('permission:delete_materiais', ['only' => ['destroy']]),
            new Middleware('permission:restore_materiais', ['only' => ['restore']]),
            new Middleware('permission:force_delete_materiais', ['only' => ['forceDelete']]),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $materiais = $this->materialRepository->all($request, 15);
        return view('materiais.index', compact('materiais'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('materiais.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMaterialRequest $request)
    {
        $material = $this->materialRepository->create($request->validated());
        return redirect()->route('materiais.show', $material)->with('success', 'Material criado com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Material $material)
    {
        return view('materiais.show', compact('material'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Material $material)
    {
        return view('materiais.edit', compact('material'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMaterialRequest $request, Material $material)
    {
        $material = $this->materialRepository->update($material->id, $request->validated());
        return redirect()->route('materiais.show', $material)->with('success', 'Material atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Material $material)
    {
        $this->materialRepository->delete($material->id);
        return redirect()->route('materiais.index')->with('success', 'Material removido com sucesso.');
    }

    /**
     * Restore a soft deleted resource.
     */
    public function restore(int $id)
    {
        $restored = $this->materialRepository->restore($id);
        
        if ($restored) {
            return redirect()->route('materiais.index')->with('success', 'Material restaurado com sucesso.');
        }
        
        return redirect()->route('materiais.index')->with('error', 'Erro ao restaurar o material.');
    }

    /**
     * Permanently delete the specified resource from storage.
     */
    public function forceDelete(int $id)
    {
        $deleted = $this->materialRepository->forceDelete($id);
        
        if ($deleted) {
            return redirect()->route('materiais.index')->with('success', 'Material excluído permanentemente com sucesso.');
        }
        
        return redirect()->route('materiais.index')->with('error', 'Erro ao excluir o material permanentemente.');
    }

    /**
     * Download the material file.
     */
    public function download(Material $material)
    {
        $filePath = storage_path('app/public/' . $material->arquivo_path);

        if (!file_exists($filePath)) {
            return redirect()->route('materiais.show', $material)->with('error', 'Arquivo não encontrado.');
        }

        return response()->download($filePath, $material->titulo . '.' . $material->tipo);
    }
}
