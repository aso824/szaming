<?php

namespace App\Services\User;

use App\Models\User;

class UserAjaxService
{
    /**
     * Get list of users, with search and limit ability.
     *
     * @param string|null $searchQuery
     * @param int         $limit
     *
     * @return array
     */
    public function getList(string $searchQuery = null, int $limit = 10): array
    {
        $builder = User::query();

        if ($searchQuery) {
            $builder->where('name', 'LIKE', "%{$searchQuery}%");
        }

        $users = $builder->limit($limit)->pluck('name', 'id');

        return $users->toArray();
    }
}
