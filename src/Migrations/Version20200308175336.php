<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200308175336 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE app_entity_bijou (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bijou DROP FOREIGN KEY FK_E4B4D7947E9E4C8C');
        $this->addSql('DROP INDEX UNIQ_E4B4D7947E9E4C8C ON bijou');
        $this->addSql('ALTER TABLE bijou ADD filename VARCHAR(255) DEFAULT NULL, DROP photo_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE app_entity_bijou');
        $this->addSql('ALTER TABLE bijou ADD photo_id INT DEFAULT NULL, DROP filename');
        $this->addSql('ALTER TABLE bijou ADD CONSTRAINT FK_E4B4D7947E9E4C8C FOREIGN KEY (photo_id) REFERENCES photo (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E4B4D7947E9E4C8C ON bijou (photo_id)');
    }
}
