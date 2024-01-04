<?php

use Illuminate\Database\Seeder;

class IndustriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('industries')->insert([
        	[
                'industry_name' => 'Accounting',
            ],
        	[
                'industry_name' => 'Administration',
            ],
        	[
                'industry_name' => 'Agriculture',
            ],
        	[
                'industry_name' => 'Arts and Entertainment',
            ],
        	[
                'industry_name' => 'Banking and Finance',
            ],
        	[
                'industry_name' => 'Construction',
            ],
        	[
                'industry_name' => 'Consulting',
            ],
        	[
                'industry_name' => 'Customer Services',
            ],
        	[
                'industry_name' => 'Education',
            ],
        	[
                'industry_name' => 'Energy',
            ],
        	[
                'industry_name' => 'Engineering',
            ],
        	[
                'industry_name' => 'Government',
            ],
        	[
                'industry_name' => 'Healthcare',
            ],
        	[
                'industry_name' => 'Hospitality',
            ],
        	[
                'industry_name' => 'Human Resource',
            ],
        	[
                'industry_name' => 'Information Technology',
            ],
        	[
                'industry_name' => 'Insurance',
            ],
        	[
                'industry_name' => 'Legal',
            ],
        	[
                'industry_name' => 'Manufacturing',
            ],
        	[
                'industry_name' => 'Marketing',
            ],
        	[
                'industry_name' => 'Non-Governmental Organization',
            ],
        	[
                'industry_name' => 'Oil and Gas',
            ],
        	[
                'industry_name' => 'Pharmaceutical',
            ],
        	[
                'industry_name' => 'Procurement and Logistics',
            ],
        	[
                'industry_name' => 'Project Management',
            ],
        	[
                'industry_name' => 'Real Estate',
            ],
        	[
                'industry_name' => 'Research',
            ],
        	[
                'industry_name' => 'Sales',
            ],
        	[
                'industry_name' => 'Telecommunication',
            ],
        	[
                'industry_name' => 'Media',
            ],
        	[
                'industry_name' => 'Others',
            ],
        ]);
    }
}
