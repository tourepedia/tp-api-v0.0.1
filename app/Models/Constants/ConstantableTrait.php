<?php

namespace App\Models\Constants;

trait ConstantableTrait
{

    public function morphToManyContant($parentClass)
    {
        return $this->morphToMany($parentClass, "constantable", "constantables", null, "constant_id");
    }

    public function morphedByManyContant($parentClass)
    {
        return $this->morphedByMany($parentClass, "constantable", "constantables", "constantable_id", "constant_id");
    }
}
