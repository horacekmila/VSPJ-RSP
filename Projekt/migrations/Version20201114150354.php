<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201114150354 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE next_states');
        $this->addSql('DROP TABLE previous_states');
        $this->addSql('ALTER TABLE state ADD previous_state_group_id INT DEFAULT NULL, ADD next_state_group_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE state ADD CONSTRAINT FK_A393D2FB1CA203C1 FOREIGN KEY (previous_state_group_id) REFERENCES state_group (id)');
        $this->addSql('ALTER TABLE state ADD CONSTRAINT FK_A393D2FB65367389 FOREIGN KEY (next_state_group_id) REFERENCES state_group (id)');
        $this->addSql('CREATE INDEX IDX_A393D2FB1CA203C1 ON state (previous_state_group_id)');
        $this->addSql('CREATE INDEX IDX_A393D2FB65367389 ON state (next_state_group_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE next_states (state_id INT NOT NULL, state_group_id INT NOT NULL, INDEX IDX_681772F15D83CC1 (state_id), INDEX IDX_681772F1C1A7BFE0 (state_group_id), PRIMARY KEY(state_id, state_group_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE previous_states (state_id INT NOT NULL, state_group_id INT NOT NULL, INDEX IDX_C4264BE35D83CC1 (state_id), INDEX IDX_C4264BE3C1A7BFE0 (state_group_id), PRIMARY KEY(state_id, state_group_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE next_states ADD CONSTRAINT FK_681772F15D83CC1 FOREIGN KEY (state_id) REFERENCES state (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE next_states ADD CONSTRAINT FK_681772F1C1A7BFE0 FOREIGN KEY (state_group_id) REFERENCES state_group (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE previous_states ADD CONSTRAINT FK_C4264BE35D83CC1 FOREIGN KEY (state_id) REFERENCES state (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE previous_states ADD CONSTRAINT FK_C4264BE3C1A7BFE0 FOREIGN KEY (state_group_id) REFERENCES state_group (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE state DROP FOREIGN KEY FK_A393D2FB1CA203C1');
        $this->addSql('ALTER TABLE state DROP FOREIGN KEY FK_A393D2FB65367389');
        $this->addSql('DROP INDEX IDX_A393D2FB1CA203C1 ON state');
        $this->addSql('DROP INDEX IDX_A393D2FB65367389 ON state');
        $this->addSql('ALTER TABLE state DROP previous_state_group_id, DROP next_state_group_id');
    }
}
