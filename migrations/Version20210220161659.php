<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210220161659 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, surname VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, nick VARCHAR(255) NOT NULL, avatar LONGTEXT DEFAULT NULL, uid_firebase LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comentary (id INT AUTO_INCREMENT NOT NULL, shop_comentary_related_id INT DEFAULT NULL, client_related_id INT DEFAULT NULL, content_comentary LONGTEXT NOT NULL, INDEX IDX_87EE25087969C32F (shop_comentary_related_id), INDEX IDX_87EE2508D136FD40 (client_related_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE data_shop (id INT AUTO_INCREMENT NOT NULL, phone INT NOT NULL, is_whatsapp TINYINT(1) NOT NULL, description LONGTEXT NOT NULL, image LONGTEXT DEFAULT NULL, rate_average DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE location (id INT AUTO_INCREMENT NOT NULL, latitude DOUBLE PRECISION NOT NULL, longitude DOUBLE PRECISION NOT NULL, address VARCHAR(255) NOT NULL, id_google VARCHAR(512) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post (id INT AUTO_INCREMENT NOT NULL, type_of_id INT DEFAULT NULL, post_of_shop_id INT DEFAULT NULL, like_of_client_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, image LONGTEXT DEFAULT NULL, INDEX IDX_5A8A6C8D5401248B (type_of_id), INDEX IDX_5A8A6C8D931B3CAD (post_of_shop_id), INDEX IDX_5A8A6C8D243CA2EE (like_of_client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shop (id INT AUTO_INCREMENT NOT NULL, data_id INT DEFAULT NULL, location_id INT DEFAULT NULL, category_related_id INT DEFAULT NULL, client_like_shop_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_AC6A4CA237F5A13C (data_id), UNIQUE INDEX UNIQ_AC6A4CA264D218E (location_id), INDEX IDX_AC6A4CA2677C907F (category_related_id), INDEX IDX_AC6A4CA2AF912CFF (client_like_shop_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_post (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE comentary ADD CONSTRAINT FK_87EE25087969C32F FOREIGN KEY (shop_comentary_related_id) REFERENCES shop (id)');
        $this->addSql('ALTER TABLE comentary ADD CONSTRAINT FK_87EE2508D136FD40 FOREIGN KEY (client_related_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D5401248B FOREIGN KEY (type_of_id) REFERENCES type_post (id)');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D931B3CAD FOREIGN KEY (post_of_shop_id) REFERENCES shop (id)');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D243CA2EE FOREIGN KEY (like_of_client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE shop ADD CONSTRAINT FK_AC6A4CA237F5A13C FOREIGN KEY (data_id) REFERENCES data_shop (id)');
        $this->addSql('ALTER TABLE shop ADD CONSTRAINT FK_AC6A4CA264D218E FOREIGN KEY (location_id) REFERENCES location (id)');
        $this->addSql('ALTER TABLE shop ADD CONSTRAINT FK_AC6A4CA2677C907F FOREIGN KEY (category_related_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE shop ADD CONSTRAINT FK_AC6A4CA2AF912CFF FOREIGN KEY (client_like_shop_id) REFERENCES client (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE shop DROP FOREIGN KEY FK_AC6A4CA2677C907F');
        $this->addSql('ALTER TABLE comentary DROP FOREIGN KEY FK_87EE2508D136FD40');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8D243CA2EE');
        $this->addSql('ALTER TABLE shop DROP FOREIGN KEY FK_AC6A4CA2AF912CFF');
        $this->addSql('ALTER TABLE shop DROP FOREIGN KEY FK_AC6A4CA237F5A13C');
        $this->addSql('ALTER TABLE shop DROP FOREIGN KEY FK_AC6A4CA264D218E');
        $this->addSql('ALTER TABLE comentary DROP FOREIGN KEY FK_87EE25087969C32F');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8D931B3CAD');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8D5401248B');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE comentary');
        $this->addSql('DROP TABLE data_shop');
        $this->addSql('DROP TABLE location');
        $this->addSql('DROP TABLE post');
        $this->addSql('DROP TABLE shop');
        $this->addSql('DROP TABLE type_post');
    }
}
