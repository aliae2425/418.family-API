<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241207225510 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE family_category (id INT AUTO_INCREMENT NOT NULL, parents_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, _created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', _updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', slug VARCHAR(255) NOT NULL, INDEX IDX_C4F6F2B2B706B6D3 (parents_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE family_category ADD CONSTRAINT FK_C4F6F2B2B706B6D3 FOREIGN KEY (parents_id) REFERENCES family_category (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE family_category DROP FOREIGN KEY FK_C4F6F2B2B706B6D3');
        $this->addSql('DROP TABLE family_category');
    }
}
