<?php

namespace Database\Seeders;

use App\Models\Technology;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TechnologySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $technologies = [
            ['label' => 'HTML', 'color' => 'danger'],
            ['label' => 'CSS', 'color' => 'info'],
            ['label' => 'Javascript', 'color' => 'warning'],
            ['label' => 'Bootstrap', 'color' => 'dark'],
            ['label' => 'Vue', 'color' => 'success'],
            ['label' => 'SASS', 'color' => 'danger-emphasis'],
            ['label' => 'SQL', 'color' => 'primary'],
            ['label' => 'PHP', 'color' => 'secondary'],
        ];

        foreach($technologies as $technology){
            $new_technology= new Technology();
            $new_technology->label= $technology['label'];
            $new_technology->color= $technology['color'];

            $new_technology->save();
        }
    }
}
