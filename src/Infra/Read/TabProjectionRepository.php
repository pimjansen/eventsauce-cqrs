<?php

declare(strict_types=1);

namespace App\Infra\Read;

use Doctrine\DBAL\Connection;

class TabProjectionRepository
{
    public function __construct(private Connection $connection)
    {}

    public function openTabs(): array
    {
        $sql = 'select * from read_model_tab order by table_number asc';
        return $this->connection->fetchAllAssociative($sql);
    }
}