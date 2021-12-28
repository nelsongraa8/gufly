<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211217050912 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_ACD65AA72546FEF1');
        $this->addSql('CREATE TEMPORARY TABLE __temp__themoviedb AS SELECT id, idmovie_id, title, backdrop_path, poster_path, release_date FROM themoviedb');
        $this->addSql('DROP TABLE themoviedb');
        $this->addSql('CREATE TABLE themoviedb (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, idmovie_id INTEGER DEFAULT NULL, title VARCHAR(255) NOT NULL COLLATE BINARY, backdrop_path VARCHAR(255) NOT NULL COLLATE BINARY, poster_path VARCHAR(255) NOT NULL COLLATE BINARY, release_date VARCHAR(255) NOT NULL COLLATE BINARY, CONSTRAINT FK_ACD65AA72546FEF1 FOREIGN KEY (idmovie_id) REFERENCES movies (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO themoviedb (id, idmovie_id, title, backdrop_path, poster_path, release_date) SELECT id, idmovie_id, title, backdrop_path, poster_path, release_date FROM __temp__themoviedb');
        $this->addSql('DROP TABLE __temp__themoviedb');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_ACD65AA72546FEF1 ON themoviedb (idmovie_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_ACD65AA72546FEF1');
        $this->addSql('CREATE TEMPORARY TABLE __temp__themoviedb AS SELECT id, idmovie_id, title, release_date, backdrop_path, poster_path FROM themoviedb');
        $this->addSql('DROP TABLE themoviedb');
        $this->addSql('CREATE TABLE themoviedb (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, idmovie_id INTEGER DEFAULT NULL, title VARCHAR(255) NOT NULL, release_date VARCHAR(255) NOT NULL, backdrop_path VARCHAR(255) NOT NULL, poster_path VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO themoviedb (id, idmovie_id, title, release_date, backdrop_path, poster_path) SELECT id, idmovie_id, title, release_date, backdrop_path, poster_path FROM __temp__themoviedb');
        $this->addSql('DROP TABLE __temp__themoviedb');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_ACD65AA72546FEF1 ON themoviedb (idmovie_id)');
    }
}
