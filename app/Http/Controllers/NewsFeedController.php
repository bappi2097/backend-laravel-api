<?php

namespace App\Http\Controllers;

use App\Models\NewsSource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class NewsFeedController extends Controller
{

    private function pagination($data, $page = 1)
    {
        $start = ($page - 1) * 10;
        return array_splice($data, $start, 10);
    }

    private function getNewsAPIData(array $fields, $page)
    {

        $param = [];

        if (isset($fields['date'])) $param['from'] = $fields['date'];
        if (isset($fields['keyword'])) $param['q'] = $fields['keyword'];
        else $param['q'] = 'all';
        if (isset($fields['sources'])) $param['sources'] = $fields['sources'];

        $response = Http::withHeaders([
            'X-Api-Key' => env('NEWS_API_KEY')
        ])->accept('application/json')->get(env('NEWS_API_URL') . 'everything', $param);

        $data = json_decode($response->getBody()->getContents(), true);

        if (isset($data['articles'])) {
            $articles = $this->pagination($data['articles'], $page);
            $newArray = [];
            foreach ($articles as $item) {
                $newObject['title'] = $item['title'];
                $newObject['author'] = $item['source']['name'];
                $newObject['description'] = $item['description'];
                $newObject['publishedAt'] = $item['publishedAt'];
                $newObject['url'] = $item['url'];
                $newArray[] = $newObject;
            }
            return $newArray;
        }
        return [];
    }

    private function getGuardianAPIData(array $fields, $page)
    {
        $param = [];

        if (isset($fields['date'])) $param['from-date'] = $fields['date'];
        if (isset($fields['keyword'])) $param['q'] = $fields['keyword'];
        $param['api-key'] = env('GUARDIAN_API_KEY');

        $response = Http::accept('application/json')->get(env('GUARDIAN_API_URL') . 'search', $param);
        $data = json_decode($response->getBody()->getContents(), true);

        if (isset($data['response']['results'])) {
            $articles = $this->pagination($data['response']['results'], $page);
            $newArray = [];
            foreach ($articles as $item) {
                $newObject['title'] = $item['webTitle'];
                $newObject['author'] = 'The Guardian';
                $newObject['url'] = $item['webUrl'];
                $newObject['publishedAt'] = $item['webPublicationDate'];
                $newArray[] = $newObject;
            }
            return $newArray;
        }
        return [];
    }


    private function getNYAPIData(array $fields, $page)
    {
        $param = [];

        if (isset($fields['date'])) $param['pub_date'] = $fields['date'];
        if (isset($fields['keyword'])) $param['q'] = $fields['keyword'];
        $param['api-key'] = env('NY_TIMES_API_KEY');

        $response = Http::accept('application/json')->get(env('NY_TIMES_API_URL'), $param);

        $data = json_decode($response->getBody()->getContents(), true);

        if (isset($data['response']['docs'])) {
            $articles = $this->pagination($data['response']['docs'], $page);
            $newArray = [];
            foreach ($articles as $item) {
                $newObject['title'] = $item['headline']['main'];
                $newObject['author'] = 'The New York Times';
                $newObject['description'] = $item['lead_paragraph'];
                $newObject['url'] = $item['web_url'];
                $newObject['publishedAt'] = $item['pub_date'];
                $newArray[] = $newObject;
            }
            return $newArray;
        }
        return $data;
    }

    private function concatArray(array $preferences, array $fields)
    {
        $newsSorces = NewsSource::whereIn('id', $preferences)->get();

        $data = [];

        $apis = [
            'news_api' => 'getNewsAPIData',
            'the_guardian' => 'getGuardianAPIData',
            'new_york_times' => 'getNYAPIData',
        ];

        $page = 1;

        if (isset($fields['page'])) {
            $page = (int)$fields['page'];
        }

        foreach ($newsSorces as $newsSource) {
            $apiData = $this->{$apis[$newsSource->key]}($fields, $page);
            $data = array_merge($data, $apiData);
        }

        return $data;
    }

    public function getNews(Request $request)
    {
        $fields = $request->all();
        $page = 1;
        if (isset($fields['page'])) {
            $page = (int)$fields['page'];
        }

        if (isset($fields['preferences'])) {
            $preferences = explode(",", $fields['preferences']);
            $data = $this->concatArray($preferences, $fields);
            return response(['data' => $data, 'total' => count($data), 'page' => $page], 200);
        }

        return response(['data' => [], 'total' => 0, 'page' => 0], 200);
    }
}
