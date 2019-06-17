<?php
/**
 * Created by Jonathan Hosea
 */

namespace App\Datamodels;

use Illuminate\Support\Collection;

abstract class Serializable
{
    /**
     * convert object to key value array
     * @return Collection object attr serialized
     */
    public function toArray() : Collection
    {
        $array = new Collection();
        foreach($this as $key => $value) {
            $array[$key] = $value;
        }
        return $array;
    }

    /**
     * Get the object attributes
     * @return Collection
     */
    public function getAttributes() : Collection {
        $array = new Collection();
        foreach($this as $key => $value) {
            $array->add($key);
        }
        return $array;
    }
}