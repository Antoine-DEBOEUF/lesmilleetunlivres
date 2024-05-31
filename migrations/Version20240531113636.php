<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240531113636 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE author (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, first_name VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ban_list (id INT AUTO_INCREMENT NOT NULL, id_user_id INT DEFAULT NULL, end_date DATE DEFAULT NULL, INDEX IDX_371C2ECA79F37AE5 (id_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE book (id INT AUTO_INCREMENT NOT NULL, book_categories_id INT DEFAULT NULL, favorites_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, isbn INT NOT NULL, publishing_date INT NOT NULL, synopsis LONGTEXT DEFAULT NULL, active TINYINT(1) NOT NULL, INDEX IDX_CBE5A331C7FB2CBB (book_categories_id), INDEX IDX_CBE5A33184DDC6B4 (favorites_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE book_categories (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categories (id INT AUTO_INCREMENT NOT NULL, book_categories_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, INDEX IDX_3AF34668C7FB2CBB (book_categories_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commentaries (id INT AUTO_INCREMENT NOT NULL, id_user_id INT NOT NULL, id_livre_id INT NOT NULL, reports_id INT DEFAULT NULL, content LONGTEXT NOT NULL, active TINYINT(1) NOT NULL, INDEX IDX_4ED55CCB79F37AE5 (id_user_id), INDEX IDX_4ED55CCB6702C95E (id_livre_id), INDEX IDX_4ED55CCB7C5EAD31 (reports_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE favorites (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE publisher (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reports (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, favorites_id INT DEFAULT NULL, reports_id INT DEFAULT NULL, username VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, role JSON NOT NULL, active TINYINT(1) NOT NULL, INDEX IDX_1483A5E984DDC6B4 (favorites_id), INDEX IDX_1483A5E97C5EAD31 (reports_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ban_list ADD CONSTRAINT FK_371C2ECA79F37AE5 FOREIGN KEY (id_user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A331C7FB2CBB FOREIGN KEY (book_categories_id) REFERENCES book_categories (id)');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A33184DDC6B4 FOREIGN KEY (favorites_id) REFERENCES favorites (id)');
        $this->addSql('ALTER TABLE categories ADD CONSTRAINT FK_3AF34668C7FB2CBB FOREIGN KEY (book_categories_id) REFERENCES book_categories (id)');
        $this->addSql('ALTER TABLE commentaries ADD CONSTRAINT FK_4ED55CCB79F37AE5 FOREIGN KEY (id_user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE commentaries ADD CONSTRAINT FK_4ED55CCB6702C95E FOREIGN KEY (id_livre_id) REFERENCES book (id)');
        $this->addSql('ALTER TABLE commentaries ADD CONSTRAINT FK_4ED55CCB7C5EAD31 FOREIGN KEY (reports_id) REFERENCES reports (id)');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E984DDC6B4 FOREIGN KEY (favorites_id) REFERENCES favorites (id)');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E97C5EAD31 FOREIGN KEY (reports_id) REFERENCES reports (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ban_list DROP FOREIGN KEY FK_371C2ECA79F37AE5');
        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A331C7FB2CBB');
        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A33184DDC6B4');
        $this->addSql('ALTER TABLE categories DROP FOREIGN KEY FK_3AF34668C7FB2CBB');
        $this->addSql('ALTER TABLE commentaries DROP FOREIGN KEY FK_4ED55CCB79F37AE5');
        $this->addSql('ALTER TABLE commentaries DROP FOREIGN KEY FK_4ED55CCB6702C95E');
        $this->addSql('ALTER TABLE commentaries DROP FOREIGN KEY FK_4ED55CCB7C5EAD31');
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E984DDC6B4');
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E97C5EAD31');
        $this->addSql('DROP TABLE author');
        $this->addSql('DROP TABLE ban_list');
        $this->addSql('DROP TABLE book');
        $this->addSql('DROP TABLE book_categories');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE commentaries');
        $this->addSql('DROP TABLE favorites');
        $this->addSql('DROP TABLE publisher');
        $this->addSql('DROP TABLE reports');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
