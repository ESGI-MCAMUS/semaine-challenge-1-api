<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230116192150 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE documents_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE documents (id INT NOT NULL, housing_id INT NOT NULL, documents_owner_id INT NOT NULL, documents JSON NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A2B07288AD5873E3 ON documents (housing_id)');
        $this->addSql('CREATE INDEX IDX_A2B0728817A5EF66 ON documents (documents_owner_id)');
        $this->addSql('ALTER TABLE documents ADD CONSTRAINT FK_A2B07288AD5873E3 FOREIGN KEY (housing_id) REFERENCES housing (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE documents ADD CONSTRAINT FK_A2B0728817A5EF66 FOREIGN KEY (documents_owner_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE documents_id_seq CASCADE');
        $this->addSql('ALTER TABLE documents DROP CONSTRAINT FK_A2B07288AD5873E3');
        $this->addSql('ALTER TABLE documents DROP CONSTRAINT FK_A2B0728817A5EF66');
        $this->addSql('DROP TABLE documents');
    }
}
