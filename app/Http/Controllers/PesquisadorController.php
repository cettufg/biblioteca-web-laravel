<?php

namespace App\Http\Controllers;

use App\Models\Pesquisador;
use App\Models\Obra;
use App\Models\Instituicao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class PesquisadorController extends Controller
{
    public function index()
    {
        $pesquisadores = Pesquisador::with('obras', 'instituicao')->get();
        $obras = Obra::all();
        $instituicoes = Instituicao::all();

        return Inertia::render('Pesquisadores/Index', [
            'pesquisadores' => $pesquisadores,
            'obras' => $obras,
            'instituicoes' => $instituicoes,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required',
            'data_nascimento' => 'required',
            'sexo' => 'required',
            'cpf' => 'required',
            'universidade' => 'required',
            'instituicao_id.value' => 'required',
        ], [
            'instituicao_id.value.required' => 'O campo instituição é obrigatório.',
            'required' => 'O campo :attribute é obrigatório.',
        ]);


        $pesquisador = Pesquisador::create([
            'nome' => $request['nome'],
            'data_nascimento' => $request['data_nascimento'],
            'sexo' => $request['sexo'],
            'cpf' => $request['cpf'],
            'universidade' => $request['universidade'],
            'instituicao_id' => $request->input('instituicao_id.value'),
        ]);

        return Redirect::back()->with([
            'response' => $pesquisador
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required',
            'data_nascimento' => 'required',
            'sexo' => 'required',
            'cpf' => 'required',
            'universidade' => 'required',
            'instituicao_id.value' => 'required',
        ], [
            'instituicao_id.value.required' => 'O campo instituição é obrigatório.',
            'required' => 'O campo :attribute é obrigatório.',
        ]);

        $pesquisador = Pesquisador::find($id);

        $pesquisador->nome = $request['nome'];
        $pesquisador->data_nascimento = $request['data_nascimento'];
        $pesquisador->sexo = $request['sexo'];
        $pesquisador->cpf = $request['cpf'];
        $pesquisador->universidade = $request['universidade'];
        $pesquisador->instituicao_id = $request->input('instituicao_id.value');

        $pesquisador->save();

        return Redirect::back()->with([
            'response' => $pesquisador
        ]);
    }

    public function destroy($id)
    {
        $pesquisador = Pesquisador::find($id);

        $pesquisador->delete();

        return Redirect::back()->with([
            'response' => $pesquisador
        ]);
    }
}
