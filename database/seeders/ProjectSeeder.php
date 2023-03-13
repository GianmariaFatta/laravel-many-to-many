<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $Faker): void
    {
        for($i=0 ; $i <5; $i++){
            $project = new Project();

            $project->title = $Faker->text(30);
            $project->description = $Faker->paragraphs(20, true);
            // $project->thumb = $Faker->imageUrl(300,300);
            $project->project_url = $Faker->url();
            $project->slug = Str::slug($project->title,'-');
            $project->save();
        }
    }
}
