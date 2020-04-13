<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200413174557 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE worked_day (id UUID NOT NULL, hours_amount INT NOT NULL, day TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, employee_id UUID NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN worked_day.id IS \'(DC2Type:uuid_id)\'');
        $this->addSql('COMMENT ON COLUMN worked_day.employee_id IS \'(DC2Type:aggregate_root_id)\'');
        $this->addSql('CREATE TABLE commission (id UUID NOT NULL, commission DOUBLE PRECISION NOT NULL, month TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, employee_id UUID NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN commission.id IS \'(DC2Type:uuid_id)\'');
        $this->addSql('COMMENT ON COLUMN commission.employee_id IS \'(DC2Type:aggregate_root_id)\'');
        $this->addSql('CREATE TABLE employee (id UUID NOT NULL, remuneration_calculation_way VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, salary DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN employee.id IS \'(DC2Type:aggregate_root_id)\'');
        $this->addSql('COMMENT ON COLUMN employee.remuneration_calculation_way IS \'(DC2Type:remuneration_calculation_way)\'');
        $this->addSql('CREATE TABLE salary_report (id UUID NOT NULL, employee_id UUID DEFAULT NULL, month INT NOT NULL, hours_amount INT NOT NULL, salary_report_type VARCHAR(255) NOT NULL, reward DOUBLE PRECISION NOT NULL, path VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN salary_report.id IS \'(DC2Type:uuid_id)\'');
        $this->addSql('COMMENT ON COLUMN salary_report.employee_id IS \'(DC2Type:aggregate_root_id)\'');
        $this->addSql('COMMENT ON COLUMN salary_report.salary_report_type IS \'(DC2Type:salary_report_type)\'');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE worked_day');
        $this->addSql('DROP TABLE commission');
        $this->addSql('DROP TABLE employee');
        $this->addSql('DROP TABLE salary_report');
    }
}
