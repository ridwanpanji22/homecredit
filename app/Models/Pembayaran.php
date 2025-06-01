<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $guarded = ['id'];

    public function kredit() {
        return $this->belongsTo(Kredit::class);
    }

}
