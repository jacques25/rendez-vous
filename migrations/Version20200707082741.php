<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200707082741 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE promo (id INT AUTO_INCREMENT NOT NULL, bijou_id INT DEFAULT NULL, label VARCHAR(255) DEFAULT NULL, promoIsActive TINYINT(1) DEFAULT NULL, date_start DATETIME DEFAULT NULL, date_end DATETIME DEFAULT NULL, port DOUBLE PRECISION DEFAULT NULL, multiplicate DOUBLE PRECISION DEFAULT NULL, INDEX IDX_B0139AFB9E2EF1B5 (bijou_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE promo ADD CONSTRAINT FK_B0139AFB9E2EF1B5 FOREIGN KEY (bijou_id) REFERENCES bijou (id)');
        $this->addSql('ALTER TABLE bijou DROP promoIsActive, DROP promo, DROP date_start, DROP date_end, DROP port, DROP multiplicate');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE promo');
        $this->addSql('ALTER TABLE bijou ADD promoIsActive TINYINT(1) DEFAULT NULL, ADD promo VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ADD date_start DATETIME DEFAULT NULL, ADD date_end DATETIME DEFAULT NULL, ADD port DOUBLE PRECISION DEFAULT NULL, ADD multiplicate DOUBLE PRECISION DEFAULT NULL');
    }
}
