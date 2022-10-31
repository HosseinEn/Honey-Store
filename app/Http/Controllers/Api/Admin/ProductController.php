<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAdminProductRequest;
use App\Http\Requests\UpdateAdminProductRequest;
use App\Models\Image;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

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
        $request->validate(['slug' => 'unique:products']);
        $dataForInsert = [
            'name',
            'slug',
            'type_id',
            'discount_id',
            'description',
            'status',
            'images',
            'stock'
        ];

        $totalStock = 0;
        foreach ($request->product_attributes as $attribute_id => $values) {
            $request->validate([
                "product_attributes.{$attribute_id}.stock" => "required|int",
                "product_attributes.{$attribute_id}.price" => "required|int",
            ]);
            $totalStock += $values['stock'];
        }

        $request->merge(['stock' => $totalStock]);

        $product = Product::create($request->only($dataForInsert));
        foreach ($request->product_attributes as $attribute_id => $values) {
            $product->attributes()->syncWithOutDetaching([
                $attribute_id => [
                    'stock' => $values['stock'],
                    'price' => $values['price']
                ]
            ]);
        }  
        
        if($request->hasFile('images')) {
            foreach ($request->images as $image) {
                $path = $image->store('public/product_images');
                $product->images()->save(Image::make(['path' => $path]));
            }
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
        $product->load('attributes', 'images');
        return new JsonResponse([
            'product' => $product
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

        $totalStock = 0;
        $product->attributes()->detach();
        foreach ($request->product_attributes as $attribute_id => $values) {
            $request->validate([
                "product_attributes.{$attribute_id}.stock" => "required|int",
                "product_attributes.{$attribute_id}.price" => "required|int",
            ]);
            $totalStock += $values['stock'];
            $product->attributes()->syncWithOutDetaching([
                $attribute_id => [
                    'stock' => $values['stock'],
                    'price' => $values['price']
                ]
            ]);
        }

        $request->merge(['stock' => $totalStock]);

        $product->update($request->all());

        return new JsonResponse([
            'success' => 'محصول با موفقیت ویرایش شد!'
        ]);
    }

    public function deleteImage(Request $request, Product $product) {
        if ($product->images()->count() == 1) {
            throw ValidationException::withMessages([
                'image_id' => ['محصول باید حداقل یک تصویر داشته باشد!']
            ]);
        }
        else {
            $request->validate([
                'image_id' => 'required|exists:images,id'
            ]); 
            $product->images->filter(function($image) use ($request) {
                return $image->id == $request->image_id;
            })->first()->delete();
            return new JsonResponse([
                'success' => 'تصویر با موفقیت حذف گردید.'
            ]);
        }
    }

    public function addImage(Request $request, Product $product) {
        if ($product->images->count() == 3) {
            throw ValidationException::withMessages([
                'image' => ['امکان افزودن بیش از سه تصویر برای محصول نمی باشد!']
            ]);
        }
        else {
            // TODO adding three separate inputs for images
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,gif'
            ]);
            $path = $request->file('image')->store('public/product_images');
            $product->images()->save(Image::make(['path' => $path]));
        }
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
