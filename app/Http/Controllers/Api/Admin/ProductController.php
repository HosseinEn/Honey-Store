<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Image;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\StoreAdminProductRequest;
use App\Http\Requests\UpdateAdminProductRequest;

class
ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::get();
        $products->load(['attributes', 'image']);
        return new JsonResponse([
            'products' => $products
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAdminProductRequest $request)
    {
        $request->merge(['slug' =>$this-> make_slug($request)]);
        $dataForInsert = [
            'name',
            'slug',
            'type_id',
            'description',
            'status',
            'image',
            'stock'
        ];

        $totalStock = 0;
        foreach ($request->product_attributes as $attribute_id => $values) {
            $request->validate([
                "product_attributes.{$attribute_id}.stock" => "required|numeric",
                "product_attributes.{$attribute_id}.price" => "required|numeric",
                "product_attributes.{$attribute_id}.discount_id" => "nullable",
            ], [
                "product_attributes.*.stock.required" => 'پر کردن فیلد تعداد برای این وزن الزامی است!',
                "product_attributes.*.stock.numeric" => 'لطفا یک مقدار عددی برای تعداد وارد نمایید!',
                "product_attributes.*.price.required" => 'پر کردن فیلد قیمت برای این وزن الزامی است!',
                "product_attributes.*.price.numeric" => 'لطفا یک مقدار عددی برای قیمت وارد نمایید!'
            ]);
            $totalStock += $values['stock'];
        }

        $request->merge(['stock' => $totalStock]);
        dd($request->all());
        $product = Product::create($request->only($dataForInsert));
        foreach ($request->product_attributes as $attribute_id => $values) {
            $product->attributes()->syncWithOutDetaching([
                $attribute_id => [
                    'stock' => $values['stock'],
                    'price' => $values['price'],
                    'discount_id' => $values['discount_id']
                ]
            ]);
        }  
        
        if($request->hasFile('image')) {
            $path = $request->file('image')->store('public/product_images');
            $product->image()->save(Image::make(['path' => $path]));
        }

        return new JsonResponse([
            'success' => 'محصول با موفقیت ذخیره شد!'
        ]);
    }
 
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $pivotProductSalesSoFar = DB::table('order_product')
            ->select('product_id', 'attribute_id', DB::raw('SUM(quantity) as total_quantity'))
            ->groupBy('product_id', 'attribute_id')
            ->having('product_id', $product->id)
            ->get();
        
        $product->load('attributes', 'image');
        return new JsonResponse([
            'product' => $product,
            'pivotProductSalesSoFar' => $pivotProductSalesSoFar,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAdminProductRequest $request, Product $product)
    {
        if ($this->slugUpdated($request->slug, $product->slug)) {
            $request->merge(['slug' =>$this-> make_slug($request)]);
            $request->validate(['slug' => 'unique:products']);
        }
        $request->validate([
            'product_attributes' => 'required'
        ]);
        $totalStock = 0;
        $product->attributes()->detach();
        foreach ($request->product_attributes as $attribute_id => $values) {
            $request->validate([
                "product_attributes.{$attribute_id}.stock" => "required|int",
                "product_attributes.{$attribute_id}.price" => "required|int",
                "product_attributes.{$attribute_id}.discount_id" => "nullable"
            ]);
            $totalStock += $values['stock'];
            $product->attributes()->syncWithOutDetaching([
                $attribute_id => [
                    'stock' => $values['stock'],
                    'price' => $values['price'],
                    'discount_id' => $values['discount_id']
                ]
            ]);
        }

        $request->merge(['stock' => $totalStock]);

        if($request->hasFile('image')) {
            $oldImagePath = $product->image->path;
            Storage::delete($oldImagePath);
            $path = $request->file('image')->store('public/product_images');
            $product->image()->update(["path"=>$path]);
        }

        $product->update($request->all());

        return new JsonResponse([
            'success' => 'محصول با موفقیت ویرایش شد!'
        ]);
    }

    private function slugUpdated($requestSlug, $modelSlug) {
        return $requestSlug !== $modelSlug;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return new JsonResponse([
            'success' => 'محصول با موفقیت حذف گردید!'
        ]);
    }
}
