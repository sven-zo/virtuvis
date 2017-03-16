# VirtuVis

A project for school in which we (Sven, Imani, Budi and Emma) are making a virtual fishing application that is meant to be projected at a floor.

----------
##VirtuVis (web)app
This is the mobile app for the VirtuVis game.

Folder: `../app`

**How to access:**

1. Zorg dat je [Node.js](https://nodejs.org/en/) _versie 6.10.0_ heb geïnstalleerd op je computer.
2. Open je terminal/console in de `../app` folder
3. Typ de volgende commando's
```
npm install

npm run dev
```
Je hoeft `npm install` te gebruiken als de `package.json` file is veranderd of als je de (web)app voor de eerste keer installeert.
De webapp opent na het typen van `npm run dev` op adres `localhost:8080`

**Note:** Alleen de developmentomgeving draait op Node.js, de uiteindelijke app kan geserved worden en worden gedraaid op elke ECMA5 compactibele browser.
Om de bestanden om te zetten naar build-ready, gebruik het volgende commando in de `../app` folder: `npm run build --report`. **Doe dit altijd in een aparte map om de git bestanden intact te laten!**

---------
##VirtuRod (Deprecated?)
De firmware voor de vishengel die je gebruikt om VirtuVis mee te spelen.

Folder: `../Arduino/hengel`

Deze bestanden kunnen worden geopend met elke text editor, en worden geüpload via het Arduino programma.

--------
##VirtuVis API
De API voor VirtuVis die draait op Apache/PHP.

Folder: `../php`

-informatie-

--------
##VirtuVijver
De vijver waar de vissen in zwemmen.

Folder: `-folder-`

De vijver is het deel waar de vissen uit worden gevangen, het word geprojecteert op de grond onder de erasmusbrug, de vissen in deze vijver krijgen verschillende kleuren zodat de kleur sensor van de hengel ze kan herkennen.

--------
##VirtuVision
(In het geval dat het kleursensor approach niet werkt.)

Folder: `-folder-`

De dienst die kijkt naar de vijver voor visdetectie.
