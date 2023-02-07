<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Discount;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAdminDiscountRequest;

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
            'discounts' => $discounts
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
    public function update(Request $request, Discount $discount)
    {
        $validatedData = $this->validate(
                $request,
                [
                    "name" => 'required|unique:discounts,name,'.$discount->id,
                    "value" => 'required|numeric|min:0,max:100',
                ],
                ["name.unique" => 'تخفیف با این نام قبلا ثبت شده است']
            );

        // $discount->update($request->all());
        $discount->update($validatedData);
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
    public function destroy(Discount $discount)
    {
        $discount->delete();
        return new JsonResponse([
            'success' => 'Discount destroyed successfully!'
        ]);
    }
}
