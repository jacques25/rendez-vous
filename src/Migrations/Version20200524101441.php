<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200524101441 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE booking ADD user_seance_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDEE399F770 FOREIGN KEY (user_seance_id) REFERENCES user_seance (id)');
        $this->addSql('CREATE INDEX IDX_E00CEDDEE399F770 ON booking (user_seance_id)');
        $this->addSql('ALTER TABLE formation CHANGE filename filename VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user_seance DROP FOREIGN KEY FK_BA2FE633F9F65FE1');
        $this->addSql('DROP INDEX IDX_BA2FE633F9F65FE1 ON user_seance');
        $this->addSql('ALTER TABLE user_seance DROP seance_option_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDEE399F770');
        $this->addSql('DROP INDEX IDX_E00CEDDEE399F770 ON booking');
        $this->addSql('ALTER TABLE booking DROP user_seance_id');
        $this->addSql('ALTER TABLE formation CHANGE filename filename VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE user_seance ADD seance_option_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user_seance ADD CONSTRAINT FK_BA2FE633F9F65FE1 FOREIGN KEY (seance_option_id) REFERENCES seance_option (id)');
        $this->addSql('CREATE INDEX IDX_BA2FE633F9F65FE1 ON user_seance (seance_option_id)');
    }
}
