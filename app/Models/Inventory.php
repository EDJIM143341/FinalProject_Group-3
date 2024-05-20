<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'weapon_id', 'quantity', 'condition', 'price'
    ];
    protected $primaryKey = 'inventory_id';

    public function weapon()
    {
        return $this->belongsTo(Weapon::class);
    }
}

