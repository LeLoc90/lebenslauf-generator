<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250319124732 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE language (ulid VARCHAR(255) NOT NULL, resume_ulid VARCHAR(255) DEFAULT NULL, title VARCHAR(255) NOT NULL, level INT NOT NULL, PRIMARY KEY(ulid))');
        $this->addSql('CREATE INDEX IDX_D4DB71B53C4E099D ON language (resume_ulid)');
        $this->addSql('CREATE TABLE project (ulid VARCHAR(255) NOT NULL, resume_ulid VARCHAR(255) DEFAULT NULL, title VARCHAR(255) NOT NULL, year INT NOT NULL, description VARCHAR(255) NOT NULL, technologies TEXT NOT NULL, task VARCHAR(255) NOT NULL, workflow VARCHAR(255) NOT NULL, PRIMARY KEY(ulid))');
        $this->addSql('CREATE INDEX IDX_2FB3D0EE3C4E099D ON project (resume_ulid)');
        $this->addSql('COMMENT ON COLUMN project.technologies IS \'(DC2Type:array)\'');
        $this->addSql('CREATE TABLE resume (ulid VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, school_graduation VARCHAR(255) NOT NULL, training_graduation VARCHAR(255) NOT NULL, positions TEXT NOT NULL, programming_languages TEXT NOT NULL, tools TEXT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, birthdate DATE DEFAULT NULL, PRIMARY KEY(ulid))');
        $this->addSql('COMMENT ON COLUMN resume.positions IS \'(DC2Type:array)\'');
        $this->addSql('COMMENT ON COLUMN resume.programming_languages IS \'(DC2Type:array)\'');
        $this->addSql('COMMENT ON COLUMN resume.tools IS \'(DC2Type:array)\'');
        $this->addSql('COMMENT ON COLUMN resume.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN resume.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('COMMENT ON COLUMN messenger_messages.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.available_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.delivered_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE language ADD CONSTRAINT FK_D4DB71B53C4E099D FOREIGN KEY (resume_ulid) REFERENCES resume (ulid) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EE3C4E099D FOREIGN KEY (resume_ulid) REFERENCES resume (ulid) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE language DROP CONSTRAINT FK_D4DB71B53C4E099D');
        $this->addSql('ALTER TABLE project DROP CONSTRAINT FK_2FB3D0EE3C4E099D');
        $this->addSql('DROP TABLE language');
        $this->addSql('DROP TABLE project');
        $this->addSql('DROP TABLE resume');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
