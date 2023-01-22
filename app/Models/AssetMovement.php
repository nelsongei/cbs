<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetMovement extends Model
{
    use HasFactory;
    public function asset()
    {
        return $this->belongsTo(Asset::class,'asset_id');
    }
    public function department(){
        return $this->belongsTo(Department::class);
    }
}
