<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230116193400 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE favorite_ad_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE favorite_ad (id INT NOT NULL, fk_user_id INT NOT NULL, real_estate_ad_id INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_62CEC2155741EEB9 ON favorite_ad (fk_user_id)');
        $this->addSql('CREATE INDEX IDX_62CEC215AFB966BD ON favorite_ad (real_estate_ad_id)');
        $this->addSql('ALTER TABLE favorite_ad ADD CONSTRAINT FK_62CEC2155741EEB9 FOREIGN KEY (fk_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE favorite_ad ADD CONSTRAINT FK_62CEC215AFB966BD FOREIGN KEY (real_estate_ad_id) REFERENCES real_estate_ad (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE favorite_ad_id_seq CASCADE');
        $this->addSql('ALTER TABLE favorite_ad DROP CONSTRAINT FK_62CEC2155741EEB9');
        $this->addSql('ALTER TABLE favorite_ad DROP CONSTRAINT FK_62CEC215AFB966BD');
        $this->addSql('DROP TABLE favorite_ad');
    }
}
