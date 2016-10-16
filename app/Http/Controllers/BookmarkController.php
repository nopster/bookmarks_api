<?php

namespace App\Http\Controllers;

use App\Bookmark;
use Illuminate\Http\Request;

use App\Http\Requests;

class BookmarkController extends Controller
{
    public function index()
    {
        return Bookmark::orderBy('id', 'desc')
                        ->take(10)
                        ->get();
    }

    public function store(Request $request)
    {
        $url = $request['url'];
        if ($url=='')
            return $this->errorResponse('url not set', 403);

        $bookmark = Bookmark::where('url',$url)->first();
        if (!$bookmark){
            $bookmark = new Bookmark();
            $bookmark->url = $url;
            $bookmark->save();
        }
        return $this->successResponse(['uid' => $bookmark->id]);

    }

    public function find(Request $request)
    {
        $url = $request['url'];
        if ($url=='')
            return $this->errorResponse('url not set', 403);

        $bookmark = Bookmark::where('url',$url)->with('comments')->first();
        if (!$bookmark)
            return $this->errorResponse('bookmark not found', 404);

        return $bookmark;
    }
}
