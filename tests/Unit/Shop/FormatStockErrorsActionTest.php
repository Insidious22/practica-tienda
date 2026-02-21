<?php

namespace Tests\Unit\Shop;

use App\Actions\Shop\FormatStockErrorsAction;
use Tests\TestCase;

class FormatStockErrorsActionTest extends TestCase
{
    public function test_it_formats_stock_errors_into_readable_text(): void
    {
        $action = new FormatStockErrorsAction();

        $result = $action->execute([
            ['product' => 'Laptop Pro', 'available' => 2],
            ['product' => 'Mouse RGB', 'available' => 0],
        ]);

        $this->assertSame(
            'Laptop Pro: solo hay 2 disponibles, Mouse RGB: solo hay 0 disponibles',
            $result
        );
    }
}
