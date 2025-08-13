<?php
namespace App\Core\Collections;

abstract class AbstractCollection
{
    protected array $items = [];

    public function add($item): void
    {
        $this->items[] = $item;
    }
    public function all(): array{
        return $this->items;
    }
    public function toArray(): array
    {
        return array_map(fn($item) => $this->mapItemToArray($item), $this->items);
    }
    abstract protected function mapItemToArray($item): array;
}
