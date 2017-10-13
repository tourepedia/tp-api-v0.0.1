<?php

namespace App\Models\Constants;

trait ConstantableTrait
{

    public function morphToManyContant($parentClass)
    {
        return $this->morphToMany($parentClass, "constantable", "constantables", null, "constant_id");
    }
}
