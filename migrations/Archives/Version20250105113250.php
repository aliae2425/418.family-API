<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250105113250 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE family_collection_family DROP FOREIGN KEY FK_9872B0DBC35E566A');
        $this->addSql('ALTER TABLE family_collection_family DROP FOREIGN KEY FK_9872B0DBDF40C4D1');
        $this->addSql('DROP TABLE family_collection_family');
        $this->addSql('ALTER TABLE family_collection ADD family_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE family_collection ADD CONSTRAINT FK_CF87B64DC35E566A FOREIGN KEY (family_id) REFERENCES family (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CF87B64DC35E566A ON family_collection (family_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE family_collection_family (family_collection_id INT NOT NULL, family_id INT NOT NULL, INDEX IDX_9872B0DBDF40C4D1 (family_collection_id), INDEX IDX_9872B0DBC35E566A (family_id), PRIMARY KEY(family_collection_id, family_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE family_collection_family ADD CONSTRAINT FK_9872B0DBC35E566A FOREIGN KEY (family_id) REFERENCES family (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE family_collection_family ADD CONSTRAINT FK_9872B0DBDF40C4D1 FOREIGN KEY (family_collection_id) REFERENCES family_collection (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE family_collection DROP FOREIGN KEY FK_CF87B64DC35E566A');
        $this->addSql('DROP INDEX UNIQ_CF87B64DC35E566A ON family_collection');
        $this->addSql('ALTER TABLE family_collection DROP family_id');
    }
}
