<?php

declare(strict_types=1);

namespace App\Application\Write;

use App\Domain\Tab\TabId;
use EventSauce\EventSourcing\Serialization\SerializablePayload;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class CloseTab implements SerializablePayload
{
    public function __construct(
        private TabId $tabId,
        private int $amountPaid
    ) {
    }

    public function tabId(): TabId
    {
        return $this->tabId;
    }

    public function amountPaid(): int
    {
        return $this->amountPaid;
    }

    public static function fromPayload(array $payload): static
    {
        return new static(
            TabId::fromString($payload['tabId']),
            (int) $payload['amountPaid']
        );
    }

    public function toPayload(): array
    {
        return [
            'tabId' => $this->tabId->toString(),
            'amountPaid' => (int) $this->amountPaid,
        ];
    }

    /**
     * @codeCoverageIgnore
     */
    public function withAmountPaid(int $amountPaid): CloseTab
    {
        $clone = clone $this;
        $clone->amountPaid = $amountPaid;

        return $clone;
    }

    /**
     * @codeCoverageIgnore
     */
    public static function withTabId(TabId $tabId): CloseTab
    {
        return new CloseTab(
            $tabId,
            (int) 1000
        );
    }
}
