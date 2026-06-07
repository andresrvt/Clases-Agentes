<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IaConfiguration extends Model
{
    protected $table = 'ia_configuration';

    protected $fillable = ['prompt', 'model', 'process_name', 'status'];

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeByProcess($query, string $processName)
    {
        return $query->where('process_name', $processName);
    }
}