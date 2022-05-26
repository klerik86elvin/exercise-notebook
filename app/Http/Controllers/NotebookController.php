<?php

namespace App\Http\Controllers;

use App\Models\Notebook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NotebookController extends Controller
{
    public function index()
    {
        return response()->json(['data' => Notebook::all()]);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required'],
            'company' => ['nullable'],
            'phone' => ['required'],
            'email' => ['required', 'nullable'],
            'birthday' => ['nullable', 'date_format:d.m.Y'],
            'photo' => ['nullable', 'image']
        ]);
        if ($validator->fails()){
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $input = $validator->validated();

        if ($input['birthday']){
            $input['birthday'] = date("Y.m.d", strtotime($input['birthday']));
        }
        $data = Notebook::create($input);
        if ($request->hasFile('photo')){
            $data->update(['photo' => $request->photo->store('photos', 'public')]);
        }

        return response()->json(['message' => 'success'], 200);
    }

    public function show($id){
        $data = Notebook::find($id);
        if ($data){
            return response()->json(['data' => $data], 200);
        }
        return response()->json(['errors' => 'not found'], 404);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required'],
            'company' => ['nullable'],
            'phone' => ['required'],
            'email' => ['required', 'nullable'],
            'birthday' => ['nullable', 'date_format:d.m.Y'],
            'photo' => ['nullable', 'image']
        ]);
        if ($validator->fails()){
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $data = Notebook::find($id);
        if ($data){
            $data->update($validator->validated());
            return response()->json(['message' => 'deleted success'], 200);
        }

        return response()->json(['errors' => 'not found'], 404);
    }

    public function delete($id)
    {
        $data = Notebook::find($id);
        if ($data){
            $data->delete();
            return response()->json(['message' => 'deleted success'], 200);
        }
        return response()->json(['errors' => 'not found'], 404);
    }
}
