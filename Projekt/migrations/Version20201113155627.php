<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201113155627 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE answer (id INT AUTO_INCREMENT NOT NULL, author_id INT NOT NULL, question_id INT DEFAULT NULL, description VARCHAR(255) NOT NULL, INDEX IDX_DADD4A25F675F31B (author_id), INDEX IDX_DADD4A251E27F6BF (question_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, assigne_id INT DEFAULT NULL, created_by_id INT NOT NULL, title VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, docx_filename VARCHAR(255) DEFAULT NULL, pdf_filename VARCHAR(255) DEFAULT NULL, is_active TINYINT(1) NOT NULL, version INT NOT NULL, editable TINYINT(1) NOT NULL, INDEX IDX_23A0E668E7B8AB0 (assigne_id), INDEX IDX_23A0E66B03A8386 (created_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE article_magazine (article_id INT NOT NULL, magazine_id INT NOT NULL, INDEX IDX_6264DB8F7294869C (article_id), INDEX IDX_6264DB8F3EB84A1D (magazine_id), PRIMARY KEY(article_id, magazine_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE issue (id INT AUTO_INCREMENT NOT NULL, created_at DATETIME NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, visible_for_author TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE issue_comment (id INT AUTO_INCREMENT NOT NULL, author_id INT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_318C178DF675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE magazine (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, rating INT NOT NULL, printing_capacity INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question (id INT AUTO_INCREMENT NOT NULL, author_id INT DEFAULT NULL, author_mail VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_B6F7494EF675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE review (id INT AUTO_INCREMENT NOT NULL, article_id INT NOT NULL, description VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_794381C67294869C (article_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE review_review_category (review_id INT NOT NULL, review_category_id INT NOT NULL, INDEX IDX_8E028AD93E2E969B (review_id), INDEX IDX_8E028AD96C80719E (review_category_id), PRIMARY KEY(review_id, review_category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE review_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, max_points INT NOT NULL, min_points INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, alias VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE state (id INT AUTO_INCREMENT NOT NULL, question_id INT NOT NULL, article_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_A393D2FB1E27F6BF (question_id), INDEX IDX_A393D2FB7294869C (article_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE state_state_group (state_id INT NOT NULL, state_group_id INT NOT NULL, INDEX IDX_D477E4945D83CC1 (state_id), INDEX IDX_D477E494C1A7BFE0 (state_group_id), PRIMARY KEY(state_id, state_group_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE state_group (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_role (user_id INT NOT NULL, role_id INT NOT NULL, INDEX IDX_2DE8C6A3A76ED395 (user_id), INDEX IDX_2DE8C6A3D60322AC (role_id), PRIMARY KEY(user_id, role_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE answer ADD CONSTRAINT FK_DADD4A25F675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE answer ADD CONSTRAINT FK_DADD4A251E27F6BF FOREIGN KEY (question_id) REFERENCES question (id)');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E668E7B8AB0 FOREIGN KEY (assigne_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE article_magazine ADD CONSTRAINT FK_6264DB8F7294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE article_magazine ADD CONSTRAINT FK_6264DB8F3EB84A1D FOREIGN KEY (magazine_id) REFERENCES magazine (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE issue_comment ADD CONSTRAINT FK_318C178DF675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494EF675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C67294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE review_review_category ADD CONSTRAINT FK_8E028AD93E2E969B FOREIGN KEY (review_id) REFERENCES review (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE review_review_category ADD CONSTRAINT FK_8E028AD96C80719E FOREIGN KEY (review_category_id) REFERENCES review_category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE state ADD CONSTRAINT FK_A393D2FB1E27F6BF FOREIGN KEY (question_id) REFERENCES question (id)');
        $this->addSql('ALTER TABLE state ADD CONSTRAINT FK_A393D2FB7294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE state_state_group ADD CONSTRAINT FK_D477E4945D83CC1 FOREIGN KEY (state_id) REFERENCES state (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE state_state_group ADD CONSTRAINT FK_D477E494C1A7BFE0 FOREIGN KEY (state_group_id) REFERENCES state_group (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_role ADD CONSTRAINT FK_2DE8C6A3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_role ADD CONSTRAINT FK_2DE8C6A3D60322AC FOREIGN KEY (role_id) REFERENCES role (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article_magazine DROP FOREIGN KEY FK_6264DB8F7294869C');
        $this->addSql('ALTER TABLE review DROP FOREIGN KEY FK_794381C67294869C');
        $this->addSql('ALTER TABLE state DROP FOREIGN KEY FK_A393D2FB7294869C');
        $this->addSql('ALTER TABLE article_magazine DROP FOREIGN KEY FK_6264DB8F3EB84A1D');
        $this->addSql('ALTER TABLE answer DROP FOREIGN KEY FK_DADD4A251E27F6BF');
        $this->addSql('ALTER TABLE state DROP FOREIGN KEY FK_A393D2FB1E27F6BF');
        $this->addSql('ALTER TABLE review_review_category DROP FOREIGN KEY FK_8E028AD93E2E969B');
        $this->addSql('ALTER TABLE review_review_category DROP FOREIGN KEY FK_8E028AD96C80719E');
        $this->addSql('ALTER TABLE user_role DROP FOREIGN KEY FK_2DE8C6A3D60322AC');
        $this->addSql('ALTER TABLE state_state_group DROP FOREIGN KEY FK_D477E4945D83CC1');
        $this->addSql('ALTER TABLE state_state_group DROP FOREIGN KEY FK_D477E494C1A7BFE0');
        $this->addSql('DROP TABLE answer');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE article_magazine');
        $this->addSql('DROP TABLE issue');
        $this->addSql('DROP TABLE issue_comment');
        $this->addSql('DROP TABLE magazine');
        $this->addSql('DROP TABLE question');
        $this->addSql('DROP TABLE review');
        $this->addSql('DROP TABLE review_review_category');
        $this->addSql('DROP TABLE review_category');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE state');
        $this->addSql('DROP TABLE state_state_group');
        $this->addSql('DROP TABLE state_group');
        $this->addSql('DROP TABLE user_role');
    }
}
