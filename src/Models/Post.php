<?php

namespace Xiso\InertiaBlog\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Lecturize\Taxonomies\Traits\HasCategories;
use Lecturize\Taxonomies\Contracts\CanHaveCategories;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class Post extends Model implements CanHaveCategories, HasMedia
{
    use InteractsWithMedia;
    use HasTranslations;
    use HasFactory;
    use Sluggable;
    use HasCategories;

    public array $translatable = ['title','description','content','data'];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}
