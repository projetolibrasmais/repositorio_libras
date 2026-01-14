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

    /**
     * The columns that can be searched.
     */
    protected $searchable = ['nome', 'slug'];

    /**
     * The attributes that can be filtered.
     */
    protected $filterable = [
        'nome' => 'like',
        'slug' => 'like',
        'date_from:created_at' => 'date_from',
        'date_to:created_at' => 'date_to',
    ];

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'nome',
        'slug',
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'nome' => 'string',
        'slug' => 'string',
    ];

    /**
     * Relationship to Sinal model.
     */
    public function sinais()
    {
        return $this->belongsToMany(Sinal::class, 'sinal_categoria', 'categoria_id', 'sinal_id');
    }

    /**
     * Get the activity log options for the model.
     */
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
