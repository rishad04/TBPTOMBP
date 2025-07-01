<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use App\Traits\MyActivityLogTrait;

class AdminMenu extends Model
{

    use MyActivityLogTrait;

    protected $table='admin_menus';

    protected $guarded=[];
    //Activity Log start here






}
