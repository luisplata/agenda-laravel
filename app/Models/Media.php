<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;
    protected $fillable = ['type', 'file_path', 'person_id'];

    public function person()
    {
        return $this->belongsTo(Person::class);
    }
}
