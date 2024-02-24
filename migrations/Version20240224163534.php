<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240224163534 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add players to team';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE team_players (team_id UUID NOT NULL, player_id UUID NOT NULL, PRIMARY KEY(team_id, player_id))');
        $this->addSql('CREATE INDEX IDX_D9373291296CD8AE ON team_players (team_id)');
        $this->addSql('CREATE INDEX IDX_D937329199E6F5DF ON team_players (player_id)');
        $this->addSql('COMMENT ON COLUMN team_players.team_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN team_players.player_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE team_players ADD CONSTRAINT FK_D9373291296CD8AE FOREIGN KEY (team_id) REFERENCES player (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE team_players ADD CONSTRAINT FK_D937329199E6F5DF FOREIGN KEY (player_id) REFERENCES team (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE team_players DROP CONSTRAINT FK_D9373291296CD8AE');
        $this->addSql('ALTER TABLE team_players DROP CONSTRAINT FK_D937329199E6F5DF');
        $this->addSql('DROP TABLE team_players');
    }
}
