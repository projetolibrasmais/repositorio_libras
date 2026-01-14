<?php

namespace App\Models;

use App\Traits\Searchable;
use Spatie\Activitylog\Models\Activity;

class ActivityLog extends Activity
{
    use Searchable;
    
    protected $table = 'activity_log';

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'properties' => 'collection',
    ];

    /**
     * The attributes that should be used for searching.
     */
    protected $searchable = [
        'log_name',
        'description',
        'subject_type',
        'properties',
    ];

    /**
     * The attributes that can be filtered.
     */
    protected $filterable = [
        'subject_type' => 'like',
        'causer_type' => 'like',
        'event' => '=',
        'causer_id' => '=',
        'user_id:causer_id' => '=',
        'log_name' => '=',
        'date_from:created_at' => 'date_from',
        'date_to:created_at' => 'date_to',
    ];

    /**
     * The attributes that can be sorted.
     */
    protected $sortable = [
        'id',
        'description',
        'subject_type',
        'causer_type',
        'event',
        'created_at',
        'updated_at',
        'causer_id',
    ];

    public function getEvento()
    {
        return static::getEventoTraducao($this->event);
    }

    public static function getEventoTraducao($eventName)
    {
        switch ($eventName) {
            case 'created':
                return 'criado';
            case 'updated':
                return 'atualizado';
            case 'deleted':
                return 'deletado';
            case 'restored':
                return 'restaurado';
            default:
                return $eventName;
        }
    }

    public function getDescricao()
    {
        switch ($this->description) {
            case 'created':
                return 'Criação';
            case 'updated':
                return 'Atualização';
            case 'deleted':
                return 'Remoção';
            case 'restored':
                return 'Restauração';
            default:
                return $this->description;
        }
    }

    public static function getDescricaoGenericaEvento($eventName)
    {
        $evento = static::getEventoTraducao($eventName);

        return "Este registro foi {$evento}";
    }

    public static function logDisabledEvent($subject)
    {
        activity()
            ->causedBy(auth()->user())
            ->performedOn($subject)
            ->event('disabled')
            ->log('Este registro foi desativado');
    }

    public static function logEnabledEvent($subject)
    {
        activity()
            ->causedBy(auth()->user())
            ->performedOn($subject)
            ->event('enabled')
            ->log('Este registro foi ativado');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'causer_id');
    }
}