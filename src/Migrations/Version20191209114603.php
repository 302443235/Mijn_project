<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191209114603 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE lesson ADD id_person_id INT DEFAULT NULL, ADD id_training_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE lesson ADD CONSTRAINT FK_F87474F3A14E0760 FOREIGN KEY (id_person_id) REFERENCES person (id)');
        $this->addSql('ALTER TABLE lesson ADD CONSTRAINT FK_F87474F3A6EF5526 FOREIGN KEY (id_training_id) REFERENCES training (id)');
        $this->addSql('CREATE INDEX IDX_F87474F3A14E0760 ON lesson (id_person_id)');
        $this->addSql('CREATE INDEX IDX_F87474F3A6EF5526 ON lesson (id_training_id)');
        $this->addSql('ALTER TABLE registration ADD id_person_id INT DEFAULT NULL, ADD lesson_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE registration ADD CONSTRAINT FK_62A8A7A7A14E0760 FOREIGN KEY (id_person_id) REFERENCES person (id)');
        $this->addSql('ALTER TABLE registration ADD CONSTRAINT FK_62A8A7A7CDF80196 FOREIGN KEY (lesson_id) REFERENCES lesson (id)');
        $this->addSql('CREATE INDEX IDX_62A8A7A7A14E0760 ON registration (id_person_id)');
        $this->addSql('CREATE INDEX IDX_62A8A7A7CDF80196 ON registration (lesson_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE lesson DROP FOREIGN KEY FK_F87474F3A14E0760');
        $this->addSql('ALTER TABLE lesson DROP FOREIGN KEY FK_F87474F3A6EF5526');
        $this->addSql('DROP INDEX IDX_F87474F3A14E0760 ON lesson');
        $this->addSql('DROP INDEX IDX_F87474F3A6EF5526 ON lesson');
        $this->addSql('ALTER TABLE lesson DROP id_person_id, DROP id_training_id');
        $this->addSql('ALTER TABLE registration DROP FOREIGN KEY FK_62A8A7A7A14E0760');
        $this->addSql('ALTER TABLE registration DROP FOREIGN KEY FK_62A8A7A7CDF80196');
        $this->addSql('DROP INDEX IDX_62A8A7A7A14E0760 ON registration');
        $this->addSql('DROP INDEX IDX_62A8A7A7CDF80196 ON registration');
        $this->addSql('ALTER TABLE registration DROP id_person_id, DROP lesson_id');
    }
}
