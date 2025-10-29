<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20251028185543 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create tables';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE country (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL, tax_percent DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE coupon (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL, type ENUM(\'fixed\', \'percentage\'), discount DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE currency (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL, `precision` TINYINT UNSIGNED NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE payment_provider (id INT AUTO_INCREMENT NOT NULL, alias VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, currency_id INT NOT NULL, title VARCHAR(255) NOT NULL, price NUMERIC(10, 2) NOT NULL, count NUMERIC(10, 0) NOT NULL, INDEX IDX_D34A04AD38248176 (currency_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT product_currency_id_fk FOREIGN KEY (currency_id) REFERENCES currency (id) ON DELETE RESTRICT ON UPDATE CASCADE');
        $this->addSql('ALTER TABLE country ADD UNIQUE INDEX country_code_uq (code)');
        $this->addSql('ALTER TABLE currency ADD UNIQUE INDEX currency_code_uq (code)');
        $this->addSql('ALTER TABLE payment_provider ADD UNIQUE INDEX payment_provider_alias_uq (alias)');
        $this->addSql('ALTER TABLE coupon ADD UNIQUE INDEX coupon_code_uq (code)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY product_currency_id_fk');
        $this->addSql('DROP TABLE country');
        $this->addSql('DROP TABLE coupon');
        $this->addSql('DROP TABLE currency');
        $this->addSql('DROP TABLE payment_provider');
        $this->addSql('DROP TABLE product');
    }
}
