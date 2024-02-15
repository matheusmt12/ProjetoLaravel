<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venda extends Model
{
    protected $fillable = ['name','valor'];


    public function parcelas(){
        return $this->hasMany(Parcela::class);
    }
}
