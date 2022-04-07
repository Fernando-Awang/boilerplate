<?php

namespace Database\Seeders;

use App\Models\CompanyInfo;
use Illuminate\Database\Seeder;

class InstansiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CompanyInfo::create([
            'name' => 'Instansi ABC',
            'office_address' => 'Jalan ABC',
            'phone' => '08812345678',
            'email' => 'company@mail.com',
            'about' => 'Desc of company',
        ]);
    }
}
