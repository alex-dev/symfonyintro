Utilisateurs:
  * administrator; 12345;
  * aparent; 12345;
  * amartel; 12345;

Installation:
  1. Ouvrir un CLI dans le répertoire racine du projet.
  2. Exécuter "composer install".
  3. Configurer le fichier app/config/parameters.yml avec les credentials nécessaires.
      Noter que les credentials présents permettront une connection avec ma DB sur le 420.cstj.qc.ca.
  4. Si la DB n'est pas déployée, par exemple lors d'un test local, exécuter "php ./bin/console doctrine:migrations:migrate" avec votre serveur MySQL actif.
  5. Exécuter "php ./bin/console app:update-currencies".

Test des cartes de crédits: [les cartes de tests supportés par stripes sont toutes ici](https://stripe.com/docs/testing)

Ce projet utilise quelques packages composer supplémentaires:
  * FriendsOfSymfony/user-bundle fournit l'ensemble de ma sécurité et la majorité de ma gestion utilisateur.
  * KnpLabs/doctrine-behaviors fournit les traits 'Translatable' et 'Translation' pour internationaliser et localiser efficacement les informations traductibles d'une DB.
  * doctrine/doctrine-migrations-bundle fournit une façon simple de déployer un nouveau schéma ou d'insérer une grande quantité d'enregistrement rapidement.
  * Stripe/Stripe-PHP intègre les services Stripe à mon backend.
  * GuzzleHttp/Guzzle offre un API efficace pour une gestion asynchrone des communications HTTP.
  * MyCLabs/php-enum backport les Enums de l'extension SPL de PHP 7.

Problèmes connus:
  * Les marques d'un même manufacturier ne sont pas encore supportées.
  * Les couleurs de mémoires ne sont pas encore supportées.
  * De nombreux types de produits sont manquant.
  * Ce projet utilise présentement Seiyria/bootstrap-slider pour implémenter mes min-max sliders. Ils ne fonctionnent pas comme désirés (pas de tooltips), donc je les changerai dans une prochaine itération pour http://demos.jquerymobile.com/1.3.2/widgets/sliders/rangeslider.html.
  * La DB est appellé trop souvent par Doctrine, les stratégies d'"hydration" ne sont donc pas optimisées.
  * Il faut terminer les repository....
  * Product modal affiche un carousel trop petit sur tous les écrans md+.
  * Les conversions de monnaies ne sont pas fonctionnelles. Toutes les monnaies affichées sont des CAD.
  * Les unités ne sont pas correctement formattées dans certains cas (en_US => USD$10)
  * Loader sur le popup n'est pas centré.
  * L'ensemble des entités / modèles doit être retravaillé.
  * <form> should use <button type="submit">
  * Le backdrop dans les modals empilés ne se comporte pas comme il le devrait.
  * order-summary.html.twig n'est pas traduit.
  * Les champs de la table du panier sont trop petits.
  * Address n'est pas normalisée et plutôt mal traduite.
  * Les numéros de téléphone ne sont pas formattés.
  * Les traductions sont passablement manquantes dans les dernières itérations.
  * Sur la page des manufacturiers, l'édition force qu'il n'y aie qu'une seule valeur, et dans la DB, et dans le formulaire pour un id. Comme les update/insert sont faits séquentiellement le 'swap' de deux valeurs va provoquer une erreur SQL.
