<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    use HasFactory;

        // Many to many relation
        public function drugs() {
            $this->belongsToMany(Drug::class);
        }
}
