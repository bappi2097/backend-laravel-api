<?php

namespace Database\Seeders;

use App\Models\NewsSource;
use Illuminate\Database\Seeder;

class NewsSourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $newsSources = array(
            [
                'key' => 'news_api',
                'name' => 'News API',
                'description' => 'This is a comprehensive API that allows developers to access articles from more than 70,000 news sources, including major newspapers, magazines, and 1blogs. The API provides access to articles in various languages and categories, and it supports search and filtering.'
            ],
            // [
            //     'key' => 'open_news',
            //     'name' => 'Open News',
            //     'description' => 'This API provides access to a wide range of news content from various sources, including newspapers, magazines, and blogs. It allows developers to retrieve articles based on keywords, categories, and sources.'
            // ], [
            //     'key' => 'news_cred',
            //     'name' => 'News Cred',
            //     'description' => 'The NewsCred API provides access to a wide range of news content from various sources, including newspapers, magazines, and blogs. The API allows developers to retrieve articles based on keywords, categories, and sources, as well as to search for articles by author, publication, and topic.'
            // ],
            [
                'key' => 'the_guardian',
                'name' => 'The Guardian',
                'description' => 'This API allows developers to access articles from The Guardian newspaper, one of the most respected news sources in the world. The API provides access to articles in various categories and supports search and filtering.'
            ], [
                'key' => 'new_york_times',
                'name' => 'New York Times',
                'description' => 'This API allows developers to access articles from The New York Times, one of the most respected news sources in the world. The API provides access to articles in various categories and supports search and filtering.'
            ],
            // [
            //     'key' => 'bbc_news',
            //     'name' => 'BBC News',
            //     'description' => 'This API allows developer to access news from BBC News, one of the most trusted news sources in the world. It provides access to articles in various categories and supports search and filtering.'
            // ], [
            //     'key' => 'news_api_org',
            //     'name' => 'NewsAPI.org',
            //     'description' => 'This API provide access to news articles from thousands of sources, including news publications, blogs, and magazines. It allows developers to retrieve articles based on keywords, categories, and sources.'
            // ]
        );

        foreach ($newsSources as $newsSource) {
            NewsSource::create($newsSource);
        }
    }
}
