<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Video extends Model
{
    use SoftDeletes;
    
    protected $table = 'desenhos';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'url_desenho',
        'sinal_id',
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'url_desenho' => 'string',
        'sinal_id' => 'integer',
    ];

    /**
     * Get the sinal associated with the desenho.
     */
    public function sinal()
    {
        return $this->belongsTo(Sinal::class, 'sinal_id');
    }
}
