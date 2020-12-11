<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201210124742 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE subscription DROP FOREIGN KEY FK_A3C664D39B8CE200');
        $this->addSql('DROP INDEX UNIQ_A3C664D39B8CE200 ON subscription');
        $this->addSql('ALTER TABLE subscription DROP subscription_plan_id, CHANGE user_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE subscription_plan DROP INDEX UNIQ_EA664B639A1887DC, ADD INDEX IDX_EA664B639A1887DC (subscription_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE subscription ADD subscription_plan_id INT NOT NULL, CHANGE user_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE subscription ADD CONSTRAINT FK_A3C664D39B8CE200 FOREIGN KEY (subscription_plan_id) REFERENCES subscription_plan (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A3C664D39B8CE200 ON subscription (subscription_plan_id)');
        $this->addSql('ALTER TABLE subscription_plan DROP INDEX IDX_EA664B639A1887DC, ADD UNIQUE INDEX UNIQ_EA664B639A1887DC (subscription_id)');
    }
}
