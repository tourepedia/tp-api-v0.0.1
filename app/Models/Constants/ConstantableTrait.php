<?php

namespace App\Models\Constants;

trait ConstantableTrait
{

    public function morphToManyTag($parentClass)
    {
        return $this->morphToMany($parentClass, "constantable", "constantables", null, "constant_id");
    }
}
