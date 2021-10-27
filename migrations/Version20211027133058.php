<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211027133058 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE variedad (id INT AUTO_INCREMENT NOT NULL, nombre_comun VARCHAR(45) DEFAULT NULL COMMENT \'Nombre común del cultivo\', nombre_local VARCHAR(45) DEFAULT NULL, especie VARCHAR(45) DEFAULT NULL, familia VARCHAR(45) DEFAULT NULL, genero VARCHAR(45) DEFAULT NULL, subtaxon VARCHAR(45) DEFAULT NULL, descripcion VARCHAR(1000) DEFAULT NULL, tipo_siembra VARCHAR(12) DEFAULT NULL COMMENT \'ENUM(\'\'directa\'\',\'\'semillero\'\',\'\'voleo\'\')\', dias_semillero INT UNSIGNED DEFAULT NULL, marco_a NUMERIC(4, 3) DEFAULT NULL, marco_b NUMERIC(4, 3) DEFAULT NULL, densidad NUMERIC(4, 3) DEFAULT NULL, ciclo_cultivo INT UNSIGNED DEFAULT NULL, polinizacion VARCHAR(10) DEFAULT NULL COMMENT \'ENUM(\'\'alógama\'\',\'\'autógama\'\',\'\'mixta\'\')\', caracterizacion INT DEFAULT NULL COMMENT \'de momento no hay ficha de caracterización. Fase 2.\', viabilidad_min INT DEFAULT NULL, viabilidad_max INT DEFAULT NULL, conocimientos_tradicionales VARCHAR(60) DEFAULT NULL, cm_planta TEXT DEFAULT NULL, cm_flor TEXT DEFAULT NULL, cm_fruto TEXT DEFAULT NULL, cm_semilla TEXT DEFAULT NULL, c_argonomicas TEXT DEFAULT NULL, c_organolepticas TEXT DEFAULT NULL, propagacion TEXT DEFAULT NULL, otros TEXT DEFAULT NULL, observaciones VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE variedad');
    }
}
