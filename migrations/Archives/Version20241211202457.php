<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241211202457 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE family (id INT AUTO_INCREMENT NOT NULL, family_category_id INT NOT NULL, brand_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, _created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', _updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', thumbnail VARCHAR(255) DEFAULT NULL, revit_family VARCHAR(255) NOT NULL, INDEX IDX_A5E6215BD2CF3B9C (family_category_id), INDEX IDX_A5E6215B44F5D008 (brand_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE family ADD CONSTRAINT FK_A5E6215BD2CF3B9C FOREIGN KEY (family_category_id) REFERENCES family_category (id)');
        $this->addSql('ALTER TABLE family ADD CONSTRAINT FK_A5E6215B44F5D008 FOREIGN KEY (brand_id) REFERENCES brands (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE family DROP FOREIGN KEY FK_A5E6215BD2CF3B9C');
        $this->addSql('ALTER TABLE family DROP FOREIGN KEY FK_A5E6215B44F5D008');
        $this->addSql('DROP TABLE family');
    }
}
