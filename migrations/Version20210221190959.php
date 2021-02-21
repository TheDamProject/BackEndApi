<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210221190959 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE location (id INT AUTO_INCREMENT NOT NULL, latitude DOUBLE PRECISION NOT NULL, longitude DOUBLE PRECISION NOT NULL, address VARCHAR(255) NOT NULL, id_google LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post (id INT AUTO_INCREMENT NOT NULL, type_id INT NOT NULL, shop_related_id INT NOT NULL, title VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, image LONGTEXT DEFAULT NULL, INDEX IDX_5A8A6C8DC54C8C93 (type_id), INDEX IDX_5A8A6C8D3B112D27 (shop_related_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post_type (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shop (id INT AUTO_INCREMENT NOT NULL, location_id INT NOT NULL, shop_category_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_AC6A4CA264D218E (location_id), INDEX IDX_AC6A4CA2C0316BF2 (shop_category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shop_category (id INT AUTO_INCREMENT NOT NULL, category VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shop_data (id INT AUTO_INCREMENT NOT NULL, shop_related_id INT NOT NULL, phone INT NOT NULL, is_whatsapp TINYINT(1) NOT NULL, description LONGTEXT NOT NULL, logo LONGTEXT DEFAULT NULL, UNIQUE INDEX UNIQ_6C0115183B112D27 (shop_related_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8DC54C8C93 FOREIGN KEY (type_id) REFERENCES post_type (id)');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D3B112D27 FOREIGN KEY (shop_related_id) REFERENCES shop (id)');
        $this->addSql('ALTER TABLE shop ADD CONSTRAINT FK_AC6A4CA264D218E FOREIGN KEY (location_id) REFERENCES location (id)');
        $this->addSql('ALTER TABLE shop ADD CONSTRAINT FK_AC6A4CA2C0316BF2 FOREIGN KEY (shop_category_id) REFERENCES shop_category (id)');
        $this->addSql('ALTER TABLE shop_data ADD CONSTRAINT FK_6C0115183B112D27 FOREIGN KEY (shop_related_id) REFERENCES shop (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE shop DROP FOREIGN KEY FK_AC6A4CA264D218E');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8DC54C8C93');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8D3B112D27');
        $this->addSql('ALTER TABLE shop_data DROP FOREIGN KEY FK_6C0115183B112D27');
        $this->addSql('ALTER TABLE shop DROP FOREIGN KEY FK_AC6A4CA2C0316BF2');
        $this->addSql('DROP TABLE location');
        $this->addSql('DROP TABLE post');
        $this->addSql('DROP TABLE post_type');
        $this->addSql('DROP TABLE shop');
        $this->addSql('DROP TABLE shop_category');
        $this->addSql('DROP TABLE shop_data');
    }
}
