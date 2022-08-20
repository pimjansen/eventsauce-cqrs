<?php

declare(strict_types=1);

namespace App\Application\Write;
use App\Domain\Tab\Tab;
use App\Domain\Tab\TabRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class OpenTabHandler
{
    public function __construct(private TabRepository $tabRepository)
    {}

    public function __invoke(OpenTab $command)
    {
        $tab = Tab::open(
            $command->tabId(),
            $command->table(),
            $command->name(),
            $command->waiter(),
        );
        $this->tabRepository->save($tab);
    }
}