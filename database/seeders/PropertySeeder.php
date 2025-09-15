<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Property;
use App\Models\PropertyImage;

class PropertySeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            ['city' => 'Bucaramanga', 'rooms' => 2, 'bathrooms' => 2, 'consignation_type' => 'rent', 'rent_price' => 900000, 'has_pool'=>false,'has_elevator'=>true,'parking_type'=>'comunal', 'image' => 'properties/casa1.jpeg'],
            ['city' => 'Bogotá', 'rooms' => 3, 'bathrooms' => 2, 'consignation_type' => 'sale', 'sale_price' => 350000000, 'has_pool'=>true,'has_elevator'=>false,'parking_type'=>'dos', 'image' => 'properties/casa2.jpeg'],
            ['city' => 'Medellín', 'rooms' => 1, 'bathrooms' => 1, 'consignation_type' => 'rent', 'rent_price' => 950000, 'has_pool'=>true,'has_elevator'=>true,'parking_type'=>'comunal', 'image' => 'properties/casa3.jpeg'],
            ['city' => 'Cali', 'rooms' => 4, 'bathrooms' => 3, 'consignation_type' => 'sale', 'sale_price' => 520000000, 'has_pool'=>true,'has_elevator'=>false,'parking_type'=>'dos', 'image' => 'properties/casa4.jpeg'],
            ['city' => 'Barranquilla', 'rooms' => 2, 'bathrooms' => 2, 'consignation_type' => 'rent', 'rent_price' => 1100000, 'has_pool'=>true,'has_elevator'=>false,'parking_type'=>'dos', 'image' => 'properties/casa5.jpeg'],
            ['city' => 'Cartagena', 'rooms' => 3, 'bathrooms' => 2, 'consignation_type' => 'sale', 'sale_price' => 480000000, 'has_pool'=>true,'has_elevator'=>false,'parking_type'=>'dos', 'image' => 'properties/casa6.jpeg'],
            ['city' => 'Cúcuta', 'rooms' => 2, 'bathrooms' => 1, 'consignation_type' => 'rent', 'rent_price' => 800000, 'has_pool'=>false,'has_elevator'=>true,'parking_type'=>'comunal', 'image' => 'properties/casa7.jpeg'],
        ];

        foreach ($rows as $r) {
            $imagePath = $r['image'];
            unset($r['image']); 
            $p = Property::create($r);

            PropertyImage::create([
                'property_id' => $p->id,
                'path' => $imagePath,
                'alt' => "Foto {$p->city}",
            ]);
        }
    }
}
