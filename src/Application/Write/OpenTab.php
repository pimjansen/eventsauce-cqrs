<?php

declare(strict_types=1);

namespace App\Application\Write;

use App\Domain\Tab\TabId;
use EventSauce\EventSourcing\Serialization\SerializablePayload;

final class OpenTab implements SerializablePayload
{
    public function __construct(
        private TabId $tabId,
        private string $table,
        private string $name,
        private string $waiter
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

    public function name(): string
    {
        return $this->name;
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
            (string) $payload['name'],
            (string) $payload['waiter']
        );
    }

    public function toPayload(): array
    {
        return [
            'tabId' => $this->tabId->toString(),
            'table' => (string) $this->table,
            'name' => (string) $this->name,
            'waiter' => (string) $this->waiter,
        ];
    }

    /**
     * @codeCoverageIgnore
     */
    public function withTable(string $table): OpenTab
    {
        $clone = clone $this;
        $clone->table = $table;

        return $clone;
    }

    /**
     * @codeCoverageIgnore
     */
    public function withName(string $name): OpenTab
    {
        $clone = clone $this;
        $clone->name = $name;

        return $clone;
    }

    /**
     * @codeCoverageIgnore
     */
    public function withWaiter(string $waiter): OpenTab
    {
        $clone = clone $this;
        $clone->waiter = $waiter;

        return $clone;
    }

    /**
     * @codeCoverageIgnore
     */
    public static function withTabId(TabId $tabId): OpenTab
    {
        return new OpenTab(
            $tabId,
            (string) '12',
            (string) 'John Doe',
            (string) 'John Doe'
        );
    }
}

