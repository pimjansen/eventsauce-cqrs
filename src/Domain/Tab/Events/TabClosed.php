<?php

declare(strict_types=1);

namespace App\Domain\Tab\Events;

use App\Domain\Tab\TabId;
use EventSauce\EventSourcing\Serialization\SerializablePayload;
use Ramsey\Uuid\UuidInterface;

final class TabClosed implements SerializablePayload
{
    public function __construct(
        private TabId $tabId,
        private int $amountPaid,
        private int $tabTotalValue,
        private int $tip
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

    public function tabTotalValue(): int
    {
        return $this->tabTotalValue;
    }

    public function tip(): int
    {
        return $this->tip;
    }

    public static function fromPayload(array $payload): static
    {
        return new static(
            TabId::fromString($payload['tabId']),
            (int)$payload['amountPaid'],
            (int)$payload['tabTotalValue'],
            (int)$payload['tip']
        );
    }

    public function toPayload(): array
    {
        return [
            'tabId' => $this->tabId->toString(),
            'amountPaid' => (int)$this->amountPaid,
            'tabTotalValue' => (int)$this->tabTotalValue,
            'tip' => (int)$this->tip,
        ];
    }

    /**
     * @codeCoverageIgnore
     */
    public function withAmountPaid(int $amountPaid): TabClosed
    {
        $clone = clone $this;
        $clone->amountPaid = $amountPaid;

        return $clone;
    }

    /**
     * @codeCoverageIgnore
     */
    public function withTabTotalValue(int $tabTotalValue): TabClosed
    {
        $clone = clone $this;
        $clone->tabTotalValue = $tabTotalValue;

        return $clone;
    }

    /**
     * @codeCoverageIgnore
     */
    public function withTip(int $tip): TabClosed
    {
        $clone = clone $this;
        $clone->tip = $tip;

        return $clone;
    }

    /**
     * @codeCoverageIgnore
     */
    public static function withTabId(TabId $tabId): TabClosed
    {
        return new TabClosed(
            $tabId,
            (int)1011,
            (int)1011,
            (int)1011
        );
    }
}