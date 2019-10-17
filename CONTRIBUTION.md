# Contribuer au projet

## Récupérer et initialiser le projet
Commencez par récupérer et initialiser le projet en suivant les instructions du README.md.

## Avant de commencer le développement
Trouvez une issue sur laquelle travailler, puis créez une nouvelle branche à partir de votre copie locale que vous
nommerez de cette façon :
``` bash
git checkout -b [numero_issue]/[version_branche]
```
Par exemple, si vous souhaitez travailler sur l'issue #5, alors la commande à exécuter à partir de la branche master
sera :
``` bash
git checkout -b 5/1
```

## Phase de développement
Créez une branche locale à partir de la branche master, que vous nommerez de la façon suivante :  
``` bash
[numero_issue]/[nom_issue]
```
Exemple :
Vous souhaitez travailler sur [cette issue](https://github.com/FloStn/P8/issues/8).  
La branche que vous devez créer doit se nommer :  
``` bash
8/collaborative_instructions_document
```
Une fois le développement terminé, exécutez phpstan pour vérifier qu'il n'y a pas de problème dans le code :
``` bash
./vendor/bin/phpstan analyse src
```
Puis exécutez les tests unitaires :
``` bash
./vendor/bin/simple-phpunit
```
et les tests fonctionnels :
``` bash
./vendor/bin/behat
```
Si tout est bon, vous pouvez exécuter php-cs-fixer pour vérifier que votre code respecte bien les standards de PHP :
``` bash
./vendor/bin/php-cs-fixer fix src
```

## Pull request
Lorsque vous estimez que votre code est prêt à être mis en revue, vous pouvez créer une pull request vers la
branche "preprod".
Elle doit être rédigée en anglais et son contenu doit-être le plus explicite possible :  
→ Si vous utilisez une librairie, expliquez pourquoi ce choix  
→ Expliquez les ajouts/améliorations que vous avez effectué(e)s