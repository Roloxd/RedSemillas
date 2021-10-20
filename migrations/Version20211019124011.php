<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211019124011 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE entrada (id INT AUTO_INCREMENT NOT NULL, codigo_entrada INT NOT NULL, num_pasaporte INT DEFAULT NULL, cantidad DOUBLE PRECISION DEFAULT NULL, superficie_cultivo DOUBLE PRECISION DEFAULT NULL, fecha_entrada DATE NOT NULL, tipo_entrada VARCHAR(255) DEFAULT NULL, observaciones VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE entrada_terreno (entrada_id INT NOT NULL, terreno_id INT NOT NULL, INDEX IDX_B70D3062A688222A (entrada_id), INDEX IDX_B70D30621B207222 (terreno_id), PRIMARY KEY(entrada_id, terreno_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE envase (id INT AUTO_INCREMENT NOT NULL, entrada_id INT DEFAULT NULL, tipo_almacenamiento VARCHAR(255) DEFAULT NULL, fecha_envasado DATE NOT NULL, ubicacion_envase VARCHAR(255) DEFAULT NULL, cantidad_gramos DOUBLE PRECISION DEFAULT NULL, cantidad_unidaddes INT DEFAULT NULL, unidades_viables INT DEFAULT NULL, temperatura_envasado DOUBLE PRECISION DEFAULT NULL, humedad_relativa_envasar DOUBLE PRECISION DEFAULT NULL, humedad_relativa_simple DOUBLE PRECISION DEFAULT NULL, cantidad_min_seguridad DOUBLE PRECISION DEFAULT NULL, cantidad_min_unidades DOUBLE PRECISION DEFAULT NULL, unidades_gramo DOUBLE PRECISION DEFAULT NULL, disponibilidad_red VARCHAR(255) DEFAULT NULL, conservacion TINYINT(1) DEFAULT NULL, observaciones VARCHAR(255) DEFAULT NULL, INDEX IDX_F17217D3A688222A (entrada_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE entrada_terreno ADD CONSTRAINT FK_B70D3062A688222A FOREIGN KEY (entrada_id) REFERENCES entrada (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE entrada_terreno ADD CONSTRAINT FK_B70D30621B207222 FOREIGN KEY (terreno_id) REFERENCES terreno (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE envase ADD CONSTRAINT FK_F17217D3A688222A FOREIGN KEY (entrada_id) REFERENCES entrada (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE entrada_terreno DROP FOREIGN KEY FK_B70D3062A688222A');
        $this->addSql('ALTER TABLE envase DROP FOREIGN KEY FK_F17217D3A688222A');
        $this->addSql('DROP TABLE entrada');
        $this->addSql('DROP TABLE entrada_terreno');
        $this->addSql('DROP TABLE envase');
    }
}
