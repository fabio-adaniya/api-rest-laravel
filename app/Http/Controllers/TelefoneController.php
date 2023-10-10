<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Telefone;
use Illuminate\Support\Facades\Validator;

class TelefoneController extends Controller
{
    public function index()
    {
        $telefone = Telefone::query();
        $telefone = $telefone->get()->toJson();

        return $telefone;
    }

    public function show($telefone)
    {
        if(Telefone::where('id', $telefone)->exists())
            return Telefone::find($telefone)->toJson();
        else
            return response()->json([
                'message' => 'O telefone ' . $telefone . ' não foi localizado!',
            ], 404);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'telefone' => 'required|unique:telefones',
        ]);

        if($validator->fails())
            return response()->json([
                'message' => 'Não foi possível cadastrar!',
                'errors' => $validator->errors(),
            ], 400);

        Telefone::create($validator->validated());

        return response()->json([
            'message' => 'Telefone cadastrado com sucesso!',
        ], 201);
    }

    public function update(Request $request, $telefone)
    {
        if(Telefone::where('id', $telefone)->exists())
        {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'telefone' => 'required|unique:telefones',
            ]);

            if($validator->fails())
                return response()->json([
                    'message' => 'Não foi possível atualizar!',
                    'errors' => $validator->errors(),
                ], 400);

            $telefone = Telefone::find($telefone);
            $telefone->fill($validator->validated());
            $telefone->update();

            return response()->json([
                'message' => 'Telefone ' . $telefone->id . ' atualizado com sucesso!',
            ]);
        }
        else
            return response()->json([
                'message' => 'O telefone ' . $telefone . ' não foi localizado!',
            ], 404);
    }

    public function destroy($telefone)
    {
        if(Telefone::where('id', $telefone)->exists())
        {
            $telefone = Telefone::find($telefone);
            $telefone->delete();

            return response()->json([
                'message' => 'Telefone ' . $telefone->id . ' deletado com sucesso!',
            ]);
        }
        else
            return response()->json([
                'message' => 'O telefone ' . $telefone . ' não foi localizado!',
            ], 404);
    }
}
