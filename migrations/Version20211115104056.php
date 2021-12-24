<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211115104056 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ciclo_ysiembra (id INT AUTO_INCREMENT NOT NULL, variedad_id INT DEFAULT NULL, altitud VARCHAR(255) DEFAULT NULL, zona VARCHAR(255) DEFAULT NULL, coordenadas VARCHAR(255) DEFAULT NULL, ciclo VARCHAR(255) DEFAULT NULL, enero INT DEFAULT NULL, febrero INT DEFAULT NULL, marzo INT DEFAULT NULL, abril INT DEFAULT NULL, mayo INT DEFAULT NULL, junio INT DEFAULT NULL, julio INT DEFAULT NULL, agosto INT DEFAULT NULL, septiembre INT DEFAULT NULL, octubre INT DEFAULT NULL, noviembre INT DEFAULT NULL, diciembre INT DEFAULT NULL, INDEX IDX_9571F45691391A54 (variedad_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE entrada (id INT AUTO_INCREMENT NOT NULL, codigo_entrada INT NOT NULL, num_pasaporte INT DEFAULT NULL, cantidad DOUBLE PRECISION DEFAULT NULL, superficie_cultivo DOUBLE PRECISION DEFAULT NULL, fecha_entrada DATE NOT NULL, tipo_entrada VARCHAR(255) DEFAULT NULL, observaciones VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE entrada_terreno (entrada_id INT NOT NULL, terreno_id INT NOT NULL, INDEX IDX_B70D3062A688222A (entrada_id), INDEX IDX_B70D30621B207222 (terreno_id), PRIMARY KEY(entrada_id, terreno_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE envase (id INT AUTO_INCREMENT NOT NULL, entrada_id INT DEFAULT NULL, tipo_almacenamiento VARCHAR(255) DEFAULT NULL, fecha_envasado DATE NOT NULL, ubicacion_envase VARCHAR(255) DEFAULT NULL, cantidad_gramos DOUBLE PRECISION DEFAULT NULL, cantidad_unidaddes INT DEFAULT NULL, unidades_viables INT DEFAULT NULL, temperatura_envasado DOUBLE PRECISION DEFAULT NULL, humedad_relativa_envasar DOUBLE PRECISION DEFAULT NULL, humedad_relativa_simple DOUBLE PRECISION DEFAULT NULL, cantidad_min_seguridad DOUBLE PRECISION DEFAULT NULL, cantidad_min_unidades DOUBLE PRECISION DEFAULT NULL, unidades_gramo DOUBLE PRECISION DEFAULT NULL, disponibilidad_red VARCHAR(255) DEFAULT NULL, conservacion TINYINT(1) DEFAULT NULL, observaciones VARCHAR(255) DEFAULT NULL, INDEX IDX_F17217D3A688222A (entrada_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE imagen (id INT AUTO_INCREMENT NOT NULL, url VARCHAR(255) DEFAULT NULL, titulo VARCHAR(45) DEFAULT NULL, credito LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE imagen_seleccionada (id INT AUTO_INCREMENT NOT NULL, variedad_id INT DEFAULT NULL, imagen_id INT DEFAULT NULL, tipo VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_854A3B0091391A54 (variedad_id), INDEX IDX_854A3B00763C8AA7 (imagen_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE persona (id INT AUTO_INCREMENT NOT NULL, num_socio INT DEFAULT NULL, fecha_inscripcion_rgcs DATE DEFAULT NULL, acepta_condiciones TINYINT(1) DEFAULT NULL, tipo_socio VARCHAR(40) DEFAULT NULL, ampliacion_cuota TINYINT(1) DEFAULT NULL, fecha_cuota DATE DEFAULT NULL, recibir_informacion TINYINT(1) DEFAULT NULL, fecha_informacion DATE DEFAULT NULL, nif VARCHAR(9) DEFAULT NULL, nombre VARCHAR(40) NOT NULL, apellidos VARCHAR(40) NOT NULL, direccion VARCHAR(255) DEFAULT NULL, localidad VARCHAR(255) DEFAULT NULL, municipio VARCHAR(255) DEFAULT NULL, provincia VARCHAR(255) DEFAULT NULL, region VARCHAR(255) DEFAULT NULL, pais_origen VARCHAR(255) DEFAULT NULL, telefono INT DEFAULT NULL, telefono2 INT DEFAULT NULL, correo VARCHAR(255) DEFAULT NULL, relacion_agricultura VARCHAR(255) DEFAULT NULL, terreno_cultivo TINYINT(1) DEFAULT NULL, inscripcion_rope TINYINT(1) DEFAULT NULL, codigo_rope VARCHAR(6) DEFAULT NULL, otras_cuestiones VARCHAR(255) DEFAULT NULL, documento VARCHAR(255) DEFAULT NULL, observaciones VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE taxon (id INT AUTO_INCREMENT NOT NULL, tipo VARCHAR(255) DEFAULT NULL, nombre VARCHAR(60) DEFAULT NULL, padre INT DEFAULT NULL, autoridad VARCHAR(60) DEFAULT NULL, subtaxon VARCHAR(60) DEFAULT NULL, autoridad_subtaxon VARCHAR(60) DEFAULT NULL, observaciones LONGTEXT DEFAULT NULL, descripcion LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE terreno (id INT AUTO_INCREMENT NOT NULL, id_persona_id INT DEFAULT NULL, direccion VARCHAR(255) DEFAULT NULL, nombre VARCHAR(255) DEFAULT NULL, datos_sigpac VARCHAR(255) DEFAULT NULL, localizacion_mapa VARCHAR(255) DEFAULT NULL, superficie_finca DOUBLE PRECISION DEFAULT NULL, superficie_cultivo DOUBLE PRECISION DEFAULT NULL, manejo_cultivo VARCHAR(255) DEFAULT NULL, tipo_cultivos VARCHAR(255) DEFAULT NULL, observaciones VARCHAR(255) DEFAULT NULL, INDEX IDX_F7395D3C50720D6E (id_persona_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE uso (id INT AUTO_INCREMENT NOT NULL, uso_variedad_id INT DEFAULT NULL, uso VARCHAR(100) DEFAULT NULL, tipo VARCHAR(255) DEFAULT NULL, INDEX IDX_74642555E9D490F0 (uso_variedad_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE uso_variedad (id INT AUTO_INCREMENT NOT NULL, uso_id INT DEFAULT NULL, variedad_id INT DEFAULT NULL, descripcion LONGTEXT DEFAULT NULL, INDEX IDX_CDD228F9AE1A5CB9 (uso_id), INDEX IDX_CDD228F991391A54 (variedad_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE variedad (id INT AUTO_INCREMENT NOT NULL, subtaxon_id INT DEFAULT NULL, nombre_comun VARCHAR(45) DEFAULT NULL COMMENT \'Nombre común del cultivo\', nombre_local VARCHAR(45) DEFAULT NULL, especie VARCHAR(45) DEFAULT NULL, familia VARCHAR(45) DEFAULT NULL, genero VARCHAR(45) DEFAULT NULL, descripcion VARCHAR(1000) DEFAULT NULL, tipo_siembra VARCHAR(12) DEFAULT NULL COMMENT \'ENUM(\'\'directa\'\',\'\'semillero\'\',\'\'voleo\'\')\', dias_semillero INT UNSIGNED DEFAULT NULL, marco_a NUMERIC(4, 3) DEFAULT NULL, marco_b NUMERIC(4, 3) DEFAULT NULL, densidad NUMERIC(4, 3) DEFAULT NULL, ciclo_cultivo INT UNSIGNED DEFAULT NULL, polinizacion VARCHAR(10) DEFAULT NULL COMMENT \'ENUM(\'\'alógama\'\',\'\'autógama\'\',\'\'mixta\'\')\', caracterizacion TINYINT(1) DEFAULT NULL COMMENT \'de momento no hay ficha de caracterización. Fase 2.\', viabilidad_min INT DEFAULT NULL, viabilidad_max INT DEFAULT NULL, conocimientos_tradicionales VARCHAR(60) DEFAULT NULL, cm_planta TEXT DEFAULT NULL, cm_flor TEXT DEFAULT NULL, cm_fruto TEXT DEFAULT NULL, cm_semilla TEXT DEFAULT NULL, c_argonomicas TEXT DEFAULT NULL, c_organolepticas TEXT DEFAULT NULL, propagacion TEXT DEFAULT NULL, otros TEXT DEFAULT NULL, observaciones VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_850B22B3D58349F9 (subtaxon_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ciclo_ysiembra ADD CONSTRAINT FK_9571F45691391A54 FOREIGN KEY (variedad_id) REFERENCES variedad (id)');
        $this->addSql('ALTER TABLE entrada_terreno ADD CONSTRAINT FK_B70D3062A688222A FOREIGN KEY (entrada_id) REFERENCES entrada (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE entrada_terreno ADD CONSTRAINT FK_B70D30621B207222 FOREIGN KEY (terreno_id) REFERENCES terreno (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE envase ADD CONSTRAINT FK_F17217D3A688222A FOREIGN KEY (entrada_id) REFERENCES entrada (id)');
        $this->addSql('ALTER TABLE imagen_seleccionada ADD CONSTRAINT FK_854A3B0091391A54 FOREIGN KEY (variedad_id) REFERENCES variedad (id)');
        $this->addSql('ALTER TABLE imagen_seleccionada ADD CONSTRAINT FK_854A3B00763C8AA7 FOREIGN KEY (imagen_id) REFERENCES imagen (id)');
        $this->addSql('ALTER TABLE terreno ADD CONSTRAINT FK_F7395D3C50720D6E FOREIGN KEY (id_persona_id) REFERENCES persona (id)');
        $this->addSql('ALTER TABLE uso ADD CONSTRAINT FK_74642555E9D490F0 FOREIGN KEY (uso_variedad_id) REFERENCES uso_variedad (id)');
        $this->addSql('ALTER TABLE uso_variedad ADD CONSTRAINT FK_CDD228F9AE1A5CB9 FOREIGN KEY (uso_id) REFERENCES uso (id)');
        $this->addSql('ALTER TABLE uso_variedad ADD CONSTRAINT FK_CDD228F991391A54 FOREIGN KEY (variedad_id) REFERENCES variedad (id)');
        $this->addSql('ALTER TABLE variedad ADD CONSTRAINT FK_850B22B3D58349F9 FOREIGN KEY (subtaxon_id) REFERENCES taxon (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE entrada_terreno DROP FOREIGN KEY FK_B70D3062A688222A');
        $this->addSql('ALTER TABLE envase DROP FOREIGN KEY FK_F17217D3A688222A');
        $this->addSql('ALTER TABLE imagen_seleccionada DROP FOREIGN KEY FK_854A3B00763C8AA7');
        $this->addSql('ALTER TABLE terreno DROP FOREIGN KEY FK_F7395D3C50720D6E');
        $this->addSql('ALTER TABLE variedad DROP FOREIGN KEY FK_850B22B3D58349F9');
        $this->addSql('ALTER TABLE entrada_terreno DROP FOREIGN KEY FK_B70D30621B207222');
        $this->addSql('ALTER TABLE uso_variedad DROP FOREIGN KEY FK_CDD228F9AE1A5CB9');
        $this->addSql('ALTER TABLE uso DROP FOREIGN KEY FK_74642555E9D490F0');
        $this->addSql('ALTER TABLE ciclo_ysiembra DROP FOREIGN KEY FK_9571F45691391A54');
        $this->addSql('ALTER TABLE imagen_seleccionada DROP FOREIGN KEY FK_854A3B0091391A54');
        $this->addSql('ALTER TABLE uso_variedad DROP FOREIGN KEY FK_CDD228F991391A54');
        $this->addSql('DROP TABLE ciclo_ysiembra');
        $this->addSql('DROP TABLE entrada');
        $this->addSql('DROP TABLE entrada_terreno');
        $this->addSql('DROP TABLE envase');
        $this->addSql('DROP TABLE imagen');
        $this->addSql('DROP TABLE imagen_seleccionada');
        $this->addSql('DROP TABLE persona');
        $this->addSql('DROP TABLE taxon');
        $this->addSql('DROP TABLE terreno');
        $this->addSql('DROP TABLE uso');
        $this->addSql('DROP TABLE uso_variedad');
        $this->addSql('DROP TABLE variedad');
    }
}
