<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240701144238 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE book_categories (book_id INT NOT NULL, categories_id INT NOT NULL, INDEX IDX_A55E0CDB16A2B381 (book_id), INDEX IDX_A55E0CDBA21214B7 (categories_id), PRIMARY KEY(book_id, categories_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categories (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE book_categories ADD CONSTRAINT FK_A55E0CDB16A2B381 FOREIGN KEY (book_id) REFERENCES book (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE book_categories ADD CONSTRAINT FK_A55E0CDBA21214B7 FOREIGN KEY (categories_id) REFERENCES categories (id) ON DELETE CASCADE');
        $this->addSql('DROP INDEX IDX_4ED55CCB7C5EAD31 ON commentaries');
        $this->addSql('ALTER TABLE commentaries ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', DROP reports_id');
        $this->addSql('DROP INDEX IDX_1483A5E97C5EAD31 ON users');
        $this->addSql('DROP INDEX IDX_1483A5E984DDC6B4 ON users');
        $this->addSql('ALTER TABLE users DROP favorites_id, DROP reports_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book_categories DROP FOREIGN KEY FK_A55E0CDB16A2B381');
        $this->addSql('ALTER TABLE book_categories DROP FOREIGN KEY FK_A55E0CDBA21214B7');
        $this->addSql('DROP TABLE book_categories');
        $this->addSql('DROP TABLE categories');
        $this->addSql('ALTER TABLE commentaries ADD reports_id INT DEFAULT NULL, DROP created_at');
        $this->addSql('CREATE INDEX IDX_4ED55CCB7C5EAD31 ON commentaries (reports_id)');
        $this->addSql('ALTER TABLE users ADD favorites_id INT DEFAULT NULL, ADD reports_id INT DEFAULT NULL');
        $this->addSql('CREATE INDEX IDX_1483A5E97C5EAD31 ON users (reports_id)');
        $this->addSql('CREATE INDEX IDX_1483A5E984DDC6B4 ON users (favorites_id)');
    }
}
