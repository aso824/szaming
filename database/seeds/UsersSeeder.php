<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        $usersCount = 20;

        $users = factory(User::class, $usersCount)->create();

        /** @var \App\Models\User $user */
        foreach ($users as $user) {
            foreach (User::where('id', '!=', $user->id)->limit((int) ($usersCount / 2))->inRandomOrder()->get() as $u) {
                $user->debtors()->attach($u, [
                    'amount' => random_int(50, 500),
                ]);
            }
        }
    }
}
