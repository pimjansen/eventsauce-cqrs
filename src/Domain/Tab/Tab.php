<?php

declare(strict_types=1);

namespace App\Domain\Tab;

use App\Domain\Tab\Events\TabClosed;
use App\Domain\Tab\Events\TabOpened;
use EventSauce\EventSourcing\AggregateRoot;
use EventSauce\EventSourcing\AggregateRootBehaviour;
use EventSauce\EventSourcing\AggregateRootId;

class Tab implements AggregateRoot
{
    use AggregateRootBehaviour;

    private TabId $tabId;

    private bool $open = false;

    private function __construct(
        private AggregateRootId $aggregateRootId,
    )
    {}

    public static function open(
        TabId $tabId,
        string $tableNumber,
        string $name,
        string $waiter
    ): self {
        $tab = new static($tabId);

        $tab->recordThat(new TabOpened($tabId, $tableNumber, $name, $waiter));

        return $tab;
    }

    public function close(
        int $amountPaid,
    ): self {
        if ($this->isClosed() === false) {
            throw new \Exception('Tab already closed');
        }
        //
        //if ($this->hasUnservedItems()) {
        //    throw new TabHasUnservedItems();
        //}
        //
        //if ($amountPaid < $this->servedItemsValue) {
        //    throw new MustPayEnough();
        //}
        //
        //$tipValue = $amountPaid - $this->servedItemsValue;

        $this->recordThat(
            new TabClosed(
                $this->tabId,
                $amountPaid,
                0,
                0,
            )
        );

        return $this;
    }

    public function isClosed(): bool
    {
        return $this->open;
    }

    private function applyTabOpened(TabOpened $event): void
    {
        $this->open  = true;
        $this->tabId = $event->tabId();
    }

    private function applyTabClosed(TabClosed $event): void
    {
        $this->open = false;
    }
}