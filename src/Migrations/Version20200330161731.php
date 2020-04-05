<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200330161731 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user_adress (id INT AUTO_INCREMENT NOT NULL, street VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bijou_bijou (bijou_source INT NOT NULL, bijou_target INT NOT NULL, INDEX IDX_EF556DA5E5F9EF3 (bijou_source), INDEX IDX_EF556DA517BACE7C (bijou_target), PRIMARY KEY(bijou_source, bijou_target)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE popup_taille (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, popup LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bijou_bijou ADD CONSTRAINT FK_EF556DA5E5F9EF3 FOREIGN KEY (bijou_source) REFERENCES bijou (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bijou_bijou ADD CONSTRAINT FK_EF556DA517BACE7C FOREIGN KEY (bijou_target) REFERENCES bijou (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE user_adress');
        $this->addSql('DROP TABLE bijou_bijou');
        $this->addSql('DROP TABLE popup_taille');
    }
}
