<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211029092731 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ciclo_ysiembra (id INT AUTO_INCREMENT NOT NULL, variedad_id INT DEFAULT NULL, altitud VARCHAR(255) DEFAULT NULL, zona VARCHAR(255) DEFAULT NULL, coordenadas VARCHAR(255) DEFAULT NULL, ciclo VARCHAR(255) DEFAULT NULL, enero INT DEFAULT NULL, febrero INT DEFAULT NULL, marzo INT DEFAULT NULL, abril INT DEFAULT NULL, mayo INT DEFAULT NULL, junio INT DEFAULT NULL, julio INT DEFAULT NULL, agosto INT DEFAULT NULL, septiembre INT DEFAULT NULL, octubre INT DEFAULT NULL, noviembre INT DEFAULT NULL, diciembre INT DEFAULT NULL, INDEX IDX_9571F45691391A54 (variedad_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ciclo_ysiembra ADD CONSTRAINT FK_9571F45691391A54 FOREIGN KEY (variedad_id) REFERENCES variedad (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE ciclo_ysiembra');
    }
}
