<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class AdModelTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_example(): void
    {
        $this->assertTrue(true);
    }

    public function test_fillable_fields()
    {
        $ad = new \App\Models\Ad([
            'name' => 'Test',
            'description' => 'Opis',
            'price' => 123.45,
            'images' => ['img1.jpg', 'img2.jpg'],
        ]);
        $this->assertEquals('Test', $ad->name);
        $this->assertEquals('Opis', $ad->description);
        $this->assertEquals(123.45, $ad->price);
        $this->assertEquals(['img1.jpg', 'img2.jpg'], $ad->images);
    }

    public function test_images_cast_to_array()
    {
        $ad = new \App\Models\Ad(['images' => ['a.jpg', 'b.jpg']]);
        $this->assertIsArray($ad->images);
    }
}
