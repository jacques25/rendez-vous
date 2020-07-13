<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200708143042 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE promo DROP FOREIGN KEY FK_B0139AFBBE598011');
        $this->addSql('DROP INDEX IDX_B0139AFBBE598011 ON promo');
        $this->addSql('ALTER TABLE promo CHANGE option_bijou_id bijou_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE promo ADD CONSTRAINT FK_B0139AFB9E2EF1B5 FOREIGN KEY (bijou_id) REFERENCES bijou (id)');
        $this->addSql('CREATE INDEX IDX_B0139AFB9E2EF1B5 ON promo (bijou_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE promo DROP FOREIGN KEY FK_B0139AFB9E2EF1B5');
        $this->addSql('DROP INDEX IDX_B0139AFB9E2EF1B5 ON promo');
        $this->addSql('ALTER TABLE promo CHANGE bijou_id option_bijou_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE promo ADD CONSTRAINT FK_B0139AFBBE598011 FOREIGN KEY (option_bijou_id) REFERENCES option_bijou (id)');
        $this->addSql('CREATE INDEX IDX_B0139AFBBE598011 ON promo (option_bijou_id)');
    }
}
