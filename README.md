Original repository : [fulll/hiring](https://github.com/fulll/hiring).

Hello, I'm **Jeremy Rossignol** and these are my answers to the technical tests of [Fulll](https://www.fulll.fr). 
I hope you'll have a good time reading all of this !
---

# Algo
[Instructions](https://github.com/JeremyRossignol/fulll/blob/master/Algo/fizzbuzz.md)

Answers of the classical FizzBuzz test can be found [here](https://github.com/JeremyRossignol/fulll/tree/master/Algo)
You can test it by running [this](https://github.com/JeremyRossignol/fulll/blob/master/Algo/fizzbuzz.test.php) in php cmd line.

# Backend
[Instructions](https://github.com/JeremyRossignol/fulll/blob/master/Backend/ddd-and-cqrs-intermediare-senior.md)

## Part 1
Answers of the behat tests for a Fleet of Vehicles management can be found [here](https://github.com/JeremyRossignol/fulll/tree/master/Backend/PHP/Boilerplate).
It may easier to see the part 1 answers (without part 2 files) looking at the [Algo + Backend part 1](https://github.com/JeremyRossignol/fulll/releases/tag/Backend1) release.

## Part 2
Answers of the command-line for database persisting of a Fleet of Vehicles management can be found [here](https://github.com/JeremyRossignol/fulll/tree/master/Backend/PHP/Boilerplate).
Here i installed with [composer](https://getcomposer.org) and used [Symfony Flex Component](https://symfony.com/components/Symfony%20Flex) in order to use [The Symfony Maker Bundle](https://symfony.com/bundles/SymfonyMakerBundle/current/index.html) with [Doctrine ORM](https://symfony.com/doc/current/doctrine.html) and also [Symfony Console Commands](https://symfony.com/doc/current/console.html).
These dependencies helped me to generate object relationnal mapping (ORM) with **Entities** (which can be found [here](https://github.com/JeremyRossignol/fulll/tree/master/Backend/PHP/Boilerplate/src/Entity)) and **Commands** (which can be found [here](https://github.com/JeremyRossignol/fulll/tree/master/Backend/PHP/Boilerplate/src/Command))

The database persisting was tested with a [MySQL](https://www.mysql.com/) Database.

Here is how you call the **Commands** :

```cmd
php bin/console fleet <action> <param1> (param2) (param3)
```
or
```cmd
php bin/console fleet:<action> <param1> (param2) (param3)
```
Here is the list of actions with the associated parameters :
```
create <userId>
create-user <name>
create-vehicle <plateNumber>
create-location <latitude> <longitude>
register-vehicle <fleetId> <vehiclePlateNumber>
park-vehicle <fleetId> <vehiclePlateNumber> <locationId>
localize-vehicle <fleetId> <vehiclePlateNumber>
```

An alias can be created on the server to respond the exact call demand (```./fleet``` instead of ```php bin/console fleet``` or ```symfony fleet``` (if Symfony is installed on the server)).

## Part 3
Here below are my answers to the questions :

#### For code quality, you can use some tools : which one and why (in a few words) ?
In the first place i use [VSCode](https://code.visualstudio.com) as IDE. I think it's a great and personnalizable tool.
On the code quality side it helps me by auto-formatting my code, pre-testing it and integrating versionning via github. 
It can also run and debug (with variables spies, breakpoint etc...) my files or even debug when called by web (all via [xdebug](https://xdebug.org/))
It also contains a cmd console so i can run lint commands like php -l on my files.
In my carrier i used [PHP-CS-Fixer](https://github.com/PHP-CS-Fixer/PHP-CS-Fixer) mainlyfor php version upgrades (but can also be use for linting). 
And i am currently looking to use 
- [pfff](https://github.com/facebookarchive/pfff) 
   for linting and code mapping purposes
- and [nuclei](https://github.com/projectdiscovery/nuclei)
   for security purposes.
Testing the code with [behat](https://docs.behat.org/en/latest/) or [PHP Unit](https://phpunit.de/index.html) is really good in order to avoid features regression.

#### you can consider to setup a ci/cd process : describe the necessary actions in a few words

Versioning is mandatory and the base of the setup.

We could see a solution like this :
- Dev repository
   - A **master** branch and multiple **dev** branches. The **dev** branches are used for developpement. Every dev branch is for one feature or issue and every feature must have unit test. Only when the feature/issue passed unit tests and is finished we can merge it to **master**
   - The merges must be supervised by at least 2 different people that reviews the code.
- Production repository
   - Everything on **master** branch of the Dev repository is deployed on a **pre-prod** branch :
      - All the unit tests are OK
      - Linting tools reviewed the code and checked if everything is ok (from formatting, to vulnerabilities check or even optimize code and stantardise it)
   - On the **pre-prod** branch we need testers to do all functionnals tests. If everything is ok we can backup BDD and deploy the branch on **master** of the Prod repository and mark it as a new version.

If a problem is detected late the rollback is easy with a versioning system. That's why i find it really secure.

