<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210919102404 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__movies AS SELECT id, nombre, productora, anno, poster, fanart, descripcion, url, idioma_subtitulo, duracion, director, genero FROM movies');
        $this->addSql('DROP TABLE movies');
        $this->addSql('CREATE TABLE movies (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL COLLATE BINARY, productora VARCHAR(255) DEFAULT NULL COLLATE BINARY, anno VARCHAR(255) DEFAULT NULL COLLATE BINARY, fanart VARCHAR(255) DEFAULT NULL COLLATE BINARY, descripcion CLOB DEFAULT NULL COLLATE BINARY, url CLOB NOT NULL COLLATE BINARY, idioma_subtitulo VARCHAR(255) DEFAULT NULL COLLATE BINARY, duracion INTEGER DEFAULT NULL, director VARCHAR(255) DEFAULT NULL COLLATE BINARY, genero VARCHAR(255) DEFAULT NULL COLLATE BINARY, poster VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO movies (id, nombre, productora, anno, poster, fanart, descripcion, url, idioma_subtitulo, duracion, director, genero) SELECT id, nombre, productora, anno, poster, fanart, descripcion, url, idioma_subtitulo, duracion, director, genero FROM __temp__movies');
        $this->addSql('DROP TABLE __temp__movies');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__movies AS SELECT id, nombre, productora, anno, poster, fanart, descripcion, url, idioma_subtitulo, duracion, director, genero FROM movies');
        $this->addSql('DROP TABLE movies');
        $this->addSql('CREATE TABLE movies (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, productora VARCHAR(255) DEFAULT NULL, anno VARCHAR(255) DEFAULT NULL, fanart VARCHAR(255) DEFAULT NULL, descripcion CLOB DEFAULT NULL, url CLOB NOT NULL, idioma_subtitulo VARCHAR(255) DEFAULT NULL, duracion INTEGER DEFAULT NULL, director VARCHAR(255) DEFAULT NULL, genero VARCHAR(255) DEFAULT NULL, poster INTEGER DEFAULT NULL)');
        $this->addSql('INSERT INTO movies (id, nombre, productora, anno, poster, fanart, descripcion, url, idioma_subtitulo, duracion, director, genero) SELECT id, nombre, productora, anno, poster, fanart, descripcion, url, idioma_subtitulo, duracion, director, genero FROM __temp__movies');
        $this->addSql('DROP TABLE __temp__movies');
    }
}
