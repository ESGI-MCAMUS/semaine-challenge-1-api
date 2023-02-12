<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230212011802 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE appointment ALTER created_at DROP NOT NULL');
        $this->addSql('ALTER TABLE appointment ALTER updated_at DROP NOT NULL');
        $this->addSql('ALTER TABLE "user" ALTER is_active DROP DEFAULT');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE appointment ALTER created_at SET NOT NULL');
        $this->addSql('ALTER TABLE appointment ALTER updated_at SET NOT NULL');
        $this->addSql('ALTER TABLE "user" ALTER is_active SET DEFAULT false');
    }
}
