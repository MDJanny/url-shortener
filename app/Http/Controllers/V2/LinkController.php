<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use App\Http\Resources\V2\LinkCollection;
use App\Http\Resources\V2\LinkResource;
use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LinkController extends Controller
{
    public function index(Request $request)
    {
        $links = $request->user()->links;

        return new LinkCollection($links);
    }

    public function shorten(Request $request)
    {
        $request->validate([
            'url' => 'required|url',
        ]);

        $originalUrl = $request->input('url');
        $shortUrl = $this->generateShortUrl();
        $user = $request->user();

        // Check if the original URL has already been shortened by the user
        $link = Link::where('original_url', $originalUrl)
            ->where('user_id', $user->id)
            ->first();

        if (! $link) {
            $link = Link::create([
                'original_url' => $originalUrl,
                'short_url' => $shortUrl,
                'user_id' => $user->id,
            ]);
        }

        return new LinkResource($link);
    }

    public function redirect($shortUrl)
    {
        $link = Link::where('short_url', $shortUrl)->firstOrFail();
        $link->increment('hits');

        return redirect($link->original_url);
    }

    private function generateShortUrl()
    {
        return Str::random(6);
    }
}
