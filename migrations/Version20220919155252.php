<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220919155252 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cart_cart_product DROP FOREIGN KEY FK_5E1F5EC31AD5CDBF');
        $this->addSql('ALTER TABLE cart_cart_product DROP FOREIGN KEY FK_5E1F5EC325EE16A8');
        $this->addSql('DROP TABLE cart_cart_product');
        $this->addSql('CREATE FULLTEXT INDEX accessoires_merchandising ON accessoires_merchandising (title)');
        $this->addSql('CREATE FULLTEXT INDEX vetement_merchandising ON vetement_merchandising (title)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cart_cart_product (cart_id INT NOT NULL, cart_product_id INT NOT NULL, INDEX IDX_5E1F5EC325EE16A8 (cart_product_id), INDEX IDX_5E1F5EC31AD5CDBF (cart_id), PRIMARY KEY(cart_id, cart_product_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE cart_cart_product ADD CONSTRAINT FK_5E1F5EC31AD5CDBF FOREIGN KEY (cart_id) REFERENCES cart (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cart_cart_product ADD CONSTRAINT FK_5E1F5EC325EE16A8 FOREIGN KEY (cart_product_id) REFERENCES cart_product (id) ON DELETE CASCADE');
        $this->addSql('DROP INDEX accessoires_merchandising ON accessoires_merchandising');
        $this->addSql('DROP INDEX vetement_merchandising ON vetement_merchandising');
    }
}
