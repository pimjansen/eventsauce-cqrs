<?php

declare(strict_types=1);

namespace App\Infra\Write;

use App\Domain\Tab\Tab;
use App\Domain\Tab\TabId;
use App\Domain\Tab\TabRepository;
use EventSauce\EventSourcing\AggregateRootRepository;

class TabRepositoryEventSauce implements TabRepository
{
    private AggregateRootRepository $repository;

    public function __construct(AggregateRootRepository $repository)
    {
        $this->repository = $repository;
    }

    public function save(Tab $tab): void
    {
        $this->repository->persist($tab);
    }

    public function get(string $tabId): Tab
    {
        return $this->repository->retrieve(TabId::fromString($tabId));
    }
}
