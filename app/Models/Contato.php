<?php

namespace App\Models;

use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Contato extends Model
{
    use HasFactory, LogsActivity, Searchable;

    protected $table = 'contatos';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'nome',
        'email',
        'assunto',
        'mensagem',
        'resposta',
        'lido',
        'respondido_em',
        'canal_resposta',
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'lido' => 'boolean',
        'respondido_em' => 'datetime',
    ];

    /**
     * The columns that can be searched.
     */
    protected $searchable = [
        'nome',
        'email',
        'assunto',
        'mensagem',
    ];

    /**
     * The columns that can be sorted.
     */
    protected $sortable = [
        'nome',
        'email',
        'assunto',
        'lido',
        'created_at',
    ];

    /**
     * The columns that can be filtered.
     */
    protected $filterable = [
        'nome',
        'email',
        'assunto',
        'lido',
    ];

    /**
     * Get the options for logging activity.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->setDescriptionForEvent(fn(string $eventName) => ActivityLog::getDescricaoGenericaEvento($eventName))
            ->useLogName('Contato')
            ->dontSubmitEmptyLogs()
            ->logOnlyDirty()
            ->logAll();
    }
}
