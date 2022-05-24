<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Drug extends Model
{
    use HasFactory;

        // Many to many relation
        public function quotations(){
            return $this->belongsToMany(Quotation::class);
        }
}
