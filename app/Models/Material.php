<?php

namespace App\Models;

use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Material extends Model
{
    use LogsActivity, Searchable, SoftDeletes;

    protected $table = 'materiais';

    /**
     * The columns that can be searched.
     */
    protected $searchable = ['titulo', 'descricao', 'tipo'];

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'titulo',
        'descricao',
        'arquivo_path',
        'tipo',
        'tamanho',
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'titulo' => 'string',
        'descricao' => 'string',
        'arquivo_path' => 'string',
        'tipo' => 'string',
        'tamanho' => 'string',
    ];

    /**
     * The attributes that can be filtered.
     */
    protected $filterable = [
        'titulo' => 'like',
        'descricao' => 'like',
        'date_from:created_at' => 'date_from',
        'date_to:created_at' => 'date_to',
    ];

    /**
     * The attributes that can be sorted.
     */
    protected $sortable = [
        'id',
        'titulo',
        'created_at',
        'updated_at',
    ];

    /**
     * Activity log options.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly($this->fillable)
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
