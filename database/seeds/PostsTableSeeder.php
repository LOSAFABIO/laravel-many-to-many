<?php

use Illuminate\Database\Seeder;

use App\Post;

use Faker\Generator as Faker;

use Illuminate\Support\Str;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i = 0; $i < 10; $i++) {
            $newPost = new Post();
            $newPost->title = $faker->words(3, true);
            $newPost->content = $faker->text();
            $newPost->post_date = $faker->dateTime();
            $newPost->author = $faker->name('male'|'female');
            $newPost->slug = Str::of($newPost->title)->slug('-');
            $newPost->save();

        }
    }
}
