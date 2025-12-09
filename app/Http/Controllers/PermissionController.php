<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Repositories\Eloquent\PermissionRepository;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class PermissionController extends Controller implements HasMiddleware
{
    /**
     * Construct a new repository instance.
     */
    protected $permissionRepository;

    /**
     * Create a new controller instance.
     */
    public function __construct(PermissionRepository $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
    }

    /**
     * Middleware assignment.
     */
    public static function middleware()
    {
        return [
            new Middleware('permission:view_permissions', ['only' => ['index', 'show']]),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $permissions = $this->permissionRepository->all($request, 15);
        return view('permissions.index', compact('permissions'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Permission $permission)
    {
        return view('permissions.show', compact('permission'));
    }
}
