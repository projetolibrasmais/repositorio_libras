<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSinalRequest;
use App\Http\Requests\UpdateSinalRequest;
use App\Models\Categoria;
use App\Models\Sinal;
use App\Repositories\Eloquent\SinalRepository;
use Illuminate\Http\Request;

class SinalController extends Controller
{

    protected $sinalRepository;

    public function __construct(SinalRepository $sinalRepository){
        $this->sinalRepository = $sinalRepository;
    }   

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $sinais = $this->sinalRepository->all($request, 15);
        return view('sinais.index', compact('sinais'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categorias = Categoria::orderBy('nome')->get();
        return view('sinais.create', compact('categorias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSinalRequest $request)
    {
        $sinal = $this->sinalRepository->create($request->validated());
        return redirect()->route('sinais.show')->with('success', 'Sinal criado com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Sinal $sinal)
    {
        return view('sinais.show', compact('sinal'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sinal $sinal)
    {
        return view('sinais.edit', compact('sinal'));
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
}
