<?php

namespace App\Models;

use App\Traits\Searchable;
use Spatie\Permission\Models\Role as ModelsRole;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Role extends ModelsRole
{
    use LogsActivity, Searchable;

    protected $table = 'roles';

    /**
     * The columns that can be searched.
     */
    protected $searchable = ['name', 'guard_name'];

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'guard_name',
    ];

     /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'name' => 'string',
        'guard_name' => 'string',
    ];

     /**
     * Get the activity log options for the model.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->setDescriptionForEvent(fn(string $eventName) => ActivityLog::getDescricaoGenericaEvento($eventName))
            ->useLogName('Função')
            ->dontSubmitEmptyLogs()
            ->logOnlyDirty()
            ->logAll();
    }
}
