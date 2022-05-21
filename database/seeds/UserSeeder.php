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
        $accounts = collect([
            [
                'email' => 'admin@planters.com',
                'password' => bcrypt('admin'),
                'first_name' => 'Juan',
                'middle_name' => null,
                'last_name' => 'Dela Cruz',
                'contact_number' => '09123456789',
                'address_line' => '123 Sample St.',
                'barangay_id' => 41251,
                'municipality_id' => 1636,
                'province_id' => 82,
                'postal_code' => '1012'
            ]
        ]);

        if($accounts->count() > 0) {
            foreach($accounts as $account) {
                $new_user = new User;

                foreach($account as $key => $value) {
                    $new_user[$key] = $value;
                }

                $new_user->save();
            }
        }
    }
}
