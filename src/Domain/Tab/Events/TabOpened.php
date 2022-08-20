<?php

declare(strict_types=1);

namespace App\Domain\Tab\Events;

use App\Domain\Tab\TabId;
use EventSauce\EventSourcing\Serialization\SerializablePayload;

final class TabOpened implements SerializablePayload
{
    public function __construct(
        private TabId $tabId,
        private string $table,
        private string $waiter,
    ) {
    }

    public function tabId(): TabId
    {
        return $this->tabId;
    }

    public function table(): string
    {
        return $this->table;
    }

    public function waiter(): string
    {
        return $this->waiter;
    }

    public static function fromPayload(array $payload): static
    {
        return new static(
            TabId::fromString($payload['tabId']),
            (string) $payload['table'],
            (string) $payload['waiter']
        );
    }

    public function toPayload(): array
    {
        return [
            'tabId' => $this->tabId->toString(),
            'table' => (string) $this->table,
            'waiter' => (string) $this->waiter,
        ];
    }

    /**
     * @codeCoverageIgnore
     */
    public function withTable(string $table): TabOpened
    {
        $clone = clone $this;
        $clone->table = $table;

        return $clone;
    }

    /**
     * @codeCoverageIgnore
     */
    public function withWaiter(string $waiter): TabOpened
    {
        $clone = clone $this;
        $clone->waiter = $waiter;

        return $clone;
    }

    /**
     * @codeCoverageIgnore
     */
    public static function withTabId(TabId $tabId): TabOpened
    {
        return new TabOpened(
            $tabId,
            (string) '223-423-423-42',
            (string) 'John Doe',
        );
    }
}
