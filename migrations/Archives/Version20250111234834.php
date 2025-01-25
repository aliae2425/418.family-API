<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250111234834 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_family (user_id INT NOT NULL, family_id INT NOT NULL, INDEX IDX_C0B43A66A76ED395 (user_id), INDEX IDX_C0B43A66C35E566A (family_id), PRIMARY KEY(user_id, family_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_family ADD CONSTRAINT FK_C0B43A66A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_family ADD CONSTRAINT FK_C0B43A66C35E566A FOREIGN KEY (family_id) REFERENCES family (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE business DROP INDEX IDX_8D36E387E3C61F9, ADD UNIQUE INDEX UNIQ_8D36E387E3C61F9 (owner_id)');
        $this->addSql('ALTER TABLE family ADD _created_by_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE family ADD CONSTRAINT FK_A5E6215B1F6AC3A8 FOREIGN KEY (_created_by_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_A5E6215B1F6AC3A8 ON family (_created_by_id)');
        $this->addSql('ALTER TABLE user ADD related_business_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6496376CAD3 FOREIGN KEY (related_business_id) REFERENCES business (id)');
        $this->addSql('CREATE INDEX IDX_8D93D6496376CAD3 ON user (related_business_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_family DROP FOREIGN KEY FK_C0B43A66A76ED395');
        $this->addSql('ALTER TABLE user_family DROP FOREIGN KEY FK_C0B43A66C35E566A');
        $this->addSql('DROP TABLE user_family');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6496376CAD3');
        $this->addSql('DROP INDEX IDX_8D93D6496376CAD3 ON user');
        $this->addSql('ALTER TABLE user DROP related_business_id');
        $this->addSql('ALTER TABLE family DROP FOREIGN KEY FK_A5E6215B1F6AC3A8');
        $this->addSql('DROP INDEX IDX_A5E6215B1F6AC3A8 ON family');
        $this->addSql('ALTER TABLE family DROP _created_by_id');
        $this->addSql('ALTER TABLE business DROP INDEX UNIQ_8D36E387E3C61F9, ADD INDEX IDX_8D36E387E3C61F9 (owner_id)');
    }
}
