<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;
    protected $fillable=[
        "tags",
        "logo",
        "title",
        "email",
        "company",
        "website",
        "location",
        "description",
        "user_id",
    ];

    public function scopeFilter($query, array $filters)
    {
        if($filters["tag"] ?? false){// means if not false
            $query->where("tags", "like", "%".request("tag")."%");
        }

        if($filters["search"] ?? false){
            $query
            ->where("tags", "like", "%".request("search")."%")
            ->orWhere("title", "like", "%".request("search")."%")
            ->orWhere("description", "like", "%".request("search")."%");
        }
    }

    public function user(){
        return $this->belongsTo(User::class, "user_id");
    }
}
