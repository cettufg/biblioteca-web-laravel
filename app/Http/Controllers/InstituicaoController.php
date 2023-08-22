<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Instituicao;
use Illuminate\Support\Facades\Redirect;
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

        $instituicao->delete();

        return Redirect::back()->with([
            'response' => $instituicao
        ]);
    }
}
