<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171217192332 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('ALTER TABLE user ADD COLUMN roles CLOB DEFAULT NULL');
        $this->addSql('DROP INDEX IDX_5076A4C0A76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__run AS SELECT id, user_id, date, distance, time, speed FROM run');
        $this->addSql('DROP TABLE run');
        $this->addSql('CREATE TABLE run (id INTEGER NOT NULL, user_id INTEGER DEFAULT NULL, date DATE NOT NULL, distance DOUBLE PRECISION NOT NULL, time TIME NOT NULL, speed DOUBLE PRECISION NOT NULL, PRIMARY KEY(id), CONSTRAINT FK_5076A4C0A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO run (id, user_id, date, distance, time, speed) SELECT id, user_id, date, distance, time, speed FROM __temp__run');
        $this->addSql('DROP TABLE __temp__run');
        $this->addSql('CREATE INDEX IDX_5076A4C0A76ED395 ON run (user_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_5076A4C0A76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__run AS SELECT id, user_id, date, distance, time, speed FROM run');
        $this->addSql('DROP TABLE run');
        $this->addSql('CREATE TABLE run (id INTEGER NOT NULL, user_id INTEGER DEFAULT NULL, date DATE NOT NULL, distance DOUBLE PRECISION NOT NULL, time TIME NOT NULL, speed DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO run (id, user_id, date, distance, time, speed) SELECT id, user_id, date, distance, time, speed FROM __temp__run');
        $this->addSql('DROP TABLE __temp__run');
        $this->addSql('CREATE INDEX IDX_5076A4C0A76ED395 ON run (user_id)');
        $this->addSql('DROP INDEX UNIQ_8D93D649E7927C74');
        $this->addSql('DROP INDEX UNIQ_8D93D649F85E0677');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, email, username, password FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TABLE user (id INTEGER NOT NULL, email VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(64) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO user (id, email, username, password) SELECT id, email, username, password FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649F85E0677 ON user (username)');
    }
}
