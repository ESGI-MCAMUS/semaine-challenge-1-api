<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230118173618 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE housing ALTER created_at DROP NOT NULL');
        $this->addSql('ALTER TABLE housing ALTER updated_at DROP NOT NULL');
        $this->addSql('ALTER TABLE housing_properties ALTER created_at DROP NOT NULL');
        $this->addSql('ALTER TABLE housing_properties ALTER updated_at DROP NOT NULL');
        $this->addSql('ALTER TABLE real_estate_ad ALTER created_at DROP NOT NULL');
        $this->addSql('ALTER TABLE real_estate_ad ALTER updated_at DROP NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE housing_properties ALTER created_at SET NOT NULL');
        $this->addSql('ALTER TABLE housing_properties ALTER updated_at SET NOT NULL');
        $this->addSql('ALTER TABLE real_estate_ad ALTER created_at SET NOT NULL');
        $this->addSql('ALTER TABLE real_estate_ad ALTER updated_at SET NOT NULL');
        $this->addSql('ALTER TABLE housing ALTER created_at SET NOT NULL');
        $this->addSql('ALTER TABLE housing ALTER updated_at SET NOT NULL');
    }
}
