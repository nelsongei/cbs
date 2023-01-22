<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;
    public function category()
    {
        return $this->belongsTo(AssetCategory::class,'asset_category_id');
    }
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
    public function purchase()
    {
        return $this->hasOne(AssetPurchase::class);
    }
}
