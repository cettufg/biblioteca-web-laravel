<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ObraPesquisador;
use App\Models\Instituicao;

class Obra extends Model
{
    use HasFactory;

    protected $fillable = [
        'thumb',
        'titulo',
        'data_publicacao',
        'instituicao_id',
        'arquivo',
        'nota',
        'assunto',
        'tipo',
        'lingua',
        'licenca',
    ];

    public function instituicao()
    {
        return $this->belongsTo(Instituicao::class);
    }

    public function pesquisadores()
    {
        return $this->belongsToMany(Pesquisador::class, 'obra_pesquisadores', 'obra_id', 'pesquisador_id');
    }
}
