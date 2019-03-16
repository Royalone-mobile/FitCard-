<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		DB::table('admin')->insert([
			'name'=>'Admin',
			'state'=>true,
			'password'=>'$2y$10$/AHTBRWrVFI9opLHRsgMJeX/3nRfw46Kt3ylXyN87ytUA8lIMjoby'
			]);
		DB::table('plan')->insert([
			'plan'=>'Basic',
			'price'=>15,
			'credit'=>15
			]);
		DB::table('plan')->insert([
			'plan'=>'Standard',
			'price'=>30,
			'credit'=>30
			]);
		DB::table('plan')->insert([
			'plan'=>'Premium',
			'price'=>70,
			'credit'=>70
			]);
		DB::table('plan')->insert([
			'plan'=>'Free',
			'price'=>0,
			'credit'=>0
			]);


    }
}
