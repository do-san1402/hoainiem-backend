<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NewsPosition extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'news_id',
        'page',
        'position',
        'status',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'news_id'  => 'integer',
        'page'     => 'string',
        'position' => 'integer',
        'status'   => 'integer',
    ];

    /**
     * News Mst
     *
     * @return BelongsTo
     */
    public function newsMst(): BelongsTo
    {
        return $this->belongsTo(NewsMst::class, 'news_id', 'news_id');
    }

}
