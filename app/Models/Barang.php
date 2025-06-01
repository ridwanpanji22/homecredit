<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $guarded = ['id'];

    public function kredits() {
        return $this->hasMany(Kredit::class);
    }

}
