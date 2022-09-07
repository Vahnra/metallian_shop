<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220907091033 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE FULLTEXT INDEX accessoires ON accessoires (title)');
        $this->addSql('CREATE FULLTEXT INDEX bijoux ON bijoux (title)');
        $this->addSql('CREATE FULLTEXT INDEX chaussures ON chaussures (title)');
        $this->addSql('CREATE FULLTEXT INDEX media ON media (title)');
        $this->addSql('CREATE FULLTEXT INDEX vetement ON vetement (title)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX accessoires ON accessoires');
        $this->addSql('DROP INDEX bijoux ON bijoux');
        $this->addSql('DROP INDEX chaussures ON chaussures');
        $this->addSql('DROP INDEX media ON media');
        $this->addSql('DROP INDEX vetement ON vetement');
    }
}
