<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
    /**
     * @property int $id
     * @property string $name
     * @property string $slug
     * @property int|null $parent_id
     *
     * @property Region $parent
     * @property Region[] $children
     *
     * @method Builder roots()
     */


{
    protected $fillable = ['name', 'slug', 'parent_id'];

    public function parent()
    {
        return $this->belongsTo(static::class, 'parent_id', 'id');
    }

    public function children()
    {
        return $this->hasMany(static::class, 'parent_id', 'id');
    }
}
