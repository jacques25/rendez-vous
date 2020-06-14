<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200614091903 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE seance_users (user_id INT NOT NULL, seance_id INT NOT NULL, INDEX IDX_B95B6A5A76ED395 (user_id), INDEX IDX_B95B6A5E3797A94 (seance_id), PRIMARY KEY(user_id, seance_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_seance_option (user_id INT NOT NULL, seance_option_id INT NOT NULL, INDEX IDX_CB7DB648A76ED395 (user_id), INDEX IDX_CB7DB648F9F65FE1 (seance_option_id), PRIMARY KEY(user_id, seance_option_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE seance_users ADD CONSTRAINT FK_B95B6A5A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE seance_users ADD CONSTRAINT FK_B95B6A5E3797A94 FOREIGN KEY (seance_id) REFERENCES seance (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_seance_option ADD CONSTRAINT FK_CB7DB648A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_seance_option ADD CONSTRAINT FK_CB7DB648F9F65FE1 FOREIGN KEY (seance_option_id) REFERENCES seance_option (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE seance_users');
        $this->addSql('DROP TABLE user_seance_option');
    }
}
