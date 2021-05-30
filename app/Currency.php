<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $currency_code
 * @property string $name
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 */
class Currency extends Model
{
    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['currency_code', 'name', 'description', 'created_at', 'updated_at'];

}
