<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = true;

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }
}
