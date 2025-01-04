<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250104185350 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cart (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, value INT NOT NULL, _created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', _validation_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', validate TINYINT(1) NOT NULL, INDEX IDX_BA388B7A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cart_family (cart_id INT NOT NULL, family_id INT NOT NULL, INDEX IDX_AB6243041AD5CDBF (cart_id), INDEX IDX_AB624304C35E566A (family_id), PRIMARY KEY(cart_id, family_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE family_collection (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, _created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_CF87B64DA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE family_collection_family (family_collection_id INT NOT NULL, family_id INT NOT NULL, INDEX IDX_9872B0DBDF40C4D1 (family_collection_id), INDEX IDX_9872B0DBC35E566A (family_id), PRIMARY KEY(family_collection_id, family_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cart ADD CONSTRAINT FK_BA388B7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE cart_family ADD CONSTRAINT FK_AB6243041AD5CDBF FOREIGN KEY (cart_id) REFERENCES cart (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cart_family ADD CONSTRAINT FK_AB624304C35E566A FOREIGN KEY (family_id) REFERENCES family (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE family_collection ADD CONSTRAINT FK_CF87B64DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE family_collection_family ADD CONSTRAINT FK_9872B0DBDF40C4D1 FOREIGN KEY (family_collection_id) REFERENCES family_collection (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE family_collection_family ADD CONSTRAINT FK_9872B0DBC35E566A FOREIGN KEY (family_id) REFERENCES family (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cart DROP FOREIGN KEY FK_BA388B7A76ED395');
        $this->addSql('ALTER TABLE cart_family DROP FOREIGN KEY FK_AB6243041AD5CDBF');
        $this->addSql('ALTER TABLE cart_family DROP FOREIGN KEY FK_AB624304C35E566A');
        $this->addSql('ALTER TABLE family_collection DROP FOREIGN KEY FK_CF87B64DA76ED395');
        $this->addSql('ALTER TABLE family_collection_family DROP FOREIGN KEY FK_9872B0DBDF40C4D1');
        $this->addSql('ALTER TABLE family_collection_family DROP FOREIGN KEY FK_9872B0DBC35E566A');
        $this->addSql('DROP TABLE cart');
        $this->addSql('DROP TABLE cart_family');
        $this->addSql('DROP TABLE family_collection');
        $this->addSql('DROP TABLE family_collection_family');
    }
}
