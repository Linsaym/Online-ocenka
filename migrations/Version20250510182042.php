<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250510182042 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE `order` ADD created_at DATETIME');
        $this->addSql('ALTER TABLE `order` ADD status VARCHAR(20)');

        // Если хотите установить значения по умолчанию
        $this->addSql("UPDATE `order` SET created_at = NOW(), status = 'new'");
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE `order` DROP created_at');
        $this->addSql('ALTER TABLE `order` DROP status');
    }
}
