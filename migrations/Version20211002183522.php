<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211002183522 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_731E324453F590A4');
        $this->addSql('CREATE TEMPORARY TABLE __temp__destacadas AS SELECT id, movies_id, title, text FROM destacadas');
        $this->addSql('DROP TABLE destacadas');
        $this->addSql('CREATE TABLE destacadas (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, movies_id INTEGER DEFAULT NULL, title VARCHAR(255) DEFAULT NULL COLLATE BINARY, text VARCHAR(255) DEFAULT NULL COLLATE BINARY, CONSTRAINT FK_731E324453F590A4 FOREIGN KEY (movies_id) REFERENCES movies (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO destacadas (id, movies_id, title, text) SELECT id, movies_id, title, text FROM __temp__destacadas');
        $this->addSql('DROP TABLE __temp__destacadas');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_731E324453F590A4 ON destacadas (movies_id)');
        $this->addSql('ALTER TABLE movies ADD COLUMN tmdbid INTEGER DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_731E324453F590A4');
        $this->addSql('CREATE TEMPORARY TABLE __temp__destacadas AS SELECT id, movies_id, title, text FROM destacadas');
        $this->addSql('DROP TABLE destacadas');
        $this->addSql('CREATE TABLE destacadas (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, movies_id INTEGER DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, text VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO destacadas (id, movies_id, title, text) SELECT id, movies_id, title, text FROM __temp__destacadas');
        $this->addSql('DROP TABLE __temp__destacadas');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_731E324453F590A4 ON destacadas (movies_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__movies AS SELECT id, nombre, productora, anno, poster, fanart, descripcion, url, idioma_subtitulo, duracion, director, genero, relevante FROM movies');
        $this->addSql('DROP TABLE movies');
        $this->addSql('CREATE TABLE movies (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, productora VARCHAR(255) DEFAULT NULL, anno VARCHAR(255) DEFAULT NULL, poster VARCHAR(255) DEFAULT NULL, fanart VARCHAR(255) DEFAULT NULL, descripcion CLOB DEFAULT NULL, url CLOB NOT NULL, idioma_subtitulo VARCHAR(255) DEFAULT NULL, duracion INTEGER DEFAULT NULL, director VARCHAR(255) DEFAULT NULL, genero VARCHAR(255) DEFAULT NULL, relevante BOOLEAN DEFAULT NULL)');
        $this->addSql('INSERT INTO movies (id, nombre, productora, anno, poster, fanart, descripcion, url, idioma_subtitulo, duracion, director, genero, relevante) SELECT id, nombre, productora, anno, poster, fanart, descripcion, url, idioma_subtitulo, duracion, director, genero, relevante FROM __temp__movies');
        $this->addSql('DROP TABLE __temp__movies');
    }
}
