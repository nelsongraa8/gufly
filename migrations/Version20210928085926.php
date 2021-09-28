<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210928085926 extends AbstractMigration
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
        $this->addSql('CREATE TABLE destacadas (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, movies_id INTEGER NOT NULL, title VARCHAR(255) DEFAULT NULL COLLATE BINARY, text VARCHAR(255) DEFAULT NULL COLLATE BINARY, CONSTRAINT FK_731E324453F590A4 FOREIGN KEY (movies_id) REFERENCES movies (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO destacadas (id, movies_id, title, text) SELECT id, movies_id, title, text FROM __temp__destacadas');
        $this->addSql('DROP TABLE __temp__destacadas');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_731E324453F590A4 ON destacadas (movies_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_731E324453F590A4');
        $this->addSql('CREATE TEMPORARY TABLE __temp__destacadas AS SELECT id, movies_id, title, text FROM destacadas');
        $this->addSql('DROP TABLE destacadas');
        $this->addSql('CREATE TABLE destacadas (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, movies_id INTEGER NOT NULL, title VARCHAR(255) DEFAULT NULL, text VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO destacadas (id, movies_id, title, text) SELECT id, movies_id, title, text FROM __temp__destacadas');
        $this->addSql('DROP TABLE __temp__destacadas');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_731E324453F590A4 ON destacadas (movies_id)');
    }
}
