<?php

namespace App\Http\Controllers\Api;

use App\Models\Attribute;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class AttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
                // $types = Type::all()->paginate(self::PAGINATEDBY);
                $perPage = $request->input('per_page') ?? self::PAGINATEDBY;
                $attributes = Attribute::orderBy("created_at", "desc")->paginate($perPage)->appends([
                    'per_page' => $perPage
                ]);
                // dump($types->pluck('name'));
        
                // return new JsonJsonResponse([
                //     'data' => $types
                // ]);
        
                return $attributes;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $attribute = Attribute::create($request->all());
        return new JsonResponse([
            'data' => $attribute
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Attribute  $attribute
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Attribute $attribute)
    {
        return $attribute;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Attribute  $attribute
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Attribute $attribute)
    {
        $attribute->update($request->all());
        // dump($type);
        return new JsonResponse([
            'data' => $attribute
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Attribute  $attribute
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Attribute $attribute)
    {
        $attribute->delete();

        return response()->noContent();
    }
}
