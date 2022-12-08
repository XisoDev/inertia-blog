<?php

namespace Xiso\InertiaBlog\Models;

use Xiso\InertiaBlog\Post;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Lecturize\Taxonomies\Models\Taxonomy as TaxonomyBase;

class Taxonomy extends TaxonomyBase
{
    public function posts(): MorphToMany
    {
        return $this->morphedByMany(Post::class, 'taxable', 'taxables')
            ->withTimestamps();
    }
}
