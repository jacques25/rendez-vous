<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200421072339 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE bijou_bijou');
        $this->addSql('DROP TABLE boutique_description_produit');
        $this->addSql('DROP TABLE produit_description_produit');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE bijou_bijou (bijou_source INT NOT NULL, bijou_target INT NOT NULL, INDEX IDX_EF556DA517BACE7C (bijou_target), INDEX IDX_EF556DA5E5F9EF3 (bijou_source), PRIMARY KEY(bijou_source, bijou_target)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE boutique_description_produit (boutique_id INT NOT NULL, description_produit_id INT NOT NULL, INDEX IDX_B3338C9BB0D8A93A (description_produit_id), INDEX IDX_B3338C9BAB677BE6 (boutique_id), PRIMARY KEY(boutique_id, description_produit_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE produit_description_produit (produit_id INT NOT NULL, description_produit_id INT NOT NULL, INDEX IDX_4DAFD88B0D8A93A (description_produit_id), INDEX IDX_4DAFD88F347EFB (produit_id), PRIMARY KEY(produit_id, description_produit_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE boutique_description_produit ADD CONSTRAINT FK_B3338C9BAB677BE6 FOREIGN KEY (boutique_id) REFERENCES boutique (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE boutique_description_produit ADD CONSTRAINT FK_B3338C9BB0D8A93A FOREIGN KEY (description_produit_id) REFERENCES description_produit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE produit_description_produit ADD CONSTRAINT FK_4DAFD88B0D8A93A FOREIGN KEY (description_produit_id) REFERENCES description_produit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE produit_description_produit ADD CONSTRAINT FK_4DAFD88F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id) ON DELETE CASCADE');
    }
}
