<?php

use Illuminate\Database\Seeder;

class MeasurementsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rfq_measurements')->insert([
        	[
                'unit_name'        => 'Milligram',
            ],
        	[
                'unit_name'        => 'Meters',
            ],
        	[
                'unit_name'        => 'Inches',
            ],
        	[
                'unit_name'        => 'Kilogram',
            ],
        	[
                'unit_name'        => 'Gram',
            ],
        	[
                'unit_name'        => 'Ounce',
            ],
        	[
                'unit_name'        => 'Pieces',
            ],
        	[
                'unit_name'        => 'Each',
            ],
        	[
                'unit_name'        => 'Rolls',
            ],
        	[
                'unit_name'        => 'Set',
            ],
        ]);
    }
}
