<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Contact;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Faker\Factory as Faker;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $companies = Company::all();
        $faker = Faker::create();
        $contacts = [];

        foreach ($companies as $company) {
            foreach (range(1, mt_rand(5, 15)) as $index) {
                $contact = [
                    'first_name' => $faker->firstName(),
                    'last_name' => $faker->lastName(),
                    'phone' => $faker->phoneNumber(),
                    'email' => $faker->email(),
                    'address' => $faker->address(),
                    'company_id' => $company->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                $contacts[] = $contact;
            }
        }
        Contact::insert($contacts);
    }
}
