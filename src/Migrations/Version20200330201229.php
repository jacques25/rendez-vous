<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200330201229 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE bijou_popup_taille (bijou_id INT NOT NULL, popup_taille_id INT NOT NULL, INDEX IDX_1961F3A99E2EF1B5 (bijou_id), INDEX IDX_1961F3A9A2CA9276 (popup_taille_id), PRIMARY KEY(bijou_id, popup_taille_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bijou_popup_taille ADD CONSTRAINT FK_1961F3A99E2EF1B5 FOREIGN KEY (bijou_id) REFERENCES bijou (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bijou_popup_taille ADD CONSTRAINT FK_1961F3A9A2CA9276 FOREIGN KEY (popup_taille_id) REFERENCES popup_taille (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE bijou_bijou');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE bijou_bijou (bijou_source INT NOT NULL, bijou_target INT NOT NULL, INDEX IDX_EF556DA517BACE7C (bijou_target), INDEX IDX_EF556DA5E5F9EF3 (bijou_source), PRIMARY KEY(bijou_source, bijou_target)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE bijou_bijou ADD CONSTRAINT FK_EF556DA517BACE7C FOREIGN KEY (bijou_target) REFERENCES bijou (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bijou_bijou ADD CONSTRAINT FK_EF556DA5E5F9EF3 FOREIGN KEY (bijou_source) REFERENCES bijou (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE bijou_popup_taille');
    }
}
