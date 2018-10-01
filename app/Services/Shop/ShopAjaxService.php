<?php

namespace App\Services\Shop;

use App\Models\Shop;

class ShopAjaxService
{
    /**
     * Get list of shops, with search and limit ability.
     *
     * @param string|null $searchQuery
     * @param int         $limit
     *
     * @return array
     */
    public function getList(string $searchQuery = null, int $limit = 10): array
    {
        $builder = Shop::query();

        if ($searchQuery) {
            $builder->where('name', 'LIKE', "%{$searchQuery}%");
        }

        $shops = $builder->limit($limit)->pluck('name', 'id');

        return $shops->toArray();
    }
}
