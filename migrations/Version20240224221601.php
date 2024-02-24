<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240224221601 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add game entity';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE game (id UUID NOT NULL, home_team_id UUID DEFAULT NULL, away_team_id UUID DEFAULT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_232B318C5E237E06 ON game (name)');
        $this->addSql('CREATE INDEX IDX_232B318C9C4C13F6 ON game (home_team_id)');
        $this->addSql('CREATE INDEX IDX_232B318C45185D02 ON game (away_team_id)');
        $this->addSql('COMMENT ON COLUMN game.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN game.home_team_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN game.away_team_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C9C4C13F6 FOREIGN KEY (home_team_id) REFERENCES team (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C45185D02 FOREIGN KEY (away_team_id) REFERENCES team (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE game DROP CONSTRAINT FK_232B318C9C4C13F6');
        $this->addSql('ALTER TABLE game DROP CONSTRAINT FK_232B318C45185D02');
        $this->addSql('DROP TABLE game');
    }
}
