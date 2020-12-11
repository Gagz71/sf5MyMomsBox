<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201209185822 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE subscription DROP FOREIGN KEY FK_A3C664D39B8CE200');
        $this->addSql('DROP INDEX IDX_A3C664D39B8CE200 ON subscription');
        $this->addSql('ALTER TABLE subscription DROP subscription_plan_id');
        $this->addSql('ALTER TABLE subscription_plan ADD subscriptions_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE subscription_plan ADD CONSTRAINT FK_EA664B63688E3B5D FOREIGN KEY (subscriptions_id) REFERENCES subscription (id)');
        $this->addSql('CREATE INDEX IDX_EA664B63688E3B5D ON subscription_plan (subscriptions_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE subscription ADD subscription_plan_id INT NOT NULL');
        $this->addSql('ALTER TABLE subscription ADD CONSTRAINT FK_A3C664D39B8CE200 FOREIGN KEY (subscription_plan_id) REFERENCES subscription_plan (id)');
        $this->addSql('CREATE INDEX IDX_A3C664D39B8CE200 ON subscription (subscription_plan_id)');
        $this->addSql('ALTER TABLE subscription_plan DROP FOREIGN KEY FK_EA664B63688E3B5D');
        $this->addSql('DROP INDEX IDX_EA664B63688E3B5D ON subscription_plan');
        $this->addSql('ALTER TABLE subscription_plan DROP subscriptions_id');
    }
}
