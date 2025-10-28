<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20251028214303 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add initial data';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            "
                insert into currency (id, code, `precision`)
                values (978, 'EUR', 2),
                       (840, 'USD', 2);
                
                insert into product (currency_id, title, price, count)
                values (978, 'Iphone', 100, 10),
                       (978, 'Headphone', 20, 10),
                       (978, 'Case', 10, 10);
                
                insert into country (code, tax_percent)
                values ('DE', 19),
                       ('IT', 22),
                       ('FR', 20),
                       ('GR', 24);
                
                insert into coupon (code, type, discount)
                VALUES ('P6', 'percentage', 6),
                       ('P10', 'percentage', 10),
                       ('P15', 'percentage', 15),
                       ('F5', 'fixed', 5),
                       ('F3', 'fixed', 3),
                       ('F9', 'fixed', 9);
                
                insert into payment_provider (alias)
                VALUES ('paypal'),
                       ('stripe');
        "
        );
    }
}
