<?php

namespace App\Models;

use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Categoria extends Model
{
    use LogsActivity, Searchable;

    protected $table = 'categorias';

    protected $searchable = ['nome', 'slug'];

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'nome',
        'slug',
    ];

    protected $casts = [
        'nome' => 'string',
        'slug' => 'string',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->setDescriptionForEvent(fn (string $eventName) => ActivityLog::getDescricaoGenericaEvento($eventName))
            ->useLogName('Categoria')
            ->dontSubmitEmptyLogs()
            ->logOnlyDirty()
            ->logAll();
    }
}
