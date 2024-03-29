<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240328202150 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE accounts (id BIGSERIAL NOT NULL, client_id BIGINT NOT NULL, currency_id BIGINT NOT NULL, amount DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_CAC89EAC19EB6921 ON accounts (client_id)');
        $this->addSql('CREATE INDEX IDX_CAC89EAC38248176 ON accounts (currency_id)');
        $this->addSql('CREATE UNIQUE INDEX account_client_id_currency_id_unique ON accounts (client_id, currency_id)');
        $this->addSql('CREATE TABLE clients (id BIGSERIAL NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON clients (email)');
        $this->addSql('CREATE TABLE currencies (id BIGSERIAL NOT NULL, name VARCHAR(255) NOT NULL, code VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CODE ON currencies (code)');
        $this->addSql('CREATE TABLE currency_rates (id BIGSERIAL NOT NULL, src_id BIGINT NOT NULL, dst_id BIGINT NOT NULL, rate DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_1336A95AFF529AC ON currency_rates (src_id)');
        $this->addSql('CREATE INDEX IDX_1336A95AE1885D19 ON currency_rates (dst_id)');
        $this->addSql('CREATE UNIQUE INDEX currency_rate_src_id_dst_unique ON currency_rates (src_id, dst_id)');
        $this->addSql('ALTER TABLE accounts ADD CONSTRAINT FK_CAC89EAC19EB6921 FOREIGN KEY (client_id) REFERENCES clients (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE accounts ADD CONSTRAINT FK_CAC89EAC38248176 FOREIGN KEY (currency_id) REFERENCES currencies (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE currency_rates ADD CONSTRAINT FK_1336A95AFF529AC FOREIGN KEY (src_id) REFERENCES currencies (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE currency_rates ADD CONSTRAINT FK_1336A95AE1885D19 FOREIGN KEY (dst_id) REFERENCES currencies (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE accounts DROP CONSTRAINT FK_CAC89EAC19EB6921');
        $this->addSql('ALTER TABLE accounts DROP CONSTRAINT FK_CAC89EAC38248176');
        $this->addSql('ALTER TABLE currency_rates DROP CONSTRAINT FK_1336A95AFF529AC');
        $this->addSql('ALTER TABLE currency_rates DROP CONSTRAINT FK_1336A95AE1885D19');
        $this->addSql('DROP TABLE accounts');
        $this->addSql('DROP TABLE clients');
        $this->addSql('DROP TABLE currencies');
        $this->addSql('DROP TABLE currency_rates');
    }
}
