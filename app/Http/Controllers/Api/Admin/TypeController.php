<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAdminTypeRequest;
use App\Http\Requests\UpdateAdminTypeRequest;
use Illuminate\Validation\Rule;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $types = Type::latest()->get();
        return new JsonResponse([
            'types' => $types
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreAdminTypeRequest $request)
    {
        $request->merge([
            "slug"=>$this->make_slug($request, '-')
        ]);
        $type = Type::create($request->all());
        return new JsonResponse([
            'type' => $type
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
            'type' => $type
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Type $type, UpdateAdminTypeRequest $request)
    {
        if($this->slugUpdated($request->slug, $type->slug)) {
            $request->merge([
                'slug' => $this->make_slug($request)
            ]);
            $request->validate([
                'slug' => Rule::unique('types')->ignore($type->id)
            ]);
        }
        $type->update($request->all());
        return new JsonResponse([
            'type' => $type
        ]);
    }

    private function slugUpdated($requestSlug, $modelSlug) {
        return $requestSlug !== $modelSlug;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Type $type)
    {
        $type->delete();
        return new JsonResponse([
            'success' => 'Type destroyed successfully!'
        ]);
    }
}
