<?php

namespace App\Http\Controllers;

use App\Models\Contato;
use App\Http\Requests\StoreContatoRequest;
use App\Http\Requests\UpdateContatoRequest;
use App\Notifications\AnswerContact;
use App\Repositories\Eloquent\ContatoRepository;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Notification;

class ContatoController extends Controller implements HasMiddleware
{
    /**
     * The repository instance for the Contato model.
     */
    protected $contatoRepository;

    /**
     * Create a new controller instance.
     */
    public function __construct(ContatoRepository $contatoRepository)
    {
        $this->contatoRepository = $contatoRepository;
    }

    /**
     * Define the middleware for the controller.
     */
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view_contatos', only: ['index', 'show']),
            new Middleware('permission:edit_contatos', only: ['edit', 'update', 'answer', 'markRead', 'markAnswered']),
            new Middleware('permission:delete_contatos', only: ['destroy']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $contatos = Contato::query()
            ->when($request->filled('search'), fn ($query) => $query->where(fn ($q) => $q
                ->where('nome', 'like', '%'.$request->search.'%')
                ->orWhere('email', 'like', '%'.$request->search.'%')
                ->orWhere('assunto', 'like', '%'.$request->search.'%')))
            ->when($request->status === 'nao_lidos', fn ($query) => $query->where('lido', false))
            ->when($request->status === 'pendentes', fn ($query) => $query->whereNull('respondido_em'))
            ->when($request->status === 'respondidos', fn ($query) => $query->whereNotNull('respondido_em'))
            ->latest()->paginate(15)->withQueryString();
        return view('contatos.index', compact('contatos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContatoRequest $request)
    {
        $contato = $this->contatoRepository->create($request->validated());
        return redirect()->to(route('public.about').'#contato')->with('success', 'Mensagem enviada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Contato $contato)
    {
        if (! $contato->lido && auth()->user()->can('edit_contatos')) {
            $contato->update(['lido' => true]);
        }
        return view('contatos.show', compact('contato'));
    }

    public function markRead(Contato $contato)
    {
        $contato->update(['lido' => true]);
        return back()->with('success', 'Contato marcado como lido.');
    }

    public function markAnswered(Contato $contato)
    {
        $contato->update(['lido' => true, 'respondido_em' => now(), 'canal_resposta' => 'externo']);
        return back()->with('success', 'Contato marcado como já respondido por e-mail externo.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contato $contato)
    {
        return view('contatos.edit', compact('contato'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContatoRequest $request, Contato $contato)
    {
        $this->contatoRepository->update($contato->id, $request->validated());
        return redirect()->route('contatos.index')->with('success', 'Contato atualizado com sucesso!');
    }

    /**
     * Show the form for answering the specified resource.
     */
    public function answer(Request $request, Contato $contato)
    {
        if ($contato->respondido_em) {
            return back()->with('success', 'Este contato já foi marcado como respondido.');
        }
        $request->validate([
            'resposta' => 'required|string',
        ]);

        Notification::route('mail', $contato->email)->notify(new AnswerContact($contato, $request->input('resposta')));
        $contato->update(['resposta' => $request->input('resposta'), 'lido' => true, 'respondido_em' => now(), 'canal_resposta' => 'sistema']);
        
        return redirect()->route('contatos.index')->with('success', 'Resposta enviada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contato $contato)
    {
        $this->contatoRepository->delete($contato->id);
        return redirect()->route('contatos.index')->with('success', 'Contato excluído com sucesso!');
    }
}
