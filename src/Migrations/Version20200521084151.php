<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200521084151 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE `group` (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_formation ADD first_name VARCHAR(255) NOT NULL, ADD last_name VARCHAR(255) NOT NULL, ADD roles JSON NOT NULL COMMENT \'(DC2Type:json_array)\', ADD password VARCHAR(255) NOT NULL, ADD introduction VARCHAR(255) DEFAULT NULL, ADD description LONGTEXT DEFAULT NULL, ADD slug VARCHAR(255) NOT NULL, ADD filename VARCHAR(255) DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL, ADD enabled TINYINT(1) NOT NULL, ADD subscribedToNewsletter TINYINT(1) NOT NULL, ADD reset_token VARCHAR(255) DEFAULT NULL, ADD confirm_token VARCHAR(255) DEFAULT NULL, DROP lastname, DROP firstname, CHANGE phone phone VARCHAR(10) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE `group`');
        $this->addSql('ALTER TABLE user_formation ADD lastname VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD firstname VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP first_name, DROP last_name, DROP roles, DROP password, DROP introduction, DROP description, DROP slug, DROP filename, DROP updated_at, DROP enabled, DROP subscribedToNewsletter, DROP reset_token, DROP confirm_token, CHANGE phone phone VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
