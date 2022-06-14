<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user1 = new User();

        $user1->name = 'pippo';
        $user1->email = 'pippo@pippo.it';
        $user1->password = bcrypt('pippopippo');

        $user1->save();

        $user2 = new User();

        $user2->name = 'pluto';
        $user2->email = 'pluto@pluto.it';
        $user2->password = bcrypt('pippopippo');

        $user2->save();

        $user3 = new User();

        $user3->name = 'admin';
        $user3->email = 'andrea.pontillo@libero.it';
        $user3->password = bcrypt('adminadmin');

        $user3->save();

        $user4 = new User();

        $user4->name = 'paperino';
        $user4->email = 'paperino@paperino.it';
        $user4->password = bcrypt('paperinopaperino');
    }
}
