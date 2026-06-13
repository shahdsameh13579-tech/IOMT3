<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Analysis extends Model
{
    use HasFactory;

    protected $fillable = [
        'log_id',
        'total_entries',
        'total_findings',
        'zero_day_rate',
        'accuracy',
        'results_json',
    ];

    protected $casts = [
        'results_json' => 'array',
    ];

    public function log()
    {
        return $this->belongsTo(Log::class, 'log_id');
    }

    public function findings()
    {
        return $this->hasMany(Finding::class, 'analysis_id');
    }
}
