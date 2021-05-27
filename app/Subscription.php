<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $chat_id
 * @property string $name
 * @property string $subscription_type
 * @property string $created_at
 * @property string $updated_at
 */
class Subscription extends Model
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
    protected $fillable = ['chat_id', 'name', 'subscription_type', 'created_at', 'updated_at'];

}
