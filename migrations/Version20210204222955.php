<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210204222955 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, shop_id INT NOT NULL, category_name VARCHAR(255) NOT NULL, INDEX IDX_64C19C14D16C4DD (shop_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comentary (id INT AUTO_INCREMENT NOT NULL, shop_related_id INT DEFAULT NULL, content LONGTEXT NOT NULL, INDEX IDX_87EE25083B112D27 (shop_related_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE location (id INT AUTO_INCREMENT NOT NULL, shop_id INT NOT NULL, latitude DOUBLE PRECISION NOT NULL, longitude DOUBLE PRECISION NOT NULL, address VARCHAR(255) NOT NULL, google_id LONGTEXT NOT NULL, INDEX IDX_5E9E89CB4D16C4DD (shop_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post (id INT AUTO_INCREMENT NOT NULL, shop_related_id INT DEFAULT NULL, type_related_id INT NOT NULL, title VARCHAR(255) NOT NULL, post_content LONGTEXT NOT NULL, image LONGTEXT NOT NULL, INDEX IDX_5A8A6C8D3B112D27 (shop_related_id), INDEX IDX_5A8A6C8D5C611624 (type_related_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post_user_like (post_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_44C6B1424B89032C (post_id), INDEX IDX_44C6B142A76ED395 (user_id), PRIMARY KEY(post_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post_type (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shop (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shop_user_rating (rate INT , shop_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_4C6130324D16C4DD (shop_id), INDEX IDX_4C613032A76ED395 (user_id), PRIMARY KEY(shop_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shop_data (id INT AUTO_INCREMENT NOT NULL, shop_id INT NOT NULL, phone INT NOT NULL, is_whatsaap TINYINT(1) NOT NULL, description LONGTEXT NOT NULL, image LONGTEXT NOT NULL, rate_average DOUBLE PRECISION NOT NULL, INDEX IDX_6C0115184D16C4DD (shop_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, surname VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, avatar LONGTEXT NOT NULL, uid_firebase VARCHAR(150) NOT NULL, nick VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_shop_subscriptions (user_id INT NOT NULL, shop_id INT NOT NULL, INDEX IDX_D6EB006BA76ED395 (user_id), INDEX IDX_D6EB006B4D16C4DD (shop_id), PRIMARY KEY(user_id, shop_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C14D16C4DD FOREIGN KEY (shop_id) REFERENCES shop (id)');
        $this->addSql('ALTER TABLE comentary ADD CONSTRAINT FK_87EE25083B112D27 FOREIGN KEY (shop_related_id) REFERENCES shop (id)');
        $this->addSql('ALTER TABLE location ADD CONSTRAINT FK_5E9E89CB4D16C4DD FOREIGN KEY (shop_id) REFERENCES shop (id)');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D3B112D27 FOREIGN KEY (shop_related_id) REFERENCES shop (id)');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D5C611624 FOREIGN KEY (type_related_id) REFERENCES post_type (id)');
        $this->addSql('ALTER TABLE post_user_like ADD CONSTRAINT FK_44C6B1424B89032C FOREIGN KEY (post_id) REFERENCES post (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE post_user_like ADD CONSTRAINT FK_44C6B142A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE shop_user_rating ADD CONSTRAINT FK_4C6130324D16C4DD FOREIGN KEY (shop_id) REFERENCES shop (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE shop_user_rating ADD CONSTRAINT FK_4C613032A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE shop_data ADD CONSTRAINT FK_6C0115184D16C4DD FOREIGN KEY (shop_id) REFERENCES shop (id)');
        $this->addSql('ALTER TABLE user_shop_subscriptions ADD CONSTRAINT FK_D6EB006BA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_shop_subscriptions ADD CONSTRAINT FK_D6EB006B4D16C4DD FOREIGN KEY (shop_id) REFERENCES shop (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post_user_like DROP FOREIGN KEY FK_44C6B1424B89032C');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8D5C611624');
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C14D16C4DD');
        $this->addSql('ALTER TABLE comentary DROP FOREIGN KEY FK_87EE25083B112D27');
        $this->addSql('ALTER TABLE location DROP FOREIGN KEY FK_5E9E89CB4D16C4DD');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8D3B112D27');
        $this->addSql('ALTER TABLE shop_user_rating DROP FOREIGN KEY FK_4C6130324D16C4DD');
        $this->addSql('ALTER TABLE shop_data DROP FOREIGN KEY FK_6C0115184D16C4DD');
        $this->addSql('ALTER TABLE user_shop_subscriptions DROP FOREIGN KEY FK_D6EB006B4D16C4DD');
        $this->addSql('ALTER TABLE post_user_like DROP FOREIGN KEY FK_44C6B142A76ED395');
        $this->addSql('ALTER TABLE shop_user_rating DROP FOREIGN KEY FK_4C613032A76ED395');
        $this->addSql('ALTER TABLE user_shop_subscriptions DROP FOREIGN KEY FK_D6EB006BA76ED395');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE comentary');
        $this->addSql('DROP TABLE location');
        $this->addSql('DROP TABLE post');
        $this->addSql('DROP TABLE post_user_like');
        $this->addSql('DROP TABLE post_type');
        $this->addSql('DROP TABLE shop');
        $this->addSql('DROP TABLE shop_user_rating');
        $this->addSql('DROP TABLE shop_data');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE user_shop_subscriptions');
    }
}
