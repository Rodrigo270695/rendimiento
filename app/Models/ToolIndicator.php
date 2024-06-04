<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToolIndicator extends Model
{
    use HasFactory;

    protected $table = 'tool_indicator';

    protected $guarded = [];

    public function tool()
    {
        return $this->belongsTo(Tool::class);
    }

    public function indicator()
    {
        return $this->belongsTo(Indicator::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
