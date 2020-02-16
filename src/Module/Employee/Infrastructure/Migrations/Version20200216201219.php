<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200216201219 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE salary_report_view (id UUID NOT NULL, employee_id UUID DEFAULT NULL, path VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_4BC9E90E8C03F15C ON salary_report_view (employee_id)');
        $this->addSql('COMMENT ON COLUMN salary_report_view.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN salary_report_view.employee_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE salary_report_view ADD CONSTRAINT FK_4BC9E90E8C03F15C FOREIGN KEY (employee_id) REFERENCES employee_view (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE worked_day_view ALTER employee_id DROP NOT NULL');
        $this->addSql('ALTER TABLE worked_day_view ADD CONSTRAINT FK_777C65018C03F15C FOREIGN KEY (employee_id) REFERENCES employee_view (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_777C65018C03F15C ON worked_day_view (employee_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE salary_report_view');
        $this->addSql('ALTER TABLE worked_day_view DROP CONSTRAINT FK_777C65018C03F15C');
        $this->addSql('DROP INDEX IDX_777C65018C03F15C');
        $this->addSql('ALTER TABLE worked_day_view ALTER employee_id SET NOT NULL');
    }
}
