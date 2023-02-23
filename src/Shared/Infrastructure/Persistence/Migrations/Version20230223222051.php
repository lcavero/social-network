<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Persistence\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230223222051 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create table network_story';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE network_story (uuid UUID NOT NULL, title VARCHAR(15) NOT NULL, description VARCHAR(15) NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('COMMENT ON COLUMN network_story.uuid IS \'(DC2Type:uuid)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE network_story');
    }
}
