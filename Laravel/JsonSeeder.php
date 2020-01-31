<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class AbcSeeder extends Seeder
{
    public function run()
    {
        $data = json_decode(Storage::disk('seeds')->get('abc.json')); // storage/seeds/abc.json
        $abcs = [];
        foreach ($data as $value) {
            $abcs[] = ['key' => $value, 'created_at' => now(), 'updated_at' => now()];
        }
        App\Models\Abc::insert($abcs);
    }
}


