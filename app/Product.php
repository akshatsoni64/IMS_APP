<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];
    public $timestamps = false;

    // public function getTableColumns(){
    //     return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    // }
}
