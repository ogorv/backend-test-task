<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20251029080046 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add purchase table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            "CREATE TABLE purchase
                (
                    id                  BIGINT UNSIGNED AUTO_INCREMENT NOT NULL,
                    product_id          INT                            NOT NULL,
                    tax_number          VARCHAR(255)                   NOT NULL,
                    payment_provider_id INT                            NOT NULL,
                    status              ENUM ('new', 'paid'),
                    price               DOUBLE PRECISION               NOT NULL,
                    PRIMARY KEY (id)
                ) DEFAULT CHARACTER SET utf8mb4
                  COLLATE `utf8mb4_unicode_ci`
                  ENGINE = InnoDB;
                
                ALTER TABLE purchase
                    ADD INDEX purchase_product_id_ix (product_id);
                ALTER TABLE purchase
                    ADD INDEX purchase_payment_provider_id_ix (payment_provider_id);
                
                ALTER TABLE purchase
                    ADD CONSTRAINT purchase_product_id_fk FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE RESTRICT ON UPDATE CASCADE;
                
                ALTER TABLE purchase
                    ADD CONSTRAINT purchase_payment_provider_id_fk FOREIGN KEY (payment_provider_id) REFERENCES payment_provider (id) ON DELETE RESTRICT ON UPDATE CASCADE;"
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE purchase DROP FOREIGN KEY purchase_product_id_fk');
        $this->addSql('ALTER TABLE purchase DROP FOREIGN KEY purchase_payment_provider_id_fk');
        $this->addSql('DROP TABLE purchase');
    }
}
