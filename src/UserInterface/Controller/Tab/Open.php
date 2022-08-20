<?php

declare(strict_types=1);

namespace App\UserInterface\Controller\Tab;

use App\Application\Write\OpenTab;
use App\Domain\Tab\TabId;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/tab/open', name: 'tab:open', methods: ['GET'])]
class Open extends AbstractController
{
    public function __invoke(MessageBusInterface $bus, Request $request): Response
    {
        $tableNumber = '01';
        $name = 'C. Name';
        $waiter = 'P. Jansen';

        $bus->dispatch(new OpenTab(
            TabId::generate(),
            $tableNumber,
            $name,
            $waiter,
        ));

        return $this->redirectToRoute('tab:index');
    }
}
