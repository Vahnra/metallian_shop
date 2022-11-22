<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221122145406 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE accessoires DROP FOREIGN KEY FK_B661BA4FE308AC6F');
        $this->addSql('ALTER TABLE accessoires DROP FOREIGN KEY FK_B661BA4F365BF48');
        $this->addSql('ALTER TABLE accessoires DROP FOREIGN KEY FK_B661BA4FBCF5E72D');
        $this->addSql('ALTER TABLE accessoires_merchandising DROP FOREIGN KEY FK_7A2C2B35B7970CF8');
        $this->addSql('ALTER TABLE accessoires_merchandising DROP FOREIGN KEY FK_7A2C2B35710B2967');
        $this->addSql('ALTER TABLE accessoires_merchandising DROP FOREIGN KEY FK_7A2C2B35E308AC6F');
        $this->addSql('ALTER TABLE accessoires_merchandising DROP FOREIGN KEY FK_7A2C2B358A502466');
        $this->addSql('ALTER TABLE accessoires_merchandising_quantity DROP FOREIGN KEY FK_D32DD584498DA827');
        $this->addSql('ALTER TABLE accessoires_merchandising_quantity DROP FOREIGN KEY FK_D32DD5847ADA1FB5');
        $this->addSql('ALTER TABLE accessoires_merchandising_quantity DROP FOREIGN KEY FK_D32DD5844973BB');
        $this->addSql('ALTER TABLE accessoires_quantity DROP FOREIGN KEY FK_167CE2D6498DA827');
        $this->addSql('ALTER TABLE accessoires_quantity DROP FOREIGN KEY FK_167CE2D67ADA1FB5');
        $this->addSql('ALTER TABLE accessoires_quantity DROP FOREIGN KEY FK_167CE2D639181887');
        $this->addSql('ALTER TABLE bijoux DROP FOREIGN KEY FK_7B5AF509BCF5E72D');
        $this->addSql('ALTER TABLE bijoux DROP FOREIGN KEY FK_7B5AF509365BF48');
        $this->addSql('ALTER TABLE bijoux_quantity DROP FOREIGN KEY FK_4C5BB4D87ADA1FB5');
        $this->addSql('ALTER TABLE bijoux_quantity DROP FOREIGN KEY FK_4C5BB4D88BE553D6');
        $this->addSql('ALTER TABLE chaussures DROP FOREIGN KEY FK_75261D94365BF48');
        $this->addSql('ALTER TABLE chaussures DROP FOREIGN KEY FK_75261D94BCF5E72D');
        $this->addSql('ALTER TABLE chaussures DROP FOREIGN KEY FK_75261D94E308AC6F');
        $this->addSql('ALTER TABLE chaussures_quantity DROP FOREIGN KEY FK_3676F44A498DA827');
        $this->addSql('ALTER TABLE chaussures_quantity DROP FOREIGN KEY FK_3676F44A7ADA1FB5');
        $this->addSql('ALTER TABLE chaussures_quantity DROP FOREIGN KEY FK_3676F44AB13A3C88');
        $this->addSql('ALTER TABLE media DROP FOREIGN KEY FK_6A2CA10CB7970CF8');
        $this->addSql('ALTER TABLE media DROP FOREIGN KEY FK_6A2CA10C365BF48');
        $this->addSql('ALTER TABLE media DROP FOREIGN KEY FK_6A2CA10CBCF5E72D');
        $this->addSql('ALTER TABLE media DROP FOREIGN KEY FK_6A2CA10C4296D31F');
        $this->addSql('ALTER TABLE media_quantity DROP FOREIGN KEY FK_90923884EA9FDD75');
        $this->addSql('ALTER TABLE review_media DROP FOREIGN KEY FK_79A28D17A76ED395');
        $this->addSql('ALTER TABLE review_media DROP FOREIGN KEY FK_79A28D17EA9FDD75');
        $this->addSql('ALTER TABLE review_vetement DROP FOREIGN KEY FK_1FF6CFC4A76ED395');
        $this->addSql('ALTER TABLE review_vetement DROP FOREIGN KEY FK_1FF6CFC4969D8B67');
        $this->addSql('ALTER TABLE vetement DROP FOREIGN KEY FK_3CB446CFE308AC6F');
        $this->addSql('ALTER TABLE vetement DROP FOREIGN KEY FK_3CB446CFBCF5E72D');
        $this->addSql('ALTER TABLE vetement DROP FOREIGN KEY FK_3CB446CF365BF48');
        $this->addSql('ALTER TABLE vetement DROP FOREIGN KEY FK_3CB446CFC256483C');
        $this->addSql('ALTER TABLE vetement DROP FOREIGN KEY FK_3CB446CFB7970CF8');
        $this->addSql('ALTER TABLE vetement_merchandising DROP FOREIGN KEY FK_282A0B58B7970CF8');
        $this->addSql('ALTER TABLE vetement_merchandising DROP FOREIGN KEY FK_282A0B58710B2967');
        $this->addSql('ALTER TABLE vetement_merchandising DROP FOREIGN KEY FK_282A0B58C256483C');
        $this->addSql('ALTER TABLE vetement_merchandising DROP FOREIGN KEY FK_282A0B588A502466');
        $this->addSql('ALTER TABLE vetement_merchandising DROP FOREIGN KEY FK_282A0B58E308AC6F');
        $this->addSql('ALTER TABLE vetement_merchandising_quantity DROP FOREIGN KEY FK_A5E14DE73CA1AA0D');
        $this->addSql('ALTER TABLE vetement_merchandising_quantity DROP FOREIGN KEY FK_A5E14DE7498DA827');
        $this->addSql('ALTER TABLE vetement_merchandising_quantity DROP FOREIGN KEY FK_A5E14DE77ADA1FB5');
        $this->addSql('ALTER TABLE vetement_quantity DROP FOREIGN KEY FK_9E3DF8C0498DA827');
        $this->addSql('ALTER TABLE vetement_quantity DROP FOREIGN KEY FK_9E3DF8C07ADA1FB5');
        $this->addSql('ALTER TABLE vetement_quantity DROP FOREIGN KEY FK_9E3DF8C0969D8B67');
        $this->addSql('DROP TABLE accessoires');
        $this->addSql('DROP TABLE accessoires_merchandising');
        $this->addSql('DROP TABLE accessoires_merchandising_quantity');
        $this->addSql('DROP TABLE accessoires_quantity');
        $this->addSql('DROP TABLE bijoux');
        $this->addSql('DROP TABLE bijoux_quantity');
        $this->addSql('DROP TABLE chaussures');
        $this->addSql('DROP TABLE chaussures_quantity');
        $this->addSql('DROP TABLE media');
        $this->addSql('DROP TABLE media_quantity');
        $this->addSql('DROP TABLE review_media');
        $this->addSql('DROP TABLE review_vetement');
        $this->addSql('DROP TABLE vetement');
        $this->addSql('DROP TABLE vetement_merchandising');
        $this->addSql('DROP TABLE vetement_merchandising_quantity');
        $this->addSql('DROP TABLE vetement_quantity');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE accessoires (id INT AUTO_INCREMENT NOT NULL, categorie_id INT DEFAULT NULL, sous_categorie_id INT DEFAULT NULL, material_id INT DEFAULT NULL, title VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, photo VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, long_description LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, photo2 VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, photo3 VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, photo4 VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, photo5 VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, price INT NOT NULL, FULLTEXT INDEX accessoires (title), INDEX IDX_B661BA4F365BF48 (sous_categorie_id), INDEX IDX_B661BA4FE308AC6F (material_id), INDEX IDX_B661BA4FBCF5E72D (categorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE accessoires_merchandising (id INT AUTO_INCREMENT NOT NULL, categorie_merchandising_id INT DEFAULT NULL, sous_categorie_merchandising_id INT DEFAULT NULL, material_id INT DEFAULT NULL, artist_id INT DEFAULT NULL, title VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, price INT NOT NULL, photo VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, long_description LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, photo2 VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, photo3 VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, photo4 VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, photo5 VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_7A2C2B35710B2967 (categorie_merchandising_id), INDEX IDX_7A2C2B35E308AC6F (material_id), FULLTEXT INDEX accessoires_merchandising (title), INDEX IDX_7A2C2B358A502466 (sous_categorie_merchandising_id), INDEX IDX_7A2C2B35B7970CF8 (artist_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE accessoires_merchandising_quantity (id INT AUTO_INCREMENT NOT NULL, accessoires_merchandising_id INT NOT NULL, color_id INT NOT NULL, size_id INT NOT NULL, stock VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, sku VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_D32DD5844973BB (accessoires_merchandising_id), INDEX IDX_D32DD584498DA827 (size_id), INDEX IDX_D32DD5847ADA1FB5 (color_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE accessoires_quantity (id INT AUTO_INCREMENT NOT NULL, accessoires_id INT NOT NULL, color_id INT NOT NULL, size_id INT NOT NULL, stock VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, sku VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_167CE2D639181887 (accessoires_id), INDEX IDX_167CE2D6498DA827 (size_id), INDEX IDX_167CE2D67ADA1FB5 (color_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE bijoux (id INT AUTO_INCREMENT NOT NULL, categorie_id INT DEFAULT NULL, sous_categorie_id INT DEFAULT NULL, title VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, price INT NOT NULL, photo VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, photo2 VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, photo3 VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, photo4 VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, photo5 VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, long_description LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_7B5AF509365BF48 (sous_categorie_id), INDEX IDX_7B5AF509BCF5E72D (categorie_id), FULLTEXT INDEX bijoux (title), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE bijoux_quantity (id INT AUTO_INCREMENT NOT NULL, bijoux_id INT NOT NULL, color_id INT NOT NULL, stock VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, sku VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_4C5BB4D87ADA1FB5 (color_id), INDEX IDX_4C5BB4D88BE553D6 (bijoux_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE chaussures (id INT AUTO_INCREMENT NOT NULL, categorie_id INT DEFAULT NULL, sous_categorie_id INT DEFAULT NULL, material_id INT DEFAULT NULL, title VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, price INT NOT NULL, photo VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, long_description LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, photo2 VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, photo3 VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, photo4 VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, photo5 VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, FULLTEXT INDEX chaussures (title), INDEX IDX_75261D94365BF48 (sous_categorie_id), INDEX IDX_75261D94E308AC6F (material_id), INDEX IDX_75261D94BCF5E72D (categorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE chaussures_quantity (id INT AUTO_INCREMENT NOT NULL, chaussures_id INT NOT NULL, color_id INT NOT NULL, size_id INT NOT NULL, stock VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, sku VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_3676F44AB13A3C88 (chaussures_id), INDEX IDX_3676F44A498DA827 (size_id), INDEX IDX_3676F44A7ADA1FB5 (color_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE media (id INT AUTO_INCREMENT NOT NULL, categorie_id INT DEFAULT NULL, sous_categorie_id INT DEFAULT NULL, artist_id INT DEFAULT NULL, genre_id INT DEFAULT NULL, title VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, price INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, description VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, long_description LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, release_date VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, photo VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, photo2 VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, photo3 VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, photo4 VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_6A2CA10CBCF5E72D (categorie_id), INDEX IDX_6A2CA10CB7970CF8 (artist_id), FULLTEXT INDEX media (title), INDEX IDX_6A2CA10C365BF48 (sous_categorie_id), INDEX IDX_6A2CA10C4296D31F (genre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE media_quantity (id INT AUTO_INCREMENT NOT NULL, media_id INT NOT NULL, stock VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, sku VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_90923884EA9FDD75 (media_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE review_media (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, media_id INT DEFAULT NULL, note INT NOT NULL, comment VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_79A28D17A76ED395 (user_id), INDEX IDX_79A28D17EA9FDD75 (media_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE review_vetement (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, vetement_id INT DEFAULT NULL, note INT NOT NULL, comment VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_1FF6CFC4969D8B67 (vetement_id), INDEX IDX_1FF6CFC4A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE vetement (id INT AUTO_INCREMENT NOT NULL, categorie_id INT DEFAULT NULL, sous_categorie_id INT DEFAULT NULL, marques_id INT DEFAULT NULL, material_id INT DEFAULT NULL, artist_id INT DEFAULT NULL, title VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, photo VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, price INT NOT NULL, long_description LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, photo2 VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, photo3 VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, photo4 VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, photo5 VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_3CB446CFC256483C (marques_id), INDEX IDX_3CB446CFB7970CF8 (artist_id), INDEX IDX_3CB446CFBCF5E72D (categorie_id), INDEX IDX_3CB446CFE308AC6F (material_id), FULLTEXT INDEX vetement (title), INDEX IDX_3CB446CF365BF48 (sous_categorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE vetement_merchandising (id INT AUTO_INCREMENT NOT NULL, categorie_merchandising_id INT DEFAULT NULL, sous_categorie_merchandising_id INT DEFAULT NULL, marques_id INT DEFAULT NULL, material_id INT DEFAULT NULL, artist_id INT DEFAULT NULL, title VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, photo VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, price INT NOT NULL, long_description LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, photo2 VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, photo3 VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, photo4 VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, photo5 VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_282A0B588A502466 (sous_categorie_merchandising_id), INDEX IDX_282A0B58E308AC6F (material_id), FULLTEXT INDEX vetement_merchandising (title), INDEX IDX_282A0B58710B2967 (categorie_merchandising_id), INDEX IDX_282A0B58C256483C (marques_id), INDEX IDX_282A0B58B7970CF8 (artist_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE vetement_merchandising_quantity (id INT AUTO_INCREMENT NOT NULL, vetement_merchandising_id INT NOT NULL, color_id INT NOT NULL, size_id INT NOT NULL, stock VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, sku VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_A5E14DE73CA1AA0D (vetement_merchandising_id), INDEX IDX_A5E14DE7498DA827 (size_id), INDEX IDX_A5E14DE77ADA1FB5 (color_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE vetement_quantity (id INT AUTO_INCREMENT NOT NULL, vetement_id INT NOT NULL, color_id INT NOT NULL, size_id INT NOT NULL, stock VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, sku VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_9E3DF8C0969D8B67 (vetement_id), INDEX IDX_9E3DF8C0498DA827 (size_id), INDEX IDX_9E3DF8C07ADA1FB5 (color_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE accessoires ADD CONSTRAINT FK_B661BA4FE308AC6F FOREIGN KEY (material_id) REFERENCES material (id)');
        $this->addSql('ALTER TABLE accessoires ADD CONSTRAINT FK_B661BA4F365BF48 FOREIGN KEY (sous_categorie_id) REFERENCES sous_categorie (id)');
        $this->addSql('ALTER TABLE accessoires ADD CONSTRAINT FK_B661BA4FBCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE accessoires_merchandising ADD CONSTRAINT FK_7A2C2B35B7970CF8 FOREIGN KEY (artist_id) REFERENCES artist (id)');
        $this->addSql('ALTER TABLE accessoires_merchandising ADD CONSTRAINT FK_7A2C2B35710B2967 FOREIGN KEY (categorie_merchandising_id) REFERENCES categorie_merchandising (id)');
        $this->addSql('ALTER TABLE accessoires_merchandising ADD CONSTRAINT FK_7A2C2B35E308AC6F FOREIGN KEY (material_id) REFERENCES material (id)');
        $this->addSql('ALTER TABLE accessoires_merchandising ADD CONSTRAINT FK_7A2C2B358A502466 FOREIGN KEY (sous_categorie_merchandising_id) REFERENCES sous_categorie_merchandising (id)');
        $this->addSql('ALTER TABLE accessoires_merchandising_quantity ADD CONSTRAINT FK_D32DD584498DA827 FOREIGN KEY (size_id) REFERENCES size (id)');
        $this->addSql('ALTER TABLE accessoires_merchandising_quantity ADD CONSTRAINT FK_D32DD5847ADA1FB5 FOREIGN KEY (color_id) REFERENCES color (id)');
        $this->addSql('ALTER TABLE accessoires_merchandising_quantity ADD CONSTRAINT FK_D32DD5844973BB FOREIGN KEY (accessoires_merchandising_id) REFERENCES accessoires_merchandising (id)');
        $this->addSql('ALTER TABLE accessoires_quantity ADD CONSTRAINT FK_167CE2D6498DA827 FOREIGN KEY (size_id) REFERENCES size (id)');
        $this->addSql('ALTER TABLE accessoires_quantity ADD CONSTRAINT FK_167CE2D67ADA1FB5 FOREIGN KEY (color_id) REFERENCES color (id)');
        $this->addSql('ALTER TABLE accessoires_quantity ADD CONSTRAINT FK_167CE2D639181887 FOREIGN KEY (accessoires_id) REFERENCES accessoires (id)');
        $this->addSql('ALTER TABLE bijoux ADD CONSTRAINT FK_7B5AF509BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE bijoux ADD CONSTRAINT FK_7B5AF509365BF48 FOREIGN KEY (sous_categorie_id) REFERENCES sous_categorie (id)');
        $this->addSql('ALTER TABLE bijoux_quantity ADD CONSTRAINT FK_4C5BB4D87ADA1FB5 FOREIGN KEY (color_id) REFERENCES color (id)');
        $this->addSql('ALTER TABLE bijoux_quantity ADD CONSTRAINT FK_4C5BB4D88BE553D6 FOREIGN KEY (bijoux_id) REFERENCES bijoux (id)');
        $this->addSql('ALTER TABLE chaussures ADD CONSTRAINT FK_75261D94365BF48 FOREIGN KEY (sous_categorie_id) REFERENCES sous_categorie (id)');
        $this->addSql('ALTER TABLE chaussures ADD CONSTRAINT FK_75261D94BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE chaussures ADD CONSTRAINT FK_75261D94E308AC6F FOREIGN KEY (material_id) REFERENCES material (id)');
        $this->addSql('ALTER TABLE chaussures_quantity ADD CONSTRAINT FK_3676F44A498DA827 FOREIGN KEY (size_id) REFERENCES size (id)');
        $this->addSql('ALTER TABLE chaussures_quantity ADD CONSTRAINT FK_3676F44A7ADA1FB5 FOREIGN KEY (color_id) REFERENCES color (id)');
        $this->addSql('ALTER TABLE chaussures_quantity ADD CONSTRAINT FK_3676F44AB13A3C88 FOREIGN KEY (chaussures_id) REFERENCES chaussures (id)');
        $this->addSql('ALTER TABLE media ADD CONSTRAINT FK_6A2CA10CB7970CF8 FOREIGN KEY (artist_id) REFERENCES artist (id)');
        $this->addSql('ALTER TABLE media ADD CONSTRAINT FK_6A2CA10C365BF48 FOREIGN KEY (sous_categorie_id) REFERENCES sous_categorie (id)');
        $this->addSql('ALTER TABLE media ADD CONSTRAINT FK_6A2CA10CBCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE media ADD CONSTRAINT FK_6A2CA10C4296D31F FOREIGN KEY (genre_id) REFERENCES music_type (id)');
        $this->addSql('ALTER TABLE media_quantity ADD CONSTRAINT FK_90923884EA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id)');
        $this->addSql('ALTER TABLE review_media ADD CONSTRAINT FK_79A28D17A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE review_media ADD CONSTRAINT FK_79A28D17EA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id)');
        $this->addSql('ALTER TABLE review_vetement ADD CONSTRAINT FK_1FF6CFC4A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE review_vetement ADD CONSTRAINT FK_1FF6CFC4969D8B67 FOREIGN KEY (vetement_id) REFERENCES vetement (id)');
        $this->addSql('ALTER TABLE vetement ADD CONSTRAINT FK_3CB446CFE308AC6F FOREIGN KEY (material_id) REFERENCES material (id)');
        $this->addSql('ALTER TABLE vetement ADD CONSTRAINT FK_3CB446CFBCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE vetement ADD CONSTRAINT FK_3CB446CF365BF48 FOREIGN KEY (sous_categorie_id) REFERENCES sous_categorie (id)');
        $this->addSql('ALTER TABLE vetement ADD CONSTRAINT FK_3CB446CFC256483C FOREIGN KEY (marques_id) REFERENCES marques (id)');
        $this->addSql('ALTER TABLE vetement ADD CONSTRAINT FK_3CB446CFB7970CF8 FOREIGN KEY (artist_id) REFERENCES artist (id)');
        $this->addSql('ALTER TABLE vetement_merchandising ADD CONSTRAINT FK_282A0B58B7970CF8 FOREIGN KEY (artist_id) REFERENCES artist (id)');
        $this->addSql('ALTER TABLE vetement_merchandising ADD CONSTRAINT FK_282A0B58710B2967 FOREIGN KEY (categorie_merchandising_id) REFERENCES categorie_merchandising (id)');
        $this->addSql('ALTER TABLE vetement_merchandising ADD CONSTRAINT FK_282A0B58C256483C FOREIGN KEY (marques_id) REFERENCES marques (id)');
        $this->addSql('ALTER TABLE vetement_merchandising ADD CONSTRAINT FK_282A0B588A502466 FOREIGN KEY (sous_categorie_merchandising_id) REFERENCES sous_categorie_merchandising (id)');
        $this->addSql('ALTER TABLE vetement_merchandising ADD CONSTRAINT FK_282A0B58E308AC6F FOREIGN KEY (material_id) REFERENCES material (id)');
        $this->addSql('ALTER TABLE vetement_merchandising_quantity ADD CONSTRAINT FK_A5E14DE73CA1AA0D FOREIGN KEY (vetement_merchandising_id) REFERENCES vetement_merchandising (id)');
        $this->addSql('ALTER TABLE vetement_merchandising_quantity ADD CONSTRAINT FK_A5E14DE7498DA827 FOREIGN KEY (size_id) REFERENCES size (id)');
        $this->addSql('ALTER TABLE vetement_merchandising_quantity ADD CONSTRAINT FK_A5E14DE77ADA1FB5 FOREIGN KEY (color_id) REFERENCES color (id)');
        $this->addSql('ALTER TABLE vetement_quantity ADD CONSTRAINT FK_9E3DF8C0498DA827 FOREIGN KEY (size_id) REFERENCES size (id)');
        $this->addSql('ALTER TABLE vetement_quantity ADD CONSTRAINT FK_9E3DF8C07ADA1FB5 FOREIGN KEY (color_id) REFERENCES color (id)');
        $this->addSql('ALTER TABLE vetement_quantity ADD CONSTRAINT FK_9E3DF8C0969D8B67 FOREIGN KEY (vetement_id) REFERENCES vetement (id)');
    }
}
