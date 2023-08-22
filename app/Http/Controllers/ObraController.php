<?php

namespace App\Http\Controllers;

use App\Models\Pesquisador;
use App\Models\Obra;
use App\Models\Instituicao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ObraController extends Controller
{
    public function index()
    {
        $pesquisadores = Pesquisador::all();
        $obras = Obra::with('instituicao', 'pesquisadores')->get();
        $instituicoes = Instituicao::all();

        return Inertia::render('Obras/Index', [
            'pesquisadores' => $pesquisadores,
            'obras' => $obras,
            'instituicoes' => $instituicoes,
        ]);
    }

    public function store(Request $request)
    {

        $rules = [
            'titulo' => 'required',
            'data_publicacao' => 'required|date',
            'instituicao_id.value' => 'required|exists:instituicoes,id',
            'nota' => 'required',
            'assunto' => 'required',
            'tipo' => 'required',
            'lingua' => 'required',
            'licenca' => 'required',
            'pesquisadores.*.value' => 'required',
            'thumb' => 'nullable|mimes:jpeg,png',
            'arquivo' => 'nullable|mimes:pdf',
        ];

        $messages = [
            'instituicao_id.value.required' => 'O campo instituição é obrigatório.',
            'required' => 'O campo :attribute é obrigatório.',
            'thumb.mimes' => 'O campo :attribute deve ser uma imagem JPEG ou PNG.',
            'arquivo.mimes' => 'O campo :attribute deve ser um arquivo PDF.',
        ];

        $validated = $request->validate($rules, $messages);

        $obra = Obra::create([
            'titulo' => $validated['titulo'],
            'data_publicacao' => $validated['data_publicacao'],
            'instituicao_id' => $validated['instituicao_id']['value'] ?? null,
            'arquivo' => $request->file('arquivo') ? $request->file('arquivo')->store('obras') : null,
            'thumb' => $request->file('thumb') ? $request->file('thumb')->store('thumbs') : null,
            'nota' => $validated['nota'],
            'assunto' => $validated['assunto'],
            'tipo' => $validated['tipo'],
            'lingua' => $validated['lingua'],
            'licenca' => $validated['licenca'],
        ]);

        $pesquisadoresIds = array_map(function ($pesquisador) {
            return $pesquisador['value'];
        }, $request->input('pesquisadores'));

        $time = now();

        $data = array_combine($pesquisadoresIds, array_fill(0, count($pesquisadoresIds), [
            'created_at' => $time,
            'updated_at' => $time
        ]));

        $obra->pesquisadores()->attach($data);

        return Redirect::back()->with([
            'response' => $obra
        ]);
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'titulo' => 'required',
            'data_publicacao' => 'required|date',
            'instituicao_id.value' => 'required|exists:instituicoes,id',
            'nota' => 'required',
            'assunto' => 'required',
            'tipo' => 'required',
            'lingua' => 'required',
            'licenca' => 'required',
            'pesquisadores.*.value' => 'required',
            'thumb' => 'nullable|mimes:jpeg,png',
            'arquivo' => 'nullable|mimes:pdf',
        ];

        $messages = [
            'instituicao_id.value.required' => 'O campo instituição é obrigatório.',
            'required' => 'O campo :attribute é obrigatório.',
            'thumb.required' => 'O campo :attribute é obrigatório.',
            'thumb.mimes' => 'O campo :attribute deve ser uma imagem JPEG ou PNG.',
            'arquivo.mimes' => 'O campo :attribute deve ser um arquivo PDF.',
        ];

        $validated = $request->validate($rules, $messages);

        $obra = Obra::find($id);

        $obra->titulo = $validated['titulo'];
        $obra->data_publicacao = $validated['data_publicacao'];
        $obra->instituicao_id = $validated['instituicao_id']['value'] ?? null;
        $obra->arquivo = $request->file('arquivo') ? $request->file('arquivo')->store('obras') : $obra->arquivo;
        $obra->thumb = $request->file('thumb') ? $request->file('thumb')->store('thumbs') : $obra->thumb;
        $obra->nota = $validated['nota'];
        $obra->assunto = $validated['assunto'];
        $obra->tipo = $validated['tipo'];
        $obra->lingua = $validated['lingua'];
        $obra->licenca = $validated['licenca'];

        $pesquisadoresIds = array_map(function ($pesquisador) {
            return $pesquisador['value'];
        }, $request->input('pesquisadores'));

        $time = now();

        $data = array_combine($pesquisadoresIds, array_fill(0, count($pesquisadoresIds), [
            'created_at' => $time,
            'updated_at' => $time
        ]));

        $obra->pesquisadores()->sync($data);

        $obra->save();

        return Redirect::back()->with([
            'response' => $obra
        ]);
    }

    public function destroy($id)
    {
        $obra = Obra::find($id);

        // Remover o arquivo do servidor
        if ($obra->arquivo) {
            Storage::delete($obra->arquivo);
        }

        // Remover o thumb do servidor
        if ($obra->thumb) {
            Storage::delete($obra->thumb);
        }


        // Remover as relações de pesquisadores
        $obra->pesquisadores()->detach();

        $obra->delete();

        return Redirect::back()->with([
            'response' => $obra
        ]);
    }

    public function removeThumb($id)
    {
        $obra = Obra::find($id);

        // Remover o arquivo do servidor
        if ($obra->thumb) {
            Storage::delete($obra->thumb);
            $obra->thumb = null;
            $obra->save();
        }

        return Redirect::back()->with([
            'response' => $obra
        ]);
    }

    public function removeArquivo($id)
    {
        $obra = Obra::find($id);

        // Remover o arquivo do servidor
        if ($obra->arquivo) {
            Storage::delete($obra->arquivo);
            $obra->arquivo = null;
            $obra->save();
        }

        return Redirect::back()->with([
            'response' => $obra
        ]);
    }
}
