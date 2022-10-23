<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\Http\Requests\StoreTypeRequest;
use App\Http\Requests\UpdateTypeRequest;
use Cviebrock\EloquentSluggable\Services\SlugService;

class TypeController extends Controller
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
        $types = Type::orderBy("created_at", "desc")->paginate($perPage)->appends([
            'per_page' => $perPage
        ]);
        // dump($types->pluck('name'));

        return new JsonResponse([
            'data' => $types
        ]);

        // return $types;

        // $types = Type::all()->paginate(self::PAGINATEDBY);
        // $pageNumberMultiplyPaginationSize = $this->calculate($request);

        // return view('admin.types.index', compact("types", "pageNumberMultiplyPaginationSize"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreTypeRequest $request)
    {

        // $request->merge(["slug" => SlugService::createSlug(Tag::class, 'slug', $request->slug, ['unique' => false])]);
        // $request->validate([
        //     "slug" => Rule::unique("tags", "slug")
        // ]);
        dump($request->slug);
        // $request->name = "آ ا ب پ ت ث ج چ ح خ د ذ ر ز ژ س ش ص ض ط ظ ع غ ف ق ک  گ ل م ن و ه ی"; 
        // $request->name = "سوییت بیبی جیزز"; 
        // $request->name = "سوییت بیبی جیزز"; 
        $request->slug = $this->make_slug($request, '-');
        dump($request->slug);
        $type = Type::create($request->all());
        return new JsonResponse([
            'data' => $type
        ]);
    }

    public function make_slug($request, $separator = '-') {
        $string = is_null($request->slug) ? $request->name : $request->slug;

        $string = trim($string);
        $string = mb_strtolower($string, "UTF-8");;
        // $string = preg_replace("/[^a-z0-9_\sءاأإآؤئبتثجحخدذرزسشصضطظعغفقكلمنهويةى]#u/", "", $string);
        $string = preg_replace("/[^\w_\sءاآؤئبپتثجچحخدذرزژسشصضطظعغفقكکگلمنوهی]#u/", '', $string);
        $string = preg_replace("/[\s-]+/", " ", $string);
        $string = preg_replace("/[\s_]/", $separator, $string);

        return $string;
}

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Type $type)
    {
        // return new JsonResponse([
        //     'data' => $type
        // ]);

        return $type;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Type $type, Request $request)
    {
        // dump($type);
        // dump($request->name);
        // $type = $request->input('name');
        // dump($request->input('name'));
        $type->update($request->all());
        // dump($type);
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
        $type->delete();

        return response()->noContent();
        // return new JsonResponse([
        //     'data' => "deleted"
        // ]);
    }
}
