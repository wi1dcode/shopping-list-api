<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'shopping_list_id',
    ];

    public function shoppingList()
    {
        return $this->belongsTo(ShoppingList::class);
    }
}