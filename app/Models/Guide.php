<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Guide extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'content', 'excerpt', 'category_id',
        'user_id', 'status', 'featured_image', 'views',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($guide) {
            if (empty($guide->slug)) {
                $guide->slug = Str::slug($guide->title);
            }
            if (empty($guide->excerpt) && $guide->content) {
                $guide->excerpt = Str::limit(strip_tags($guide->content), 200);
            }
        });
    }

    public function getFeaturedImageUrlAttribute(): ?string
    {
        if (empty($this->featured_image)) {
            return null;
        }

        if (Str::startsWith($this->featured_image, ['http://', 'https://', '//'])) {
            return $this->featured_image;
        }

        return asset($this->featured_image);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function purchases()
    {
        return $this->hasMany(GuidePurchase::class);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function incrementViews()
    {
        $this->increment('views');
    }
}
