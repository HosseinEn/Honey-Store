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
    public function index(Request $request)
    {
        $products = Product::orderBy("created_at", "desc")->get();
        $products->load(['attributes', 'image']);
        if ($request->has('search_key')) {
            $search_key = $request->get('search_key');
            $products = Product::where('name', 'like', '%' . $search_key . '%')->get();
        }
        else if (
            $request->has('status') || $request->has('stock') ||
            (
                $request->has('from') &&
                $request->has('to')
            )
        ) {
            // dd($request->get('stock'));
            if ($request->has('from') && $request->has('to')) {
                $products = $this->applyDateFilter($products, $request->get('from'), $request->get('to'));
            }
            if ($request->has('status')) {
                $products = $this->applyStatusFilter($products, $request->get('status'));
            }
            if ($request->get('stock') != null) {
                $products = $this->applyStockFilter($products, $request->get('stock'));
            }
        }
        return new JsonResponse([
            'products' => $products
        ]);
    }

    private function applyDateFilter($products, $from, $to) {
        $messages = []; 
        $dateNotFilled = $from == "null" && $to == "null";
        if ($dateNotFilled) {
            return $products;
        }
        if ($from == "null" || $to == "null") {
            if ($from == "null") {
                $messages['from'] = 'لطفا تاریخ شروع را وارد نمایید!';
            }
            if ($to == "null") {
                $messages['to'] = 'لطفا تاریخ پایان را وارد نمایید!';
            }
            throw ValidationException::withMessages($messages);
        }
        return $products->whereBetween('created_at', [$from, $to]);
    }

    private function applyStatusFilter($products, $status) {
        if ($status == 'all') {
            return $products;
        }
        return $products->where('status', $status);
    }

    private function applyStockFilter($products, $stock) {
        if ($stock == "1") {
            return $products = $products->where('stock', ">" , 0);
        } else {
            return $products = $products->where('stock' , 0);
        }
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
        // dd($request->only($dataForInsert));
        // dd($request->product_attributes);

        $request->merge(['stock' => $totalStock]);
        $product = Product::create($request->only($dataForInsert));
        foreach ($request->product_attributes as $attribute_id => $values) {
            // dd(array_key_exists("discount_id",$values));
            // dd(in_array("discount_id", $values));
            $product->attributes()->syncWithOutDetaching([
                $attribute_id => [
                    'stock' => $values['stock'],
                    'price' => $values['price'],
                    'discount_id' => array_key_exists("discount_id",$values) ? $values['discount_id'] : null
                ]
            ]);
        }  
        
        if($request->hasFile('image')) {

            $path = $request->file('image')->store('public/product_images');
            $product->image()->save(Image::make(['path' => Storage::url($path)]));
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
        if (!empty($request->image)) {
            $request->validate([
                'image' => 'image|mimes:jpeg,jpg,png,gif',
            ], [
                'image.image' => 'فایل انتخابی باید یک تصویر باشد!',
                'image.mimes' => 'لطفا یک تصویر با پسوندهای روبه رو آپلود نمایید: jpeg, jpg, png, gif' 
            ]);
        }
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
                    'discount_id' => array_key_exists('discount_id', $values) ? $values['discount_id'] : null
                ]
            ]);
        }

        $request->merge(['stock' => $totalStock]);

        if($request->hasFile('image')) {
            $oldImagePath = $product->image->path;
            $oldImagePath = str_replace('/storage', 'public', $oldImagePath);
            Storage::delete($oldImagePath);
            $path = $request->file('image')->store('public/product_images');
            $product->image()->update(["path"=>Storage::url($path)]);
        }

        $product->update($request->all());

        return new JsonResponse([
            'success' => 'محصول با موفقیت ویرایش شد!',
            'product' => $product->load('attributes')
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
