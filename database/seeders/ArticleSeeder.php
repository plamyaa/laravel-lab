<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $results = json_decode(file_get_contents(public_path().'/articles.json'), true);
        foreach($results as $result) {
            $article = new Article();
            $article->fill($result);
            $article->save();
        }
    }
}
