<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201113163647 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article ADD state_id INT NOT NULL');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E665D83CC1 FOREIGN KEY (state_id) REFERENCES state (id)');
        $this->addSql('CREATE INDEX IDX_23A0E665D83CC1 ON article (state_id)');
        $this->addSql('ALTER TABLE question ADD state_id INT NOT NULL');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494E5D83CC1 FOREIGN KEY (state_id) REFERENCES state (id)');
        $this->addSql('CREATE INDEX IDX_B6F7494E5D83CC1 ON question (state_id)');
        $this->addSql('ALTER TABLE state DROP FOREIGN KEY FK_A393D2FB1E27F6BF');
        $this->addSql('ALTER TABLE state DROP FOREIGN KEY FK_A393D2FB7294869C');
        $this->addSql('DROP INDEX IDX_A393D2FB1E27F6BF ON state');
        $this->addSql('DROP INDEX IDX_A393D2FB7294869C ON state');
        $this->addSql('ALTER TABLE state DROP question_id, DROP article_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E665D83CC1');
        $this->addSql('DROP INDEX IDX_23A0E665D83CC1 ON article');
        $this->addSql('ALTER TABLE article DROP state_id');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494E5D83CC1');
        $this->addSql('DROP INDEX IDX_B6F7494E5D83CC1 ON question');
        $this->addSql('ALTER TABLE question DROP state_id');
        $this->addSql('ALTER TABLE state ADD question_id INT NOT NULL, ADD article_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE state ADD CONSTRAINT FK_A393D2FB1E27F6BF FOREIGN KEY (question_id) REFERENCES question (id)');
        $this->addSql('ALTER TABLE state ADD CONSTRAINT FK_A393D2FB7294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('CREATE INDEX IDX_A393D2FB1E27F6BF ON state (question_id)');
        $this->addSql('CREATE INDEX IDX_A393D2FB7294869C ON state (article_id)');
    }
}
