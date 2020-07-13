<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200709163054 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bijou ADD label_promo VARCHAR(255) DEFAULT NULL, ADD promoIsActive TINYINT(1) DEFAULT NULL, ADD date_start DATETIME DEFAULT NULL, ADD date_end DATETIME DEFAULT NULL, ADD port DOUBLE PRECISION DEFAULT NULL, ADD multiplicate DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE promo DROP FOREIGN KEY FK_B0139AFB9E2EF1B5');
        $this->addSql('DROP INDEX IDX_B0139AFB9E2EF1B5 ON promo');
        $this->addSql('ALTER TABLE promo DROP bijou_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bijou DROP label_promo, DROP promoIsActive, DROP date_start, DROP date_end, DROP port, DROP multiplicate');
        $this->addSql('ALTER TABLE promo ADD bijou_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE promo ADD CONSTRAINT FK_B0139AFB9E2EF1B5 FOREIGN KEY (bijou_id) REFERENCES bijou (id)');
        $this->addSql('CREATE INDEX IDX_B0139AFB9E2EF1B5 ON promo (bijou_id)');
    }
}
