<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
//Activity Log
use App\Traits\MyActivityLogTrait;

class ModelHasRole extends Model
{
    use HasFactory,MyActivityLogTrait;

    protected $guarded = [];

}
