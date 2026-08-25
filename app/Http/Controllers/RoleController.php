<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\Permission;
use App\Models\Role;
use App\Repositories\Eloquent\RoleRepository;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class RoleController extends Controller implements HasMiddleware
{
    /**
     * Construct a new controller instance.
     */
    protected $roleRepository;

   /**
     * Create a new controller instance.
     */
    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }
    
    /**
     * Middleware assignment.
     */
    public static function middleware()
    {
        return [
            new Middleware('permission:view_roles', ['only' => ['index', 'show']]),
            new Middleware('permission:create_roles', ['only' => ['create', 'store']]),
            new Middleware('permission:edit_roles', ['only' => ['edit', 'update']]),
            new Middleware('permission:delete_roles', ['only' => ['destroy']]),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $roles = $this->roleRepository->all($request, 15);
        return view('roles.index', compact('roles'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        return view('roles.show', compact('role'));
    }

    /**
     * Create a new resource.
     */
    public function create()
    {
        $permissions = Permission::all();
        return view('roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request)
    {
        $role = $this->roleRepository->create($request->validated());
        return redirect()->route('roles.show', $role)->with('success', 'Função criada com sucesso!');
    }

    /**
     * Edit the specified resource.
     */
    public function edit(Role $role)
    {
        $permissions = Permission::all();
        return view('roles.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        $this->roleRepository->update($role->id, $request->validated());
        return redirect()->route('roles.show', $role)->with('success', 'Função atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        if ($role->id === 1) {
            return redirect()->route('roles.index')->with('error', 'A função padrão não pode ser excluída.');
        }
        $deleted = $this->roleRepository->delete($role->id);

        if (!$deleted) {
            return redirect()->route('roles.index')->with('error', 'Não é possível excluir a função porque ela está associada a um ou mais usuários.');
        }
        return redirect()->route('roles.index')->with('success', 'Função excluída com sucesso!');
    }
}
