<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200806110037 extends AbstractMigration {
	public function getDescription() : string {
		return '';
	}

	public function up(Schema $schema) : void {
		// this up() migration is auto-generated, please modify it to your needs
		$this->addSql('ALTER TABLE user ADD name VARCHAR(255) DEFAULT NULL, ADD subscription_status TINYINT(1) DEFAULT NULL, ADD agreement_id VARCHAR(255) DEFAULT NULL, ADD payer_id VARCHAR(255) DEFAULT NULL');
	}

	public function down(Schema $schema) : void {
		// this down() migration is auto-generated, please modify it to your needs
		$this->addSql('ALTER TABLE user DROP name, DROP subscription_status, DROP agreement_id, DROP payer_id');
	}
}
