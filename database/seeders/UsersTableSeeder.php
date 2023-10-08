<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Seeders\Base\BaseTableSeeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends BaseTableSeeder
{
    /**
     * The attributes that will be filled during the seeding process
     *
     * @var array
     */
    protected $seedColumns = ["name", "email", "password"];

    /**
     * The seeding data
     *
     * @var array
     */
    protected $data = [
    	['Mashfiqur Rahman', "mashfiqurrr@gmail.com", "!sss#@%ddvfkwewi@1"],
    	['SH Sakif', "sakif@gmail.com", "!sss#@%dfkwewi@1"],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        foreach($this->data as $userData){
            $user = $this->generateRow($userData);
            
            //Hash the password
            $user['password'] = Hash::make($user['password']);

            User::create($user);
        }
    }

}
