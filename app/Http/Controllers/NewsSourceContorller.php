<?php

namespace App\Http\Controllers;

use App\Models\NewsSource;
use App\Http\Resources\NewsSourceResource;
use App\Http\Resources\NewsSourceCollection;

class NewsSourceContorller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new NewsSourceCollection(NewsSource::all());
    }

    /**
     * Display the specified resource.
     */
    public function show(NewsSource $newsSource)
    {
        return new NewsSourceResource($newsSource);
    }
}
