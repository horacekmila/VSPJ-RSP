<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210110155747 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE review ADD category_1_rating INT NOT NULL, ADD category_2_rating INT NOT NULL, ADD category_3_rating INT NOT NULL, ADD category_4_rating INT NOT NULL, ADD category_5_rating INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE review DROP category_1_rating, DROP category_2_rating, DROP category_3_rating, DROP category_4_rating, DROP category_5_rating');
    }
}
