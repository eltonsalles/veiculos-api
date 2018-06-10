<?php

namespace App\Http\Controllers\API;

use App\Veiculo;
use App\Http\Requests\IndexRequest;
use App\Http\Requests\VeiculoRequest;
use App\Http\Controllers\Controller;

class VeiculoController extends Controller
{
    /**
     * @param IndexRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(IndexRequest $request)
    {
        $limit = $request->all()['limit'] ?? 10;

        $result = Veiculo::paginate($limit);

        return response()->json($result);
    }

    /**
     * @param IndexRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function find(IndexRequest $request)
    {
        $limit = $request->all()['limit'] ?? 10;

        $like = $request->all()['q'] ?? null;
        if ($like !== null) {
            $like = explode(',', $like);
            $like[1] = "%{$like[1]}%";
        }

        $result = Veiculo::where(function ($query) use ($like) {
            if ($like) {
                return $query->where($like[0], 'like', $like[1]);
            }

            return $query;
        })->paginate($limit);

        return response()->json($result);
    }

    /**
     * @param VeiculoRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(VeiculoRequest $request)
    {
        $veiculo = Veiculo::create($request->all());

        return response()->json($veiculo, 201);
    }

    /**
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $veiculo = Veiculo::find($id);

        if (!$veiculo) {
            return response()->json(['message' => 'record not found'], 404);
        }

        return response()->json($veiculo);
    }

    /**
     * @param VeiculoRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(VeiculoRequest $request, $id)
    {
        $veiculo = Veiculo::find($id);

        if (!$veiculo) {
            return response()->json(['message' => 'record not found'], 404);
        }

        $veiculo->update($request->all());

        return response()->json($veiculo);
    }

    /**
     * @param  int $id
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy($id)
    {
        $veiculo = Veiculo::find($id);

        if (!$veiculo) {
            return response()->json(['message' => 'record not found'], 404);
        }

        $veiculo->delete();

        return response()->json($veiculo);
    }
}
