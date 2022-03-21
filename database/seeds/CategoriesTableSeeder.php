<?php
use Illuminate\Support\Str;

use App\Category;

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = ['Musica','Cibo','Animali','Sport'];

        foreach ($categories as $category_name) {
            $new_category = new Category();
            $new_category->name = $category_name;
            $new_category->slug = Str::of($category_name)->slug('-');
            $new_category->save();
        }
    }
}
