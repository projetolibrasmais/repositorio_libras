<?php

namespace App\Http\Controllers;

use App\Repositories\Eloquent\ApplicationLogRepository;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ApplicationLogController extends Controller implements HasMiddleware
{
    /**
     * Create a new controller instance.
     */
    public function __construct(private readonly ApplicationLogRepository $logs) {}

    /**
     * Assign middleware to controller actions.
     */
    public static function middleware(): array
    {
        return [new Middleware('permission:view_application_logs', only: ['index', 'show'])];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = $request->validate([
            'search' => ['nullable', 'string', 'max:200'],
            'level' => ['nullable', 'string', 'max:30'],
            'page' => ['nullable', 'integer', 'min:1'],
        ]);

        $logs = $this->logs->paginate($filters, 15);

        return view('application_logs.index', compact('logs'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        abort_unless(ctype_digit($id), 404);
        $log = $this->logs->find((int) $id);
        abort_if($log === null, 404);

        return view('application_logs.show', compact('log'));
    }
}
