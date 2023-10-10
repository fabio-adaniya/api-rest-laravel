<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Email;

class EmailController extends Controller
{
    public function index()
    {
        $email = Email::query();
        $email = $email->get()->toJson();

        return $email;
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:emails,email',
        ]);

        if($validator->fails())
            return response()->json([
                'message' => 'Não foi possível cadastrar!',
                'errors' => $validator->errors(),
            ], 400);

        Email::create($validator->validated());

        return response()->json([
            'message' => 'E-mail cadastrado com sucesso!',
        ], 201);
    }

    public function show($email)
    {
        if(Email::where('id', $email)->exists())
            return Email::find($email)->toJson();
        else
            return response()->json([
                'message' => 'O e-mail ' . $email . ' não foi localizado!',
            ]);
    }

    public function update(Request $request, $email)
    {
        if(Email::where('id', $email)->exists())
        {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|unique:emails,email,'.$email,
            ]);

            if($validator->fails())
                return response()->json([
                    'message' => 'Não foi possível atualizar!',
                    'errors' => $validator->errors(),
                ], 400);

            $email = Email::find($email);
            $email->fill($validator->validated());
            $email->update();

            return response()->json([
                'message' => 'E-mail ' . $email->id . ' atualizado com sucesso!',
            ]);
        }
        else
            return response()->json([
                'message' => 'O e-mail ' . $email . ' não foi localizado!',
            ], 404);
    }

    public function destroy($email)
    {
        if(Email::where('id', $email)->exists())
        {
            $email = Email::find($email);
            $email->delete();
            return response()->json([
                'message' => 'E-mail ' .  $email->id . ' deletado com sucesso!',
            ]);
        }
        else
            return response()->json([
                'message' => 'O e-mail ' . $email . ' não foi localizado!',
            ], 404);
    }
}
