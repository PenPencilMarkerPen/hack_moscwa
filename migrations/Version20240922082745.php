<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240922082745 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE inform (id INT NOT NULL, admin_id INT NOT NULL, session_id INT DEFAULT NULL, alpha VARCHAR(255) NOT NULL, betta VARCHAR(255) NOT NULL, date_time VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_CBF7144E642B8210 ON inform (admin_id)');
        $this->addSql('CREATE INDEX IDX_CBF7144E613FECDF ON inform (session_id)');
        $this->addSql('CREATE TABLE session (id INT NOT NULL, users_id INT DEFAULT NULL, date_time VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D044D5D467B3B43D ON session (users_id)');
        $this->addSql('CREATE TABLE users (id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON users (email)');
        $this->addSql('ALTER TABLE inform ADD CONSTRAINT FK_CBF7144E642B8210 FOREIGN KEY (admin_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE inform ADD CONSTRAINT FK_CBF7144E613FECDF FOREIGN KEY (session_id) REFERENCES session (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE session ADD CONSTRAINT FK_D044D5D467B3B43D FOREIGN KEY (users_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE inform DROP CONSTRAINT FK_CBF7144E642B8210');
        $this->addSql('ALTER TABLE inform DROP CONSTRAINT FK_CBF7144E613FECDF');
        $this->addSql('ALTER TABLE session DROP CONSTRAINT FK_D044D5D467B3B43D');
        $this->addSql('DROP TABLE inform');
        $this->addSql('DROP TABLE session');
        $this->addSql('DROP TABLE users');
    }
}
