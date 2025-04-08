<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'description'];

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function variants()
    {
        return $this->hasMany(Variant::class);
    }

    public function saveImages($images)
    {
        foreach ($images as $image) {
            $imageName = time() . rand(1, 99) . '.' . $image->extension();
            $image->storeAs('products', $imageName, 'public');
            $this->images()->create(['image_path' => $imageName]);
        }
    }

    public function saveVariants($names, $prices)
    {
        foreach ($names as $index => $name) {
            $this->variants()->create([
                'variant_name' => $name,
                'price' => $prices[$index]
            ]);
        }
    }
}
