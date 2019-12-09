<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ImdbController extends Controller
{
    public function index()
    {
        $result = null;
        $search = null;
        if(request()->has('search') and request()->search){
            $search = request()->search;
        }

        if ($search) {
            $result = Cache::remember('search_' . $search, 300, function () {
                $client = new Client();
                $response = $client->request('GET', config('api.url'), [
                    'query' => [
                        'apikey' => config('api.key'),
                        's' => trim(request()->search)
                ],
                    'headers' => [
                        'Accept' => 'application/json',
                        'Content-Type' => 'application/json'
                    ],
                ]);

                    return json_decode($response->getBody());
                });
        }

        return view('imdb', ['result' => $result, 'search'=>$search]);
    }

    public function show($imdb_id)
    {
        $result = Cache::remember('show_' . $imdb_id, 300, function () use ($imdb_id) {

            $client = new Client();
            $response = $client->request('GET', config('api.url'), [
                'query' => [
                    'apikey' => config('api.key'),
                    'i' => $imdb_id,
                    'plot' => 'full'
                ],
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json'
                ],
                ]);
                
                return json_decode($response->getBody());
        });
                
        return view('imdb_show', ['movie' => (array) $result]);
    }
}
