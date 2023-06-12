Projet de SAE Base de donnée de film sur serveur 

## Auteurs
- Axel COUDROT coud0011 axel.coudrot@etudiant.univ-reims.fr  
- Ferdi SAHIN sahi0015 ferdi.sahin@etudiant.univ-reims.fr

## Tests
Vous avez dans ce projet cs-fixer qui est installé. 
Voici les scripts que vous pouvez utiliser.
```shell
composer test:cs
```
Pour effectuer les tests de cs-fixer.
```shell
composer fix:cs
```
Pour fixer tous les fichiers du projet selon les règles de cs-fixer.


## Serveur
>Ce projet utilise XAMPP pour pouvoir lancer un serveur local sous apache 2.  
A condition d'avoir installé ce logiciel et de mettre en place la base de 
donnée (script disponible), vous pourrez tester.  
Pour lancer le serveur nous avons mis à votre disposition des scripts :  

Pour lancer sous linux : 
```shell
composer start
```
Pour lancer sous windows :
```shell
composer start:windows
```