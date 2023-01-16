<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230116192719 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE user_contract_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE user_contract (id INT NOT NULL, contract_owner_id INT NOT NULL, housing_id INT NOT NULL, type VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_902CC59EB8B7A06 ON user_contract (contract_owner_id)');
        $this->addSql('CREATE INDEX IDX_902CC59AD5873E3 ON user_contract (housing_id)');
        $this->addSql('ALTER TABLE user_contract ADD CONSTRAINT FK_902CC59EB8B7A06 FOREIGN KEY (contract_owner_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_contract ADD CONSTRAINT FK_902CC59AD5873E3 FOREIGN KEY (housing_id) REFERENCES housing (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE user_contract_id_seq CASCADE');
        $this->addSql('ALTER TABLE user_contract DROP CONSTRAINT FK_902CC59EB8B7A06');
        $this->addSql('ALTER TABLE user_contract DROP CONSTRAINT FK_902CC59AD5873E3');
        $this->addSql('DROP TABLE user_contract');
    }
}
