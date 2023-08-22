<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Obra;
use App\Models\Pesquisador;

class ObraPesquisador extends Model
{
    use HasFactory;

    protected $table = 'obra_pesquisadores';

    protected $fillable = [
        'obra_id',
        'pesquisador_id',
    ];

    public function obra()
    {
        return $this->belongsTo(Obra::class);
    }

    public function pesquisador()
    {
        return $this->belongsTo(Pesquisador::class);
    }
}
