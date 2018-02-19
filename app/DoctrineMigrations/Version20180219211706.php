<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20180219211706 extends AbstractMigration
{
  public function up(Schema $schema) {
    $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
    $this->addSql('CREATE TABLE Flags (id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL, discriminator VARCHAR(20) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
    $this->addSql('CREATE TABLE FlagTranslations (id INT AUTO_INCREMENT NOT NULL, translatable_id BIGINT UNSIGNED DEFAULT NULL, name VARCHAR(128) NOT NULL, locale VARCHAR(255) NOT NULL, INDEX IDX_519E4D052C2AC5D3 (translatable_id), UNIQUE INDEX UK_FlagTranslations_name_locale (name, locale), UNIQUE INDEX FlagTranslations_unique_translation (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
    $this->addSql('CREATE TABLE Items (id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL, product BIGINT UNSIGNED NOT NULL, cost BIGINT UNSIGNED NOT NULL, state BIGINT UNSIGNED NOT NULL, `key` BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid_binary)\', INDEX IDX_20DFC649D34A04AD (product), UNIQUE INDEX UNIQ_20DFC649182694FC (cost), INDEX IDX_20DFC649A393D2FB (state), UNIQUE INDEX UK_Items_key (`key`), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
    $this->addSql('ALTER TABLE FlagTranslations ADD CONSTRAINT FK_519E4D052C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES Flags (id) ON DELETE CASCADE');
    $this->addSql('ALTER TABLE Items ADD CONSTRAINT FK_20DFC649D34A04AD FOREIGN KEY (product) REFERENCES Products (id)');
    $this->addSql('ALTER TABLE Items ADD CONSTRAINT FK_20DFC649182694FC FOREIGN KEY (cost) REFERENCES QuantityScalars (id)');
    $this->addSql('ALTER TABLE Items ADD CONSTRAINT FK_20DFC649A393D2FB FOREIGN KEY (state) REFERENCES Flags (id)');
  }

  public function down(Schema $schema) {
    $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
    $this->addSql('ALTER TABLE FlagTranslations DROP FOREIGN KEY FK_519E4D052C2AC5D3');
    $this->addSql('ALTER TABLE Items DROP FOREIGN KEY FK_20DFC649A393D2FB');
    $this->addSql('DROP TABLE Flags');
    $this->addSql('DROP TABLE FlagTranslations');
    $this->addSql('DROP TABLE Items');
  }

  public function postUp(Schema $schema) {
    {
      $this->connection->insert($prefix.'s', ['id'=>4, 'discriminator'=>'memory', '`key`'=>UUID::create()->toHex()]);
      $this->connection->insert($prefix.'Translations', ['translatable_id'=>4, 'name'=>'DDR1', 'abbreviation'=>'DDR1', 'locale'=>'en_US']);
      $this->connection->insert($prefix.'Translations', ['translatable_id'=>4, 'name'=>'DDR1', 'abbreviation'=>'DDR1', 'locale'=>'en_CA']);
      $this->connection->insert($prefix.'Translations', ['translatable_id'=>4, 'name'=>'DDR1', 'abbreviation'=>'DDR1', 'locale'=>'fr_CA']);
      $this->connection->insert('Memory'.$prefix.'s', ['id'=>4]);      
    }

  }

  private function insertItems(Schema $schema) {

  }

  private function insertScalars(Schema $schema) {

  }

  private function insertUnits(Schema $schema) {

  }

  private function insertStates(Schema $schema) {
    $prefix = 'ProductState';

    $this->connection->insert($prefix.'s', ['id'=>1, 'discriminator'=>'memory', '`key`'=>UUID::create()->toHex()]);
  }
}
