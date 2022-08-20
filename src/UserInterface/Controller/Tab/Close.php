<?php

declare(strict_types=1);

namespace App\UserInterface\Controller\Tab;

use App\Application\Write\CloseTab;
use App\Application\Write\OpenTab;
use App\Domain\Tab\TabId;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/tab/close/{id}', name: 'tab:close', methods: ['GET'])]
class Close extends AbstractController
{
    public function __invoke(string $id, MessageBusInterface $bus, Request $request): Response
    {
        $bus->dispatch(new CloseTab(
            TabId::fromString($id),
            10
        ));
        
        return $this->redirectToRoute('tab:index');
    }
}
