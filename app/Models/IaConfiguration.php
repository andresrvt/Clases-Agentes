<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IaConfiguration extends Model
{
    protected $table = 'ia_configuration';

    protected $fillable = ['prompt', 'model', 'job'];
}