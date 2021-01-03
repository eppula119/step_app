<?php

namespace App;
use App\Step;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $fillable = ['user_id', 'step_id'];

    public function step()
    {
      return $this->belongsTo('App\Step');
    }

    public function user()
    {
      return $this->belongsTo('App\User');
    }
}
