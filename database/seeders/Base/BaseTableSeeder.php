<?php

namespace Database\Seeders\Base;

use Illuminate\Database\Seeder;

abstract class BaseTableSeeder extends Seeder {

    /**
     * The attributes that will be filled during the seeding process
     *
     * @var array
     */
    protected $seedColumns = [];

    /**
     * Generate a row from 
     *
     * @param array $data
     * @return void
     */
    protected function generateRow(array $data): array
    {
        return array_combine($this->seedColumns, $data);
    }

}