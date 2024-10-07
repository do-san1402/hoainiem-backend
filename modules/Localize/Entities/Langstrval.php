<?php

namespace Modules\Localize\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Langstrval extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function localize()
    {
        return $this->belongsTo(Localize::class);
    }

    public function langstring()
    {
        return $this->belongsTo(Langstring::class);
    }
}
