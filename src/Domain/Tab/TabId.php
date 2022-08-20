<?php

declare(strict_types=1);

namespace App\Domain\Tab;

use EventSauce\EventSourcing\AggregateRootId;
use Ramsey\Uuid\Uuid;

class TabId implements AggregateRootId
{
    private function __construct(private string $id)
    {}

    public function toString(): string
    {
        return $this->id;
    }

    public static function generate(): AggregateRootId
    {
        return new static(Uuid::uuid4()->toString());
    }

    public static function fromString(string $aggregateRootId): static
    {
        return new static($aggregateRootId);
    }


}