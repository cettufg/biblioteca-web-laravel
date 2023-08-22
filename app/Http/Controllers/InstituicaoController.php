<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Instituicao;
use Inertia\Inertia;

class InstituicaoController extends Controller
{
    public function index()
    {
        $instituicoes = Instituicao::with('obras', 'pesquisadores')->get();

        return Inertia::render('Instituicoes/Index', [
            'instituicoes' => $instituicoes,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'razao_social' => 'required',
            'nome_fantasia' => 'required',
            'cnpj' => 'required',
            'tipo' => 'required',
        ], [
            'required' => 'O campo :attribute é obrigatório.',
        ]);

        $instituicao = Instituicao::create([
            'razao_social' => $request['razao_social'],
            'nome_fantasia' => $request['nome_fantasia'],
            'cnpj' => $request['cnpj'],
            'tipo' => $request['tipo'],
        ]);

        return redirect()->back()->with('response', $instituicao);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'razao_social' => 'required',
            'nome_fantasia' => 'required',
            'cnpj' => 'required',
            'tipo' => 'required',
        ], [
            'required' => 'O campo :attribute é obrigatório.',
        ]);

        $instituicao = Instituicao::find($id);

        $instituicao->razao_social = $request['razao_social'];
        $instituicao->nome_fantasia = $request['nome_fantasia'];
        $instituicao->cnpj = $request['cnpj'];
        $instituicao->tipo = $request['tipo'];

        $instituicao->save();

        return redirect()->back()->with('response', $instituicao);
    }

    public function destroy($id)
    {
        $instituicao = Instituicao::find($id);

        // remove relation for pesquisadores
        $pesquisadores = $instituicao->pesquisadores()->get();

        foreach($pesquisadores as $pesquisador) {
            $pesquisador->instituicao_id = null;
            $pesquisador->save();
        }

        // remove relation for obras
        $obras = $instituicao->obras()->get();

        foreach($obras as $obra) {
            $obra->instituicao_id = null;
            $obra->save();
        }

        $instituicao->delete();

        return redirect()->back()->with([
            'response' => $instituicao
        ]);
    }
}
