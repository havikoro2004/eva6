<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220811131118 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE mission_target (mission_id INT NOT NULL, target_id INT NOT NULL, INDEX IDX_1E97F5B2BE6CAE90 (mission_id), INDEX IDX_1E97F5B2158E0B66 (target_id), PRIMARY KEY(mission_id, target_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mission_planque (mission_id INT NOT NULL, planque_id INT NOT NULL, INDEX IDX_DA0690F7BE6CAE90 (mission_id), INDEX IDX_DA0690F7CE8A20B (planque_id), PRIMARY KEY(mission_id, planque_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE mission_target ADD CONSTRAINT FK_1E97F5B2BE6CAE90 FOREIGN KEY (mission_id) REFERENCES mission (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE mission_target ADD CONSTRAINT FK_1E97F5B2158E0B66 FOREIGN KEY (target_id) REFERENCES target (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE mission_planque ADD CONSTRAINT FK_DA0690F7BE6CAE90 FOREIGN KEY (mission_id) REFERENCES mission (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE mission_planque ADD CONSTRAINT FK_DA0690F7CE8A20B FOREIGN KEY (planque_id) REFERENCES planque (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE planque DROP FOREIGN KEY FK_4B3A04BABE6CAE90');
        $this->addSql('DROP INDEX IDX_4B3A04BABE6CAE90 ON planque');
        $this->addSql('ALTER TABLE planque DROP mission_id');
        $this->addSql('ALTER TABLE target DROP FOREIGN KEY FK_466F2FFCBE6CAE90');
        $this->addSql('DROP INDEX IDX_466F2FFCBE6CAE90 ON target');
        $this->addSql('ALTER TABLE target DROP mission_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mission_target DROP FOREIGN KEY FK_1E97F5B2BE6CAE90');
        $this->addSql('ALTER TABLE mission_target DROP FOREIGN KEY FK_1E97F5B2158E0B66');
        $this->addSql('ALTER TABLE mission_planque DROP FOREIGN KEY FK_DA0690F7BE6CAE90');
        $this->addSql('ALTER TABLE mission_planque DROP FOREIGN KEY FK_DA0690F7CE8A20B');
        $this->addSql('DROP TABLE mission_target');
        $this->addSql('DROP TABLE mission_planque');
        $this->addSql('ALTER TABLE planque ADD mission_id INT NOT NULL');
        $this->addSql('ALTER TABLE planque ADD CONSTRAINT FK_4B3A04BABE6CAE90 FOREIGN KEY (mission_id) REFERENCES mission (id)');
        $this->addSql('CREATE INDEX IDX_4B3A04BABE6CAE90 ON planque (mission_id)');
        $this->addSql('ALTER TABLE target ADD mission_id INT NOT NULL');
        $this->addSql('ALTER TABLE target ADD CONSTRAINT FK_466F2FFCBE6CAE90 FOREIGN KEY (mission_id) REFERENCES mission (id)');
        $this->addSql('CREATE INDEX IDX_466F2FFCBE6CAE90 ON target (mission_id)');
    }
}
