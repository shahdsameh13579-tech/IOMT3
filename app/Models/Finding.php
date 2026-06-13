<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Finding extends Model
{
    use HasFactory;

    protected $fillable = [
        'analysis_id',
        'ip',
        'attack_type',
        'severity',
        'request_uri',
        'status',
        'timestamp',
    ];

    public function analysis()
    {
        return $this->belongsTo(Analysis::class, 'analysis_id');
    }
}
