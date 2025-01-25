<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250114200410 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE registration_invitation ADD business_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE registration_invitation ADD CONSTRAINT FK_CC26A88BA89DB457 FOREIGN KEY (business_id) REFERENCES business (id)');
        $this->addSql('CREATE INDEX IDX_CC26A88BA89DB457 ON registration_invitation (business_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE registration_invitation DROP FOREIGN KEY FK_CC26A88BA89DB457');
        $this->addSql('DROP INDEX IDX_CC26A88BA89DB457 ON registration_invitation');
        $this->addSql('ALTER TABLE registration_invitation DROP business_id');
    }
}
