<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230116191341 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE real_estate_ad_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE real_estate_ad (id INT NOT NULL, housing_id INT NOT NULL, publisher_id INT NOT NULL, type VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, title VARCHAR(255) NOT NULL, description TEXT NOT NULL, photos JSON NOT NULL, is_visible BOOLEAN NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D6973374AD5873E3 ON real_estate_ad (housing_id)');
        $this->addSql('CREATE INDEX IDX_D697337440C86FCE ON real_estate_ad (publisher_id)');
        $this->addSql('ALTER TABLE real_estate_ad ADD CONSTRAINT FK_D6973374AD5873E3 FOREIGN KEY (housing_id) REFERENCES housing (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE real_estate_ad ADD CONSTRAINT FK_D697337440C86FCE FOREIGN KEY (publisher_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE real_estate_ad_id_seq CASCADE');
        $this->addSql('ALTER TABLE real_estate_ad DROP CONSTRAINT FK_D6973374AD5873E3');
        $this->addSql('ALTER TABLE real_estate_ad DROP CONSTRAINT FK_D697337440C86FCE');
        $this->addSql('DROP TABLE real_estate_ad');
    }
}
