<?php

namespace App\Models;

use App\Traits\Searchable;
use Spatie\Permission\Models\Permission as SpatiePermission;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Permission extends SpatiePermission
{
    use LogsActivity, Searchable;

    protected $table = 'permissions';

    /**
     * The columns that can be searched.
     */
    protected $searchable = ['name', 'description', 'guard_name'];

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'description',
        'guard_name',
    ];

     /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'name' => 'string',
        'description' => 'string',
        'guard_name' => 'string',
    ];

     /**
     * Get the activity log options for the model.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->setDescriptionForEvent(fn(string $eventName) => ActivityLog::getDescricaoGenericaEvento($eventName))
            ->useLogName('Permissão')
            ->dontSubmitEmptyLogs()
            ->logOnlyDirty()
            ->logAll();
    }
}
