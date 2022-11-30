<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Comment;
use Database\Seeders\ArticleSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\RoleSeeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Article::factory(10)->has(Comment::factory(3))->create();
        $this->call([
            ArticleSeeder::class,
            UserSeeder::class,
            RoleSeeder::class,
        ]);
        
    }
}