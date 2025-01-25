<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $fillable = ['type', 'file_path', 'person_id'];

    public function person()
    {
        return $this->belongsTo(Person::class);
    }
}
