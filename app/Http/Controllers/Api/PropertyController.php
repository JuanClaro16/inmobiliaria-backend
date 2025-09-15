<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PropertyStoreRequest;
use App\Http\Requests\PropertyUpdateRequest;
use App\Models\Property;
use App\Models\PropertyImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\JsonResponse;

class PropertyController extends Controller
{
    // GET /api/properties
    public function index(Request $request)
    {
        $q = Property::with('images');

        // city
        if ($city = $request->query('city')) {
            $q->where('city', 'ILIKE', $city);
        }

        // mode=rent|sale  -> FILTRA y también decide qué columna usar para min/max
        $mode = $request->query('mode');
        if ($mode === 'rent' || $mode === 'sale') {
            $q->where('consignation_type', $mode);   // <-- ESTE FALTA SI NO FILTRA
        }

        // precios
        $min = $request->query('min_price');
        $max = $request->query('max_price');

        if ($min !== null || $max !== null) {
            $col = match ($mode) {
                'rent' => 'rent_price',
                'sale' => 'sale_price',
                default => DB::raw('COALESCE(rent_price, sale_price)'),
            };
            if ($min !== null) $q->where($col, '>=', (int)$min);
            if ($max !== null) $q->where($col, '<=', (int)$max);
        }

        // rooms=1,2,3
        if ($rooms = $request->query('rooms')) {
            $arr = collect(explode(',', $rooms))->filter()->map('intval')->all();
            if ($arr) $q->whereIn('rooms', $arr);
        }

        // features=pool,elevator,dos,comunal
        if ($features = $request->query('features')) {
            $f = collect(explode(',', $features))->map(fn($s) => trim($s))->filter()->all();
            if (in_array('pool', $f))     $q->where('has_pool', true);
            if (in_array('elevator', $f)) $q->where('has_elevator', true);
            if (in_array('dos', $f))      $q->where('parking_type', 'dos');
            if (in_array('comunal', $f))  $q->where('parking_type', 'comunal');
        }

        return $q->orderByDesc('id')->paginate(12);
    }

    // GET /api/properties/{id}
    public function show(Property $property)
    {
        return $property->load('images');
    }

    // POST /api/properties
    public function store(PropertyStoreRequest $request)
    {
        return DB::transaction(function () use ($request) {
            // Tomamos todo menos arrays de imágenes
            $data = $request->safe()->except(['images', 'images_alt']);

            // Normalizar booleanos si vienen en el request
            foreach (['has_pool', 'has_elevator'] as $b) {
                if ($request->has($b)) {
                    $data[$b] = $request->boolean($b);
                }
            }

            $property = Property::create($data);

            // Imágenes 
            if ($request->hasFile('images')) {
                $alts = $request->input('images_alt', []);
                foreach ($request->file('images') as $idx => $file) {
                    $path = $file->store('properties', 'public');
                    PropertyImage::create([
                        'property_id' => $property->id,
                        'path' => $path,
                        'alt' => $alts[$idx] ?? null,
                    ]);
                }
            }

            return response()->json($property->load('images'), 201);
        });
    }

    public function update(PropertyUpdateRequest $request, Property $property)
    {
        return DB::transaction(function () use ($request, $property) {
            $data = $request->safe()->except(['images', 'images_alt']);


            foreach (['has_pool', 'has_elevator'] as $b) {
                if ($request->has($b)) {
                    $data[$b] = $request->boolean($b);
                }
            }

            // Rellena y guarda
            $property->fill($data);
            $property->save();


            if ($request->hasFile('images')) {
                $alts = $request->input('images_alt', []);
                foreach ($request->file('images') as $idx => $file) {
                    $path = $file->store('properties', 'public');
                    PropertyImage::create([
                        'property_id' => $property->id,
                        'path' => $path,
                        'alt' => $alts[$idx] ?? null,
                    ]);
                }
            }

            return $property->fresh('images');
        });
    }

    // DELETE /api/properties/{id}
    public function destroy(Property $property)
    {
        return DB::transaction(function () use ($property) {
            // Borrar archivos físicos de sus imágenes
            foreach ($property->images as $img) {
                Storage::disk('public')->delete($img->path);
                $img->delete();
            }
            $property->delete();
            return response()->json(null, 204);
        });
    }

    public function cities(): JsonResponse
    {
        $cities = Property::query()
            ->whereNotNull('city')
            ->select('city')
            ->distinct()
            ->orderBy('city')
            ->pluck('city')
            ->values();

        return response()->json($cities, 200);
    }
}
