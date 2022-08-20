<?php

declare(strict_types=1);

namespace App\Application\Write;
use App\Domain\Tab\Tab;
use App\Domain\Tab\TabRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class CloseTabHandler
{
    public function __construct(private TabRepository $tabRepository)
    {}

    public function __invoke(CloseTab $command)
    {
        $tab = $this->tabRepository->get($command->tabId()->toString());
        $tab->close($command->amountPaid());
        $this->tabRepository->save($tab);
    }
}