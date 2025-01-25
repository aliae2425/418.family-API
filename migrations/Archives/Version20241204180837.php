<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241204180837 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE brands_brand_category (brands_id INT NOT NULL, brand_category_id INT NOT NULL, INDEX IDX_BDF8E244E9EEC0C7 (brands_id), INDEX IDX_BDF8E2447317BD17 (brand_category_id), PRIMARY KEY(brands_id, brand_category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE brands_brand_category ADD CONSTRAINT FK_BDF8E244E9EEC0C7 FOREIGN KEY (brands_id) REFERENCES brands (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE brands_brand_category ADD CONSTRAINT FK_BDF8E2447317BD17 FOREIGN KEY (brand_category_id) REFERENCES brand_category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE brands DROP FOREIGN KEY FK_7EA24434A21214B7');
        $this->addSql('DROP INDEX IDX_7EA24434A21214B7 ON brands');
        $this->addSql('ALTER TABLE brands DROP categories_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE brands_brand_category DROP FOREIGN KEY FK_BDF8E244E9EEC0C7');
        $this->addSql('ALTER TABLE brands_brand_category DROP FOREIGN KEY FK_BDF8E2447317BD17');
        $this->addSql('DROP TABLE brands_brand_category');
        $this->addSql('ALTER TABLE brands ADD categories_id INT NOT NULL');
        $this->addSql('ALTER TABLE brands ADD CONSTRAINT FK_7EA24434A21214B7 FOREIGN KEY (categories_id) REFERENCES brand_category (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_7EA24434A21214B7 ON brands (categories_id)');
    }
}
