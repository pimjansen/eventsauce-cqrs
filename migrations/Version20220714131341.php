<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220714131341 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE TABLE IF NOT EXISTS eventstore_tab (
              `event_id` BINARY(16) NOT NULL,
              `aggregate_root_id` BINARY(16) NOT NULL,
              `version` int(20) unsigned NULL,
              `payload` varchar(16001) NOT NULL,
              PRIMARY KEY (`event_id`),
              KEY (`aggregate_root_id`),
              KEY `reconstitution` (`aggregate_root_id`, `version` ASC)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci ENGINE=InnoDB;
        ');

        //Tab Read Model
        $this->addSql('
            create table read_model_tab (
                tab_id varchar(36) not null,
                table_number varchar(255) not null,
                waiter text not null
            );
        ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE eventstore_tab');
        $this->addSql('DROP TABLE read_model_tab');
    }
}
