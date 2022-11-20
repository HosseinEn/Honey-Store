<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Attribute;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAdminAttributeRequest;
use App\Http\Requests\UpdateAdminAttributeRequest;

class AttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $attributes = Attribute::orderBy("weight", "asc")->get();
        return new JsonResponse([
            'attributes' => $attributes
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreAdminAttributeRequest $request)
    {
        $attribute = Attribute::create($request->all());
        return new JsonResponse([
            'attribute' => $attribute
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
        return new JsonResponse([
            'type' => $attribute
        ]);
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
        $validatedData = $this->validate(
            $request,
            [
                "weight" => 'required|unique:attributes,id,'.$attribute->id,
            ],
            [
                "weight.unique" => 'ویژگی با این وزن قبلا ثبت شده است'
            ]
        );

        $attribute->update($validatedData);
        return new JsonResponse([
            'type' => $attribute
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
        return new JsonResponse([
            'success' => 'Attribute destroyed successfully!'
        ]);
    }
}

