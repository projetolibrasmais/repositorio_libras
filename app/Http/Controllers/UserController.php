<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Repositories\Eloquent\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class UserController extends Controller implements HasMiddleware
{
    /**
     * Construct a new controller instance.
     */
    protected $userRepository;

   /**
     * Create a new controller instance.
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    
    /**
     * Middleware assignment.
     */
    public static function middleware()
    {
        return [
            new Middleware('permission:view_users', ['only' => ['index', 'show']]),
            new Middleware('permission:create_users', ['only' => ['create', 'store']]),
            new Middleware('permission:edit_users', ['only' => ['edit', 'update']]),
            new Middleware('permission:delete_users', ['only' => ['destroy']]),
            new Middleware('permission:restore_users', ['only' => ['restore']]),
            new Middleware('permission:force_delete_users', ['only' => ['forceDelete']]),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = $this->userRepository->all($request, 15);
        
        // Get all roles for filter
        $roles = \App\Models\Role::orderBy('name')->get();
        
        return view('users.index', compact('users', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $user = $this->userRepository->create($request->validated());
        return redirect()->route('users.show', $user)->with('success', 'Usuário criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $this->userRepository->update($user->id, $request->all());
        return redirect()->route('users.show', $user)->with('success', 'Usuário atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if ($user->id === 1) {
            return redirect()->route('users.index')->with('error', 'O usuário administrador não pode ser deletado!');
        }
        $this->userRepository->delete($user->id);
        return redirect()->route('users.index')->with('success', 'Usuário deletado com sucesso!');
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore($id)
    {
        $this->userRepository->restore($id);
        return redirect()->route('users.index')->with('success', 'Usuário restaurado com sucesso!');
    }

    /**
     * Force delete the specified resource from storage.
     */
    public function forceDelete($id)
    {
        $this->userRepository->forceDelete($id);
        return redirect()->route('users.index')->with('success', 'Usuário deletado permanentemente com sucesso!');
    }
}