<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210220200418 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client ADD post_like_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455B8734D01 FOREIGN KEY (post_like_id) REFERENCES post (id)');
        $this->addSql('CREATE INDEX IDX_C7440455B8734D01 ON client (post_like_id)');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8D243CA2EE');
        $this->addSql('DROP INDEX IDX_5A8A6C8D243CA2EE ON post');
        $this->addSql('ALTER TABLE post DROP like_of_client_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C7440455B8734D01');
        $this->addSql('DROP INDEX IDX_C7440455B8734D01 ON client');
        $this->addSql('ALTER TABLE client DROP post_like_id');
        $this->addSql('ALTER TABLE post ADD like_of_client_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D243CA2EE FOREIGN KEY (like_of_client_id) REFERENCES client (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_5A8A6C8D243CA2EE ON post (like_of_client_id)');
    }
}
