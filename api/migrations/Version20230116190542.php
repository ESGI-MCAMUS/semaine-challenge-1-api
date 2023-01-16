<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230116190542 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE housing_properties_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE housing_properties (id INT NOT NULL, surface INT NOT NULL, type VARCHAR(255) NOT NULL, rooms INT NOT NULL, has_garden BOOLEAN NOT NULL, has_parking BOOLEAN NOT NULL, has_pool BOOLEAN NOT NULL, has_cave BOOLEAN NOT NULL, has_attic BOOLEAN NOT NULL, has_balcony BOOLEAN NOT NULL, near_public_transport BOOLEAN NOT NULL, classification VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE housing_properties_id_seq CASCADE');
        $this->addSql('DROP TABLE housing_properties');
    }
}
