<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240703084054 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book DROP active');
        $this->addSql('ALTER TABLE commentaries CHANGE active enable TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE users DROP active');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book ADD active TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE commentaries CHANGE enable active TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE users ADD active TINYINT(1) NOT NULL');
    }
}
