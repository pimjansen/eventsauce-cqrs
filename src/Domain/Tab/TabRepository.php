<?php

declare(strict_types=1);

namespace App\Domain\Tab;

interface TabRepository
{
    public function save(Tab $tab): void;

    public function get(string $tabId): Tab;
}
