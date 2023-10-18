<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    use Sluggable;
    use SoftDeletes;

    use \Znck\Eloquent\Traits\BelongsToThrough;

    protected $fillable = [
        'nama',
        'slug'
    ];

    public function subcategories(){
        return $this->hasMany(Subcategory::class);
    }

    public function report(){
        return $this->hasMany(CategoryReport::class);
    }

    public function scopeCari($query, $term){
        $term = "%$term%";
        $query->where('nama','like', $term);
    }

    
    public function user(){
        return $this->belongsToMany(User::class);
    }

    public function reports(){
        return $this->belongsToMany(Report::class, 'category_report', 'category_id', 'report_id');
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'nama'
            ]
        ];
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
