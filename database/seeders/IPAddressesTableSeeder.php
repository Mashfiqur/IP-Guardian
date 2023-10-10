<?php

namespace Database\Seeders;

use App\Models\IPAddress;
use Database\Seeders\Base\BaseTableSeeder;
use Illuminate\Support\Facades\Hash;

class IPAddressesTableSeeder extends BaseTableSeeder
{
    /**
     * The attributes that will be filled during the seeding process
     *
     * @var array
     */
    protected $seedColumns = ["label", "ip", "comment"];

    /**
     * The seeding data
     *
     * @var array
     */
    protected $data = [
    	['IP Address 1', "111.11.12.123", "This is first IP Address"],
    	['IP Address 2', "131.15.142.32", "This is second IP Address"],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        foreach($this->data as $ipAddressData){
            $ipAddress = $this->generateRow($ipAddressData);
            
            IPAddress::create($ipAddress);
        }
    }

}
