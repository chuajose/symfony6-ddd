<?php
declare(strict_types=1);

/**
 * Created by stik_api
 * User: jose
 * Date: 20/9/21
 * Time: 11:20
 */

namespace App\Domain\Shared;


use ArrayIterator;
use Countable;
use IteratorAggregate;

 class Collection implements Countable, IteratorAggregate
{
    private array $items;
    public function __construct( array $items)
    {
        $this->items = $items;
       // Assert::arrayOf($this->type(), $items);
    }


    //abstract protected function type(): string;

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->items());
    }

    public function count(): int
    {
        return count($this->items());
    }

    protected function items(): array
    {
        return $this->items;
    }

    public function add($item): void
    {
    //    Assert::instanceOf($this->type(), $item);
        $this->items[] = $item;

    }

    public function clear():void{
        $this->items = [];
    }

    public function exists($key): bool
    {
        return $this->offsetExists($key);
    }

    public function offsetExists($key): bool
    {

        if(is_object($key)){

            if(in_array($key, $this->items, true)){
                return true;
            }else{
                return false;
            }
        }
        return isset($this->items[$key]);
    }

    /**
     * @param $key
     *
     * @return mixed
     */
    public function get($key): mixed
    {
        return $this->offsetGet($key);
    }

    public function offsetGet($key) {
        if(is_string($key) && !empty( $this->items)) {
            foreach ($this->items as $item){
                if(is_object($item) && $item->id() === $key){
                    return  $item;
                }
            }
        }
        return null;

    }


    public function remove($item): void  {

        $this->offsetUnset($item);

    }

    private function offsetUnset($key): void
    {
        $this->items = array_filter($this->items,
            static function ($v) use ($key) {
                return $v !== $key;
            });


    }
}