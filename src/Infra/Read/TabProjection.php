<?php

declare(strict_types=1);

namespace App\Infra\Read;

use App\Domain\Tab\Events\TabClosed;
use App\Domain\Tab\Events\TabOpened;
use EventSauce\EventSourcing\Consumer;
use Doctrine\DBAL\Connection;
use EventSauce\EventSourcing\Message;

class TabProjection implements Consumer
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function handle(Message $message): void
    {
        $payload = $message->payload();

        if ($payload instanceof TabOpened) {
            $this->connection->insert('read_model_tab', [
                'tab_id' => $payload->tabId()->toString(),
                'table_number' => (string) $payload->table(),
                'waiter' => (string) $payload->waiter(),
            ]);
        }

        if ($payload instanceof TabClosed) {
            $sql = 'delete from read_model_tab where tab_id = :tab_id';
            $this->connection->executeQuery($sql, ['tab_id' => $payload->tabId()->toString()]);
        }
    }
}
