<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201113155918 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE previous_states (state_id INT NOT NULL, state_group_id INT NOT NULL, INDEX IDX_C4264BE35D83CC1 (state_id), INDEX IDX_C4264BE3C1A7BFE0 (state_group_id), PRIMARY KEY(state_id, state_group_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE next_states (state_id INT NOT NULL, state_group_id INT NOT NULL, INDEX IDX_681772F15D83CC1 (state_id), INDEX IDX_681772F1C1A7BFE0 (state_group_id), PRIMARY KEY(state_id, state_group_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE previous_states ADD CONSTRAINT FK_C4264BE35D83CC1 FOREIGN KEY (state_id) REFERENCES state (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE previous_states ADD CONSTRAINT FK_C4264BE3C1A7BFE0 FOREIGN KEY (state_group_id) REFERENCES state_group (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE next_states ADD CONSTRAINT FK_681772F15D83CC1 FOREIGN KEY (state_id) REFERENCES state (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE next_states ADD CONSTRAINT FK_681772F1C1A7BFE0 FOREIGN KEY (state_group_id) REFERENCES state_group (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE state_state_group');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE state_state_group (state_id INT NOT NULL, state_group_id INT NOT NULL, INDEX IDX_D477E4945D83CC1 (state_id), INDEX IDX_D477E494C1A7BFE0 (state_group_id), PRIMARY KEY(state_id, state_group_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE state_state_group ADD CONSTRAINT FK_D477E4945D83CC1 FOREIGN KEY (state_id) REFERENCES state (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE state_state_group ADD CONSTRAINT FK_D477E494C1A7BFE0 FOREIGN KEY (state_group_id) REFERENCES state_group (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE previous_states');
        $this->addSql('DROP TABLE next_states');
    }
}
