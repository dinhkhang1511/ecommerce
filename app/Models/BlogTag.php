<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogTag extends Model
{
    protected $table = 'blog_tag';

    public static function relatedBlogIds($blog)
    {
        return BlogTag::whereIn('tag_id', $blog->tags->modelKeys())
            ->where('blog_id', '!=', $blog->id)
            ->orderBy('id', 'desc')
            ->limit(2)
            ->pluck('blog_id')
            ->unique();
    }
}
