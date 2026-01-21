<?php

namespace App\Models;

use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Sinal extends Model
{
    use LogsActivity, Searchable, SoftDeletes;

    protected $table = 'sinais';

    /**
     * The columns that can be searched.
     */
    protected $searchable = ['palavra_portugues', 'slug', 'definicao'];

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'palavra_portugues',
        'slug',
        'definicao',
        'instrucao_execucao',
        'status',
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'palavra_portugues' => 'string',
        'slug' => 'string',
        'definicao' => 'string',
        'instrucao_execucao' => 'string',
        'status' => 'string',
    ];

     /**
     * The attributes that can be filtered.
     */
    protected $filterable = [
        'palavra_portugues' => 'like',
        'slug' => 'like',
        'definicao' => 'like',
        'instrucao_execucao' => 'like',
        'status' => '=',
        'categoria_id:categorias.id' => '=',
        'date_from:created_at' => 'date_from',
        'date_to:created_at' => 'date_to',
    ];

    /**
     * The attributes that can be sorted.
     */
    protected $sortable = [
        'id',
        'palavra_portugues',
        'slug',
        'definicao',
        'instrucao_execucao',
        'created_at',
        'updated_at',
    ];

    /**
     * Relationsip to Video model.
     */
    public function video()
    {
        return $this->hasOne(Video::class, 'sinal_id');
    }

    /**
     * Relationship to Categoria model.
     */
    public function categorias()
    {
        return $this->belongsToMany(Categoria::class, 'sinal_categoria', 'sinal_id', 'categoria_id');
    }

    /**
     * Get the activity log options for the model.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->setDescriptionForEvent(fn(string $eventName) => ActivityLog::getDescricaoGenericaEvento($eventName))
            ->useLogName('Sinal')
            ->dontSubmitEmptyLogs()
            ->logOnlyDirty()
            ->logAll();
    }

    /**
     * Boot method to register force delete event logging.
     */
    protected static function booted(): void
    {
        static::forceDeleting(function (Sinal $sinal) {
            activity('Sinal')
                ->causedBy(auth()->user())
                ->performedOn($sinal)
                ->event('force_deleted')
                ->withProperties(['old' => $sinal->toArray()])
                ->log(ActivityLog::getDescricaoGenericaEvento('force_deleted'));
        });
    }
}
