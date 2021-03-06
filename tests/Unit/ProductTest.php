<?php

namespace Tests\Unit;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductLevel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\QueryException;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_belongs_to_a_brand()
    {
        $product = make(Product::class);
        $this->assertInstanceOf(BelongsTo::class, $product->brand());
        $this->assertInstanceOf(Brand::class, $product->brand);
    }

    /** @test */
    public function it_belongs_to_a_category()
    {
        $product = make(Product::class);
        $this->assertInstanceOf(BelongsTo::class, $product->category());
        $this->assertInstanceOf(Category::class, $product->category);
    }

    /** @test */
    public function it_belongs_to_a_level()
    {
        $product = make(Product::class);
        $this->assertInstanceOf(BelongsTo::class, $product->level());
        $this->assertInstanceOf(ProductLevel::class, $product->level);
    }

    /** @test */
    public function it_needs_a_brand()
    {
        $this->expectException(QueryException::class);
        create(Product::class, ['brand_id' => null]);
    }

    /** @test */
    public function it_needs_an_existing_brand()
    {
        $this->expectException(QueryException::class);
        create(Product::class, ['brand_id' => 9]);
    }

    /** @test */
    public function it_needs_a_category()
    {
        $this->expectException(QueryException::class);
        create(Product::class, ['category_id' => null]);
    }

    /** @test */
    public function it_needs_an_existing_category()
    {
        $this->expectException(QueryException::class);
        create(Product::class, ['category_id' => 9]);
    }

    /** @test */
    public function it_needs_an_existing_product_level_but_it_is_not_required()
    {
        create(Product::class, ['product_level_id' => null]);

        $this->assertCount(1, Product::all());
    }

    /** @test */
    public function it_cannot_create_a_product_with_a_game_level_that_does_not_exist()
    {
        $this->expectException(QueryException::class);
        create(Product::class, ['product_level_id' => 9]);
    }

    /** @test */
    public function two_products_cannot_have_the_same_dkt_id()
    {
        $this->expectException(QueryException::class);

        create(Product::class, ['dkt_id' => 1]);
        create(Product::class, ['dkt_id' => 1]);
    }

    /** @test */
    public function two_products_cannot_have_the_same_name()
    {
        $this->expectException(QueryException::class);

        create(Product::class, ['name' => 'Foo']);
        create(Product::class, ['name' => 'Foo']);
    }

    /** @test */
    public function product_name_is_required()
    {
        $this->expectException(QueryException::class);

        create(Product::class, ['name' => null]);
    }

    /** @test */
    public function product_description_is_required()
    {
        $this->expectException(QueryException::class);

        create(Product::class, ['description' => null]);
    }

    /** @test */
    public function product_source_url_is_unique()
    {
        $this->expectException(QueryException::class);

        create(Product::class, ['source' => 'http://foo.test']);
        create(Product::class, ['source' => 'http://foo.test']);
    }
}
