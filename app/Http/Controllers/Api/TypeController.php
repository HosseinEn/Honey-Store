<?php

namespace App\Http\Controllers\Api;

use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $types = Type::all();
        dump($types->pluck('name'));

        return new JsonResponse([
            'data' => $types
        ]);

        // $types = Type::all()->paginate(self::PAGINATEDBY);
        // $pageNumberMultiplyPaginationSize = $this->calculate($request);

        // return view('admin.types.index', compact("types", "pageNumberMultiplyPaginationSize"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        
        $type = Type::create($request->all());
        return new JsonResponse([
            'data' => $type
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Type $type)
    {
        return new JsonResponse([
            'data' => $type
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(Type $type)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Type $type)
    {
        dump($type);
        dump($request->name);
        $type->update($request->all());
        dump($type);
        return new JsonResponse([
            'data' => $type
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Type $type)
    {
        return new JsonResponse([
            'data' => "deleted"
        ]);
    }
}