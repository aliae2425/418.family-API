<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241203214208 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE brand_category ADD _create_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD _update_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE brands ADD _create_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD _update_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE brand_category DROP _create_at, DROP _update_at');
        $this->addSql('ALTER TABLE brands DROP _create_at, DROP _update_at');
    }
}
