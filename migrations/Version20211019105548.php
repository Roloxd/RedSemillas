<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211019105548 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE persona (id INT AUTO_INCREMENT NOT NULL, num_socio INT DEFAULT NULL, fecha_inscripcion_rgcs DATE DEFAULT NULL, acepta_condiciones TINYINT(1) DEFAULT NULL, tipo_socio VARCHAR(40) DEFAULT NULL, ampliacion_cuota TINYINT(1) DEFAULT NULL, fecha_cuota DATE DEFAULT NULL, recibir_informacion TINYINT(1) DEFAULT NULL, fecha_informacion DATE DEFAULT NULL, nif VARCHAR(9) DEFAULT NULL, nombre VARCHAR(40) NOT NULL, apellidos VARCHAR(40) NOT NULL, direccion VARCHAR(255) DEFAULT NULL, localidad VARCHAR(255) DEFAULT NULL, municipio VARCHAR(255) DEFAULT NULL, provincia VARCHAR(255) DEFAULT NULL, region VARCHAR(255) DEFAULT NULL, pais_origen VARCHAR(255) DEFAULT NULL, telefono INT DEFAULT NULL, telefono2 INT DEFAULT NULL, correo VARCHAR(255) DEFAULT NULL, relacion_agricultura VARCHAR(255) DEFAULT NULL, terreno_cultivo TINYINT(1) DEFAULT NULL, inscripcion_rope TINYINT(1) DEFAULT NULL, codigo_rope VARCHAR(6) DEFAULT NULL, otras_cuestiones VARCHAR(255) DEFAULT NULL, documento VARCHAR(255) DEFAULT NULL, observaciones VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE terreno (id INT AUTO_INCREMENT NOT NULL, id_persona_id INT DEFAULT NULL, direccion VARCHAR(255) DEFAULT NULL, nombre VARCHAR(255) DEFAULT NULL, datos_sigpac VARCHAR(255) DEFAULT NULL, localizacion_mapa VARCHAR(255) DEFAULT NULL, superficie_finca DOUBLE PRECISION DEFAULT NULL, superficie_cultivo DOUBLE PRECISION DEFAULT NULL, manejo_cultivo VARCHAR(255) DEFAULT NULL, tipo_cultivos VARCHAR(255) DEFAULT NULL, observaciones VARCHAR(255) DEFAULT NULL, INDEX IDX_F7395D3C50720D6E (id_persona_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE terreno ADD CONSTRAINT FK_F7395D3C50720D6E FOREIGN KEY (id_persona_id) REFERENCES persona (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE terreno DROP FOREIGN KEY FK_F7395D3C50720D6E');
        $this->addSql('DROP TABLE persona');
        $this->addSql('DROP TABLE terreno');
    }
}
