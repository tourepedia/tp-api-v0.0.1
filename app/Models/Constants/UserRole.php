<?php

namespace App\Models\Constants;

use Illuminate\Database\Eloquent\Model;
use App\Models\Constant;

class UserRole extends Constant
{

    use ConstantableTrait;

    /**
     * Attributes with some default values
     * @var array
     */
    protected $attributes = array(
        "type" => "role.user"
    );
}
