<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parcela extends Model
{
    protected $fillable = ['data_vencimento', 'valor_parcela','venda_id'];
}
