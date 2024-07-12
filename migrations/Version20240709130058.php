<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240709130058 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commentaries (id INT AUTO_INCREMENT NOT NULL, id_user_id INT NOT NULL, id_livre_id INT NOT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', enable TINYINT(1) NOT NULL, INDEX IDX_4ED55CCB79F37AE5 (id_user_id), INDEX IDX_4ED55CCB6702C95E (id_livre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commentaries ADD CONSTRAINT FK_4ED55CCB79F37AE5 FOREIGN KEY (id_user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE commentaries ADD CONSTRAINT FK_4ED55CCB6702C95E FOREIGN KEY (id_livre_id) REFERENCES book (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaries DROP FOREIGN KEY FK_4ED55CCB79F37AE5');
        $this->addSql('ALTER TABLE commentaries DROP FOREIGN KEY FK_4ED55CCB6702C95E');
        $this->addSql('DROP TABLE commentaries');
    }
}
