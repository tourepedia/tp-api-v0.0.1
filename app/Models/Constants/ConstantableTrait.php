<?php

namespace App\Models\Constants;

trait ConstantableTrait
{

    public function morphToManyConstant($parentClass)
    {
        return $this->morphToMany($parentClass, "constantable", "constantables", null, "constant_id");
    }

    public function morphedByManyConstant($parentClass)
    {
        return $this->morphedByMany($parentClass, "constantable", "constantables", "constantable_id", "constant_id");
    }
}
