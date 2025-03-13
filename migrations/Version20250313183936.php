<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250313183936 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE project (id UUID NOT NULL, title VARCHAR(255) NOT NULL, year INT NOT NULL, description VARCHAR(255) NOT NULL, technologies TEXT NOT NULL, task VARCHAR(255) NOT NULL, workflow VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN project.id IS \'(DC2Type:ulid)\'');
        $this->addSql('COMMENT ON COLUMN project.technologies IS \'(DC2Type:array)\'');
        $this->addSql('CREATE TABLE resume (id UUID NOT NULL, name VARCHAR(255) NOT NULL, birthdate TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, school_graduation VARCHAR(255) NOT NULL, training_graduation VARCHAR(255) NOT NULL, positions TEXT NOT NULL, languages TEXT NOT NULL, programming_languages TEXT NOT NULL, tools TEXT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN resume.id IS \'(DC2Type:ulid)\'');
        $this->addSql('COMMENT ON COLUMN resume.positions IS \'(DC2Type:array)\'');
        $this->addSql('COMMENT ON COLUMN resume.languages IS \'(DC2Type:array)\'');
        $this->addSql('COMMENT ON COLUMN resume.programming_languages IS \'(DC2Type:array)\'');
        $this->addSql('COMMENT ON COLUMN resume.tools IS \'(DC2Type:array)\'');
        $this->addSql('COMMENT ON COLUMN resume.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN resume.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE resume_project (resume_id UUID NOT NULL, project_id UUID NOT NULL, PRIMARY KEY(resume_id, project_id))');
        $this->addSql('CREATE INDEX IDX_19F36F06D262AF09 ON resume_project (resume_id)');
        $this->addSql('CREATE INDEX IDX_19F36F06166D1F9C ON resume_project (project_id)');
        $this->addSql('COMMENT ON COLUMN resume_project.resume_id IS \'(DC2Type:ulid)\'');
        $this->addSql('COMMENT ON COLUMN resume_project.project_id IS \'(DC2Type:ulid)\'');
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
        $this->addSql('ALTER TABLE resume_project ADD CONSTRAINT FK_19F36F06D262AF09 FOREIGN KEY (resume_id) REFERENCES resume (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE resume_project ADD CONSTRAINT FK_19F36F06166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE resume_project DROP CONSTRAINT FK_19F36F06D262AF09');
        $this->addSql('ALTER TABLE resume_project DROP CONSTRAINT FK_19F36F06166D1F9C');
        $this->addSql('DROP TABLE project');
        $this->addSql('DROP TABLE resume');
        $this->addSql('DROP TABLE resume_project');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
