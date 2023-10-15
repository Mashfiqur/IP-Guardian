<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Seeders\Base\BaseTableSeeder;

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
    	['Admin 1', "admin1@email.com", "!sss#@%ddavfkwewi@1"],
    	['Admin 2', "admin2@email.com", "!ss#@%dfkwtyssewi@1"],
    	['Admin 3', "admin3@email.com", "!sd#@%dfkwtysfewi@1"],
    	['Admin 4', "admin4@email.com", "!ss#@%fghwtyssewi@1"],
    	['Admin 5', "admin5@email.com", "!ss#@%dffgrrhhewi@1"],
    	['Admin 6', "admin6@email.com", "!ss#effvrvrhyjuji@1"],
    	['Admin 7', "admin7@email.com", "!ss#@%dfkwtxrx4cgdd"],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        foreach($this->data as $userData){
            User::create($this->generateRow($userData));
        }
    }

}
