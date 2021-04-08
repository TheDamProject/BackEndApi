<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210408174731 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8D4D16C4DD');
        $this->addSql('DROP INDEX IDX_5A8A6C8D4D16C4DD ON post');
        $this->addSql('ALTER TABLE post ADD shop_id_id INT NOT NULL, DROP shop_id');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8DB852C405 FOREIGN KEY (shop_id_id) REFERENCES shop (id)');
        $this->addSql('CREATE INDEX IDX_5A8A6C8DB852C405 ON post (shop_id_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8DB852C405');
        $this->addSql('DROP INDEX IDX_5A8A6C8DB852C405 ON post');
        $this->addSql('ALTER TABLE post ADD shop_id INT DEFAULT NULL, DROP shop_id_id');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D4D16C4DD FOREIGN KEY (shop_id) REFERENCES shop (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_5A8A6C8D4D16C4DD ON post (shop_id)');
    }
}
