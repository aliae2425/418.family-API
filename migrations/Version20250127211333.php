<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250127211333 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE adress (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, street VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, postal_code INT NOT NULL, country VARCHAR(255) NOT NULL, _created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', _updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_5CECC7BEA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE brand_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, _created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', _updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', icon VARCHAR(255) DEFAULT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE brands (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, thumbail VARCHAR(255) DEFAULT NULL, _created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', _updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE brands_brand_category (brands_id INT NOT NULL, brand_category_id INT NOT NULL, INDEX IDX_BDF8E244E9EEC0C7 (brands_id), INDEX IDX_BDF8E2447317BD17 (brand_category_id), PRIMARY KEY(brands_id, brand_category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cart (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, value INT NOT NULL, _created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', _validation_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', validate TINYINT(1) NOT NULL, INDEX IDX_BA388B7A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cart_family (cart_id INT NOT NULL, family_id INT NOT NULL, INDEX IDX_AB6243041AD5CDBF (cart_id), INDEX IDX_AB624304C35E566A (family_id), PRIMARY KEY(cart_id, family_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE family (id INT AUTO_INCREMENT NOT NULL, family_category_id INT NOT NULL, brand_id INT DEFAULT NULL, _created_by_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, _created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', _updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', thumbnail VARCHAR(255) DEFAULT NULL, revit_family VARCHAR(255) NOT NULL, price INT DEFAULT NULL, INDEX IDX_A5E6215BD2CF3B9C (family_category_id), INDEX IDX_A5E6215B44F5D008 (brand_id), INDEX IDX_A5E6215B1F6AC3A8 (_created_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE family_category (id INT AUTO_INCREMENT NOT NULL, parents_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, _created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', _updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', slug VARCHAR(255) NOT NULL, level INT NOT NULL, INDEX IDX_C4F6F2B2B706B6D3 (parents_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE link (id INT AUTO_INCREMENT NOT NULL, brands_id INT DEFAULT NULL, type VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, INDEX IDX_36AC99F1E9EEC0C7 (brands_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE registration_invitation (id INT AUTO_INCREMENT NOT NULL, collection_id INT DEFAULT NULL, token VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expire_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', role VARCHAR(255) NOT NULL, state TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_CC26A88B514956FD (collection_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, user_collection_id INT DEFAULT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, _created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', _last_activity DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', status TINYINT(1) NOT NULL, current_cart_count INT DEFAULT NULL, plan VARCHAR(255) DEFAULT NULL, INDEX IDX_8D93D649BFC7FBAD (user_collection_id), UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_collection (id INT AUTO_INCREMENT NOT NULL, owner_id INT NOT NULL, coins INT NOT NULL, UNIQUE INDEX UNIQ_5B2AA3DE7E3C61F9 (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_collection_family (user_collection_id INT NOT NULL, family_id INT NOT NULL, INDEX IDX_AFDC6286BFC7FBAD (user_collection_id), INDEX IDX_AFDC6286C35E566A (family_id), PRIMARY KEY(user_collection_id, family_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE adress ADD CONSTRAINT FK_5CECC7BEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE brands_brand_category ADD CONSTRAINT FK_BDF8E244E9EEC0C7 FOREIGN KEY (brands_id) REFERENCES brands (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE brands_brand_category ADD CONSTRAINT FK_BDF8E2447317BD17 FOREIGN KEY (brand_category_id) REFERENCES brand_category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cart ADD CONSTRAINT FK_BA388B7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE cart_family ADD CONSTRAINT FK_AB6243041AD5CDBF FOREIGN KEY (cart_id) REFERENCES cart (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cart_family ADD CONSTRAINT FK_AB624304C35E566A FOREIGN KEY (family_id) REFERENCES family (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE family ADD CONSTRAINT FK_A5E6215BD2CF3B9C FOREIGN KEY (family_category_id) REFERENCES family_category (id)');
        $this->addSql('ALTER TABLE family ADD CONSTRAINT FK_A5E6215B44F5D008 FOREIGN KEY (brand_id) REFERENCES brands (id)');
        $this->addSql('ALTER TABLE family ADD CONSTRAINT FK_A5E6215B1F6AC3A8 FOREIGN KEY (_created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE family_category ADD CONSTRAINT FK_C4F6F2B2B706B6D3 FOREIGN KEY (parents_id) REFERENCES family_category (id)');
        $this->addSql('ALTER TABLE link ADD CONSTRAINT FK_36AC99F1E9EEC0C7 FOREIGN KEY (brands_id) REFERENCES brands (id)');
        $this->addSql('ALTER TABLE registration_invitation ADD CONSTRAINT FK_CC26A88B514956FD FOREIGN KEY (collection_id) REFERENCES user_collection (id)');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649BFC7FBAD FOREIGN KEY (user_collection_id) REFERENCES user_collection (id)');
        $this->addSql('ALTER TABLE user_collection ADD CONSTRAINT FK_5B2AA3DE7E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_collection_family ADD CONSTRAINT FK_AFDC6286BFC7FBAD FOREIGN KEY (user_collection_id) REFERENCES user_collection (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_collection_family ADD CONSTRAINT FK_AFDC6286C35E566A FOREIGN KEY (family_id) REFERENCES family (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE adress DROP FOREIGN KEY FK_5CECC7BEA76ED395');
        $this->addSql('ALTER TABLE brands_brand_category DROP FOREIGN KEY FK_BDF8E244E9EEC0C7');
        $this->addSql('ALTER TABLE brands_brand_category DROP FOREIGN KEY FK_BDF8E2447317BD17');
        $this->addSql('ALTER TABLE cart DROP FOREIGN KEY FK_BA388B7A76ED395');
        $this->addSql('ALTER TABLE cart_family DROP FOREIGN KEY FK_AB6243041AD5CDBF');
        $this->addSql('ALTER TABLE cart_family DROP FOREIGN KEY FK_AB624304C35E566A');
        $this->addSql('ALTER TABLE family DROP FOREIGN KEY FK_A5E6215BD2CF3B9C');
        $this->addSql('ALTER TABLE family DROP FOREIGN KEY FK_A5E6215B44F5D008');
        $this->addSql('ALTER TABLE family DROP FOREIGN KEY FK_A5E6215B1F6AC3A8');
        $this->addSql('ALTER TABLE family_category DROP FOREIGN KEY FK_C4F6F2B2B706B6D3');
        $this->addSql('ALTER TABLE link DROP FOREIGN KEY FK_36AC99F1E9EEC0C7');
        $this->addSql('ALTER TABLE registration_invitation DROP FOREIGN KEY FK_CC26A88B514956FD');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649BFC7FBAD');
        $this->addSql('ALTER TABLE user_collection DROP FOREIGN KEY FK_5B2AA3DE7E3C61F9');
        $this->addSql('ALTER TABLE user_collection_family DROP FOREIGN KEY FK_AFDC6286BFC7FBAD');
        $this->addSql('ALTER TABLE user_collection_family DROP FOREIGN KEY FK_AFDC6286C35E566A');
        $this->addSql('DROP TABLE adress');
        $this->addSql('DROP TABLE brand_category');
        $this->addSql('DROP TABLE brands');
        $this->addSql('DROP TABLE brands_brand_category');
        $this->addSql('DROP TABLE cart');
        $this->addSql('DROP TABLE cart_family');
        $this->addSql('DROP TABLE family');
        $this->addSql('DROP TABLE family_category');
        $this->addSql('DROP TABLE link');
        $this->addSql('DROP TABLE registration_invitation');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_collection');
        $this->addSql('DROP TABLE user_collection_family');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
