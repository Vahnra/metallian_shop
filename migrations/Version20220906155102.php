<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220906155102 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD12469DE2');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD365BF48');
        $this->addSql('ALTER TABLE product_product_type DROP FOREIGN KEY FK_8C9257E314959723');
        $this->addSql('ALTER TABLE product_product_type DROP FOREIGN KEY FK_8C9257E34584665A');
        $this->addSql('ALTER TABLE product_type DROP FOREIGN KEY FK_13675887ADA1FB5');
        $this->addSql('ALTER TABLE product_type DROP FOREIGN KEY FK_1367588498DA827');
        $this->addSql('ALTER TABLE product_type_color DROP FOREIGN KEY FK_FB3D903514959723');
        $this->addSql('ALTER TABLE product_type_color DROP FOREIGN KEY FK_FB3D90357ADA1FB5');
        $this->addSql('ALTER TABLE product_type_size DROP FOREIGN KEY FK_4E6F57EF14959723');
        $this->addSql('ALTER TABLE product_type_size DROP FOREIGN KEY FK_4E6F57EF498DA827');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE product_product_type');
        $this->addSql('DROP TABLE product_type');
        $this->addSql('DROP TABLE product_type_color');
        $this->addSql('DROP TABLE product_type_size');
        $this->addSql('DROP TABLE review');
        $this->addSql('CREATE FULLTEXT INDEX vetement ON vetement (title)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, sous_categorie_id INT DEFAULT NULL, title VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description_long VARCHAR(2550) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, price VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, photo VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, stock VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_D34A04AD365BF48 (sous_categorie_id), INDEX IDX_D34A04AD12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE product_product_type (product_id INT NOT NULL, product_type_id INT NOT NULL, INDEX IDX_8C9257E314959723 (product_type_id), INDEX IDX_8C9257E34584665A (product_id), PRIMARY KEY(product_id, product_type_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE product_type (id INT AUTO_INCREMENT NOT NULL, size_id INT DEFAULT NULL, color_id INT DEFAULT NULL, title VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_1367588498DA827 (size_id), INDEX IDX_13675887ADA1FB5 (color_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE product_type_color (product_type_id INT NOT NULL, color_id INT NOT NULL, INDEX IDX_FB3D903514959723 (product_type_id), INDEX IDX_FB3D90357ADA1FB5 (color_id), PRIMARY KEY(product_type_id, color_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE product_type_size (product_type_id INT NOT NULL, size_id INT NOT NULL, INDEX IDX_4E6F57EF14959723 (product_type_id), INDEX IDX_4E6F57EF498DA827 (size_id), PRIMARY KEY(product_type_id, size_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE review (id INT AUTO_INCREMENT NOT NULL, note INT NOT NULL, comment VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, category VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD12469DE2 FOREIGN KEY (category_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD365BF48 FOREIGN KEY (sous_categorie_id) REFERENCES sous_categorie (id)');
        $this->addSql('ALTER TABLE product_product_type ADD CONSTRAINT FK_8C9257E314959723 FOREIGN KEY (product_type_id) REFERENCES product_type (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_product_type ADD CONSTRAINT FK_8C9257E34584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_type ADD CONSTRAINT FK_13675887ADA1FB5 FOREIGN KEY (color_id) REFERENCES color (id)');
        $this->addSql('ALTER TABLE product_type ADD CONSTRAINT FK_1367588498DA827 FOREIGN KEY (size_id) REFERENCES size (id)');
        $this->addSql('ALTER TABLE product_type_color ADD CONSTRAINT FK_FB3D903514959723 FOREIGN KEY (product_type_id) REFERENCES product_type (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_type_color ADD CONSTRAINT FK_FB3D90357ADA1FB5 FOREIGN KEY (color_id) REFERENCES color (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_type_size ADD CONSTRAINT FK_4E6F57EF14959723 FOREIGN KEY (product_type_id) REFERENCES product_type (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_type_size ADD CONSTRAINT FK_4E6F57EF498DA827 FOREIGN KEY (size_id) REFERENCES size (id) ON DELETE CASCADE');
        $this->addSql('DROP INDEX vetement ON vetement');
    }
}
