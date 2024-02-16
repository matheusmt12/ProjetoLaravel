<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venda extends Model
{
    protected $fillable = ['name','valor','data'];
    protected $perPage = 2;

    public function parcelas(){
        return $this->hasMany(Parcela::class);
    }


    public function pessoa(){
        return $this->belongsTo('App\Models\Pessoa');
    }

}
