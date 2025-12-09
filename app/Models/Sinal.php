<?php

namespace App\Models;

use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Sinal extends Model
{
    use LogsActivity, Searchable;

    protected $table = 'sinais';

    protected $searchable = ['palavra_portugues', 'slug', 'definicao'];

    protected $fillable = [
        'palavra_portugues',
        'slug',
        'definicao',
        'instrucao_execucao',
        'status',
        'video_principal_id',
    ];

    protected $casts = [
        'palavra_portugues' => 'string',
        'slug' => 'string',
        'definicao' => 'string',
        'instrucao_execucao' => 'string',
        'status' => 'string',
        'video_principal_id' => 'integer',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->setDescriptionForEvent(fn (string $eventName) => ActivityLog::getDescricaoGenericaEvento($eventName))
            ->useLogName('Sinal')
            ->dontSubmitEmptyLogs()
            ->logOnlyDirty()
            ->logAll();
    }
}
