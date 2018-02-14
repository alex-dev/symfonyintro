Install:
  1 - Ouvrer un CLI dans le répertoire racine du projet.
  2 - Exécuter "composer install".
  3 - Configurer le fichier app/config/parameters.yml avec les credentials nécessaires.
      Noter que les credentials présents permettront une connection avec ma DB 420.cstj.qc.ca.
  4 - Si la DB n'est pas déployée, par exemple lors d'un test local, exécuter "php ./bin/console doctrine:migrations:migrate" avec votre serveur MySQL actif.

Ce projet utilise quelques packages composer supplémentaires:
  - KnpLabs/Doctrine-Behavior fournit les traits 'Translatable' et 'Translation' pour internationaliser et localiser efficacement les informations traductibles d'une DB.
  -doctrine/doctrine-migrations-bundle fournit une façon simple de déployer un nouveau schéma ou d'insérer une grande quantité d'enregistrement rapidement.