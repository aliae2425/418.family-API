<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250122210152 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6496376CAD3');
        $this->addSql('ALTER TABLE registration_invitation DROP FOREIGN KEY FK_CC26A88BA89DB457');
        $this->addSql('ALTER TABLE business DROP FOREIGN KEY FK_8D36E387E3C61F9');
        $this->addSql('DROP TABLE business');
        $this->addSql('ALTER TABLE brand_category ADD slug VARCHAR(255) NOT NULL');
        $this->addSql('DROP INDEX IDX_CC26A88BA89DB457 ON registration_invitation');
        $this->addSql('ALTER TABLE registration_invitation CHANGE business_id collection_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE registration_invitation ADD CONSTRAINT FK_CC26A88B514956FD FOREIGN KEY (collection_id) REFERENCES user_collection (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CC26A88B514956FD ON registration_invitation (collection_id)');
        $this->addSql('DROP INDEX IDX_8D93D6496376CAD3 ON user');
        $this->addSql('ALTER TABLE user ADD plan VARCHAR(255) DEFAULT NULL, DROP related_business_id');
        $this->addSql('ALTER TABLE user_collection ADD owner_id INT NOT NULL');
        $this->addSql('ALTER TABLE user_collection ADD CONSTRAINT FK_5B2AA3DE7E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5B2AA3DE7E3C61F9 ON user_collection (owner_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE business (id INT AUTO_INCREMENT NOT NULL, owner_id INT NOT NULL, _created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', _updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', active_status TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8D36E387E3C61F9 (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE business ADD CONSTRAINT FK_8D36E387E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE user ADD related_business_id INT DEFAULT NULL, DROP plan');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6496376CAD3 FOREIGN KEY (related_business_id) REFERENCES business (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_8D93D6496376CAD3 ON user (related_business_id)');
        $this->addSql('ALTER TABLE registration_invitation DROP FOREIGN KEY FK_CC26A88B514956FD');
        $this->addSql('DROP INDEX UNIQ_CC26A88B514956FD ON registration_invitation');
        $this->addSql('ALTER TABLE registration_invitation CHANGE collection_id business_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE registration_invitation ADD CONSTRAINT FK_CC26A88BA89DB457 FOREIGN KEY (business_id) REFERENCES business (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_CC26A88BA89DB457 ON registration_invitation (business_id)');
        $this->addSql('ALTER TABLE brand_category DROP slug');
        $this->addSql('ALTER TABLE user_collection DROP FOREIGN KEY FK_5B2AA3DE7E3C61F9');
        $this->addSql('DROP INDEX UNIQ_5B2AA3DE7E3C61F9 ON user_collection');
        $this->addSql('ALTER TABLE user_collection DROP owner_id');
    }
}
