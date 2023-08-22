<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Obra;
use App\Models\Pesquisador;

class Instituicao extends Model
{
    use HasFactory;

    protected $table = 'instituicoes';

    protected $fillable = [
        'nome_fantasia',
        'razao_social',
        'cnpj',
        'tipo',
    ];

    public function obras()
    {
        return $this->hasMany(Obra::class);
    }

    public function pesquisadores()
    {
        return $this->hasMany(Pesquisador::class);
    }


}
