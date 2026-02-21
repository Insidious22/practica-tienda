<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class PerformanceTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        if (! Schema::hasTable('products') || ! Schema::hasTable('diccionario')) {
            $this->markTestSkipped('Performance tests require products and diccionario tables.');
        }
    }

    public function test_catalog_query_uses_limited_number_of_queries(): void
    {
        DB::flushQueryLog();
        DB::enableQueryLog();

        Product::query()
            ->onlyActive()
            ->whereNotNull('price')
            ->where('price', '>', 0)
            ->with(['category' => function ($query) {
                $query->select('id', 'name', 'slug');
            }])
            ->orderByDesc('created_at')
            ->limit(12)
            ->get();

        $queryCount = count(DB::getQueryLog());

        $this->assertLessThanOrEqual(3, $queryCount);
    }

    public function test_eager_loading_reduces_queries(): void
    {
        DB::flushQueryLog();
        DB::enableQueryLog();

        $withoutEager = Product::limit(5)->get();
        foreach ($withoutEager as $product) {
            $product->category?->name;
        }
        $withoutEagerCount = count(DB::getQueryLog());

        DB::flushQueryLog();
        $withEager = Product::with('category')->limit(5)->get();
        foreach ($withEager as $product) {
            $product->category?->name;
        }
        $withEagerCount = count(DB::getQueryLog());

        $this->assertGreaterThanOrEqual(1, $withEagerCount);
        $this->assertGreaterThan($withEagerCount, $withoutEagerCount);
    }

    public function test_cache_hit_returns_same_dataset(): void
    {
        $cacheKey = 'test.catalog.default';
        Cache::forget($cacheKey);

        $first = Cache::remember($cacheKey, 3600, function () {
            return Product::onlyActive()
                ->with('category')
                ->limit(12)
                ->get()
                ->pluck('id')
                ->all();
        });

        $second = Cache::get($cacheKey);

        $this->assertIsArray($first);
        $this->assertSame($first, $second);
    }
}
