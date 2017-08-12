<?php 

namespace App\Repository\Transformers;

/**
 * Abstract base transformer class
 */
abstract class BaseTransformer
{
    /*
     * Transforms a collection of lessons
     * @param $lessons
     * @return array
     */
    public function transformCollection(array $items)
    {
        return array_map([$this, 'transform'], $items);
    }

    /**
     * Method each child implements to define the transformation
     * behaviour.
     *
     * @param $item stdClass
     */
    public abstract function transform($item);
}
