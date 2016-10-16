<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
    public function toArray()
    {
        $parent_array = parent::toArray();
        $array = ['uid'        => $parent_array['id'],
                'created_at' => $parent_array['created_at'],
                'url'        => $parent_array['url']
                ];
        if (array_key_exists('comments', $parent_array))
            $array['comments'] = $parent_array['comments'];
        return $array;
    }

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }
}
