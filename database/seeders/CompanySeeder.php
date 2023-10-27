<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Faker\Factory as Faker;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $companies = [];
        $faker = Faker::create();

        foreach (range(1, 10) as $index) {
            $company = [
                'name' => $faker->company(),
                'address' => $faker->address(),
                'website' => $faker->domainName(),
                'email' => $faker->email(),
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $companies[] = $company;
        }

        DB::table('companies')->delete();
        DB::table('companies')->insert($companies);
    }
}
