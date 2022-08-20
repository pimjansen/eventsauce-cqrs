<?php

declare(strict_types=1);

namespace App\Infra\Write;

use App\Domain\Tab\Tab;
use App\Domain\Tab\TabRepository;
use App\Infra\Read\TabProjection;
use Doctrine\DBAL\Connection;
use EventSauce\EventSourcing\EventSourcedAggregateRootRepository;
use EventSauce\EventSourcing\Serialization\ConstructingMessageSerializer;
use EventSauce\EventSourcing\SynchronousMessageDispatcher;
use EventSauce\MessageRepository\DoctrineMessageRepository\DoctrineUuidV4MessageRepository;

class TabRepositoryFactory
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function create(): TabRepository
    {
        return new TabRepositoryEventSauce(
            new EventSourcedAggregateRootRepository(
                Tab::class,
                new DoctrineUuidV4MessageRepository(
                    $this->connection,
                    'eventstore_tab',
                    new ConstructingMessageSerializer()
                ),
                new SynchronousMessageDispatcher(
                    new TabProjection($this->connection),
                )
            )
        );
    }
}
