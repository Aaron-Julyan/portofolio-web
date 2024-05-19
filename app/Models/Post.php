<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Post extends Model
{
    use HasFactory, Sluggable;

    protected $guarded = ['id'];

    // protected function categories(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn($value) => json_decode($value, true),
    //         set: fn($value) => json_encode($value),
    //     );
    // }

    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function file()
    {
        return $this->hasMany(File::class);
    }

    public function contributor()
    {
        return $this->hasMany(Contributor::class);
    }

    public function keyword()
    {
        return $this->hasMany(Keyword::class);
    }

    public function comment()
    {
        return $this->hasMany(Comment::class);
    }


    // public function checkSlug(Request $request){

    // }
}
