<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Discount;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAdminDiscountRequest;
use App\Http\Requests\UpdateAdminDiscountRequest;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $discounts = Discount::orderBy("created_at", "desc")->get();
        return new JsonResponse([
            'type' => $discounts
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAdminDiscountRequest $request)
    {
        $discount = Discount::create($request->all());
        return new JsonResponse([
            'discount' => $discount
        ]);
    }

        /**
     * Display the specified resource.
     *
     * @param  \App\Models\Discount  $type
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $id)
    {
        $discount = Discount::findOrFail($id);
        return $discount;
        // return new JsonResponse([
        //     'type' => $discount->first()
        // ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAdminDiscountRequest $request, $id)
    {
        $discount = Discount::findOrFail($id);
        $discount->update($request->all());
        return new JsonResponse([
            'discount' => $discount
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $discount = Discount::findOrFail($id);
        $discount->delete();
        return new JsonResponse([
            'success' => 'Discount destroyed successfully!'
        ]);
    }
}
