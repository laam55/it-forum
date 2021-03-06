<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reply extends Model
{
    use SoftDeletes;
    
    protected $dates = ['deleted_at'];
    
    protected $fillable = [
        'user_id',
        'content',
        'repliable_type',
        'repliable_id',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function repliable()
    {
        return $this->morphTo();
    }
}
