<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public function toArray()
    {
        $parent_array = parent::toArray();
        $array = ['uid'        => $parent_array['id'],
            'created_at' => $parent_array['created_at'],
            'ip'        => $parent_array['ip'],
            'text'        => $parent_array['text']
        ];
        return $array;
    }
}
