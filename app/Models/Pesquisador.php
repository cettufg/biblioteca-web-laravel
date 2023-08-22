<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Obra;
use App\Models\Instituicao;

class Pesquisador extends Model
{
    use HasFactory;

    protected $table = 'pesquisadores';

    protected $fillable = [
        'nome',
        'data_nascimento',
        'sexo',
        'cpf',
        'universidade',
        'instituicao_id',
    ];

    public function instituicao()
    {
        return $this->belongsTo(Instituicao::class);
    }

    public function obras()
    {
        return $this->belongsToMany(Obra::class, 'obra_pesquisadores', 'pesquisador_id', 'obra_id');
    }
}
