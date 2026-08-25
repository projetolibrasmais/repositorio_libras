<?php

namespace App\Http\Controllers;

use App\Repositories\Eloquent\LogRepository;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class LogController extends Controller implements HasMiddleware
{
    /**
     * Construct a new controller instance.
     */
    protected $logRepository;

   /**
     * Create a new controller instance.
     */
    public function __construct(LogRepository $logRepository)
    {
        $this->logRepository = $logRepository;
    }

     /**
     * Middleware assignment.
     */
    public static function middleware()
    {
        return [
            new Middleware('permission:view_logs', ['only' => ['index', 'show']]),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $logs = $this->logRepository->all($request, 15);
        
        // Get unique users who have logged activities
        $users = \App\Models\User::whereIn('id', 
            \App\Models\ActivityLog::distinct()->pluck('causer_id')->filter()
        )->orderBy('name')->get();
        
        // Get unique events
        $events = \App\Models\ActivityLog::distinct()->pluck('event')->sort()->values();
        
        // Get unique log names
        $logNames = \App\Models\ActivityLog::distinct()->pluck('log_name')->sort()->values();
        
        return view('logs.index', compact('logs', 'users', 'events', 'logNames'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $log = $this->logRepository->find($id);
        return view('logs.show', compact('log'));
    }
}
