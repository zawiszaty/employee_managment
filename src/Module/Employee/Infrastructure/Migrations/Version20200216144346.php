<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200216144346 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('postgresql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE employee_view ALTER remuneration_calculation_way TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE employee_view ALTER remuneration_calculation_way DROP DEFAULT');
        $this->addSql('COMMENT ON COLUMN employee_view.remuneration_calculation_way IS \'(DC2Type:remuneration_calculation_way)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('postgresql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE employee_view ALTER remuneration_calculation_way TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE employee_view ALTER remuneration_calculation_way DROP DEFAULT');
        $this->addSql('COMMENT ON COLUMN employee_view.remuneration_calculation_way IS NULL');
    }
}
