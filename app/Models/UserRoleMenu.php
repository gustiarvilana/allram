<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRoleMenu extends Model
{
    use HasFactory;

    protected $table = 'users_role_menu';
    protected $guarded = [];
}
