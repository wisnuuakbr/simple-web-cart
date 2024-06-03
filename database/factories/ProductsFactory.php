<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Products>
 */
class ProductsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $products = [
            ['name' => 'iPhone 13', 'image' => 'https://cdn.eraspace.com/media/catalog/product/a/p/apple_iphone_15_pro_natural_titanium_1_6.jpg', 'price' => 14999999],
            ['name' => 'iPad Air', 'image' => 'https://cdn.eraspace.com/media/catalog/product/i/p/ipad_gen_10_10_9_inci_wi-fi_blue_1_2_4.jpg', 'price' => 6499000],
            ['name' => 'MacBook Pro', 'image' => 'https://cdn.eraspace.com/media/catalog/product/m/a/macbook_air_m2_midnight_pdp_image_position-1__id_2.jpg', 'price' => 16999000],
            ['name' => 'AirPods Pro', 'image' => 'https://cdn.eraspace.com/media/catalog/product/a/p/apple_airpods_pro_generasi_ke-2_usb-c_1_1.jpg', 'price' => 3499000],
            ['name' => 'AirPods Max', 'image' => 'https://cdn.eraspace.com/media/catalog/product/a/p/apple_airpods_max_space_grey_1_2.jpg', 'price' => 9499000],
            ['name' => 'Musha Braider Bracelet', 'image' => 'https://down-id.img.susercontent.com/file/id-11134207-7r98q-ll37i3rump02a8.jpg', 'price' => 45000],
            ['name' => 'Musha Black Bracelet', 'image' => 'https://down-id.img.susercontent.com/file/id-11134207-7r98o-lkyqiwjbemwv5f.jpg', 'price' => 50000],
            ['name' => 'Breakside Polo Cap', 'image' => 'https://down-id.img.susercontent.com/file/id-11134207-7r98u-lvvmdw5h17ou9a.jpg', 'price' => 120000],
        ];

        $product = $this->faker->randomElement($products);

        return [
            'name' => $product['name'],
            'image' => $product['image'],
            'price' => $product['price'],
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}