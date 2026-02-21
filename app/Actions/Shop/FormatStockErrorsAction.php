<?php

namespace App\Actions\Shop;

class FormatStockErrorsAction
{
    public function execute(array $stockErrors): string
    {
        return collect($stockErrors)
            ->map(fn (array $error) => "{$error['product']}: solo hay {$error['available']} disponibles")
            ->join(', ');
    }
}
