<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
//Activity Log
use App\Traits\MyActivityLogTrait;

class Setting extends Model
{
    use MyActivityLogTrait;
    protected $guarded = [];


}
