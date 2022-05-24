<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    /**
     * One to many relationship
     */
    public function prescription(){
        return $this->belongsTo(Prescription::class);
    }
}

