<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//Activity Log
use App\Traits\MyActivityLogTrait;

class Todo extends Model
{
    use HasFactory,MyActivityLogTrait;
    protected $table='todos';
    protected $guarded=[];

}
