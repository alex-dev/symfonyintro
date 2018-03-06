Install:
  1 - Ouvrir un CLI dans le répertoire racine du projet.
  2 - Exécuter "composer install".
  3 - Configurer le fichier app/config/parameters.yml avec les credentials nécessaires.
      Noter que les credentials présents permettront une connection avec ma DB sur le 420.cstj.qc.ca.
  4 - Si la DB n'est pas déployée, par exemple lors d'un test local, exécuter "php ./bin/console doctrine:migrations:migrate" avec votre serveur MySQL actif.

Ce projet utilise quelques packages composer supplémentaires:
  - KnpLabs/doctrine-behaviors fournit les traits 'Translatable' et 'Translation' pour internationaliser et localiser efficacement les informations traductibles d'une DB.
  - doctrine/doctrine-migrations-bundle fournit une façon simple de déployer un nouveau schéma ou d'insérer une grande quantité d'enregistrement rapidement.
  - GuzzleHttp/Guzzle offre un API efficace pour une gestion asynchrone des communications HTTP.

Problèmes connus:
  - Les marques d'un même manufacturier ne sont pas encore supportées.
  - Les couleurs de mémoires ne sont pas encore supportées.
  - De nombreux types de produits sont manquant.
  - Ce projet utilise présentement Seiyria/bootstrap-slider pour implémenter mes min-max sliders. Ils ne fonctionnent pas comme désirés (pas de tooltips), donc je les changerai dans une prochaine itération pour http://demos.jquerymobile.com/1.3.2/widgets/sliders/rangeslider.html.
  - La DB est appellé trop souvent par Doctrine, les stratégies d'"hydration" ne sont donc pas optimisées.
  - Il faut terminer les repository....
  - Product modal affiche un carousel trop petit sur tous les écrans md+.
  - Les conversions de monnaies ne sont pas fonctionnelles. Toutes les monnaies affichées sont des CAD.
  - Les unités ne sont pas correctement formattées dans certains cas (en_US => USD$10)
  - Loader sur le popup n'est pas centré.
  - La traduction est temporairement inutilisable dû à un problème de redirection. Usage du dropdown va causer un 500. Un reload va reloader la page dans la locale demandée.
  - L'ensemble des entités / modèles doit être retravaillé.
  - <form> should use <button type="submit">