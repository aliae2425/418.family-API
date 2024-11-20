<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241120214137 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE fabricant (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, sous_titre VARCHAR(255) DEFAULT NULL, thumbnail VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('DROP TABLE brands');
        $this->addSql('ALTER TABLE family ADD user_id INT DEFAULT NULL, ADD company_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE family ADD CONSTRAINT FK_A5E6215BCBAAAAB3 FOREIGN KEY (fabricant_id) REFERENCES fabricant (id)');
        $this->addSql('ALTER TABLE family ADD CONSTRAINT FK_A5E6215BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE family ADD CONSTRAINT FK_A5E6215B979B1AD6 FOREIGN KEY (company_id) REFERENCES entreprise (id)');
        $this->addSql('CREATE INDEX IDX_A5E6215BA76ED395 ON family (user_id)');
        $this->addSql('CREATE INDEX IDX_A5E6215B979B1AD6 ON family (company_id)');
        $this->addSql('ALTER TABLE link ADD CONSTRAINT FK_36AC99F1CBAAAAB3 FOREIGN KEY (fabricant_id) REFERENCES fabricant (id)');
        $this->addSql('ALTER TABLE user ADD username VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE family DROP FOREIGN KEY FK_A5E6215BCBAAAAB3');
        $this->addSql('ALTER TABLE link DROP FOREIGN KEY FK_36AC99F1CBAAAAB3');
        $this->addSql('CREATE TABLE brands (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, slug VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, sous_titre VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, thumbnail VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE fabricant');
        $this->addSql('ALTER TABLE user DROP username');
        $this->addSql('ALTER TABLE family DROP FOREIGN KEY FK_A5E6215BA76ED395');
        $this->addSql('ALTER TABLE family DROP FOREIGN KEY FK_A5E6215B979B1AD6');
        $this->addSql('DROP INDEX IDX_A5E6215BA76ED395 ON family');
        $this->addSql('DROP INDEX IDX_A5E6215B979B1AD6 ON family');
        $this->addSql('ALTER TABLE family DROP user_id, DROP company_id');
    }
}
