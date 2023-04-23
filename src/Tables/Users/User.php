<?php

namespace App\Tables\Users;

use App\Tables\Row;
use App\Traits\Authenticable;

class User extends Row
{
    use Authenticable;
}