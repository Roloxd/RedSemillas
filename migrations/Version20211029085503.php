<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211029085503 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE imagen (id INT AUTO_INCREMENT NOT NULL, url LONGTEXT DEFAULT NULL, titulo VARCHAR(45) DEFAULT NULL, credito LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE imagen_seleccionada (id INT AUTO_INCREMENT NOT NULL, imagen_id INT DEFAULT NULL, tipo VARCHAR(255) DEFAULT NULL, INDEX IDX_854A3B00763C8AA7 (imagen_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE imagen_seleccionada ADD CONSTRAINT FK_854A3B00763C8AA7 FOREIGN KEY (imagen_id) REFERENCES imagen (id)');
        $this->addSql('ALTER TABLE variedad ADD imagen_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE variedad ADD CONSTRAINT FK_850B22B3763C8AA7 FOREIGN KEY (imagen_id) REFERENCES imagen_seleccionada (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_850B22B3763C8AA7 ON variedad (imagen_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE imagen_seleccionada DROP FOREIGN KEY FK_854A3B00763C8AA7');
        $this->addSql('ALTER TABLE variedad DROP FOREIGN KEY FK_850B22B3763C8AA7');
        $this->addSql('DROP TABLE imagen');
        $this->addSql('DROP TABLE imagen_seleccionada');
        $this->addSql('DROP INDEX UNIQ_850B22B3763C8AA7 ON variedad');
        $this->addSql('ALTER TABLE variedad DROP imagen_id');
    }
}
