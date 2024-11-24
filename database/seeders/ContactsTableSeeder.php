<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use App\Models\Contact;

class ContactsTableSeeder extends Seeder
{
    public function run()
    {
        Contact::factory()->count(10)->create(); // Create 10 test records
    }
}
