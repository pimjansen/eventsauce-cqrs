<?php

declare(strict_types=1);

namespace App\UserInterface\Controller\Tab;

use App\Infra\Read\TabProjectionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

#[Route(
    path: '/tab',
    name: 'tab:index',
    methods: ['GET']
)]
class Index extends AbstractController
{
    public function __invoke(TabProjectionRepository $repository)
    {
        return $this->render('tab/index.html.twig', [
            'openTabs' => $repository->openTabs(),
        ]);
    }
}