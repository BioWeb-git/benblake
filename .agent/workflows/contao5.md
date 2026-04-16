---
description: Règles de développement et architecture pour les projets Contao 5 (Base Oneo)
---

# Guide de développement Contao 5 / Oneo

Ce document centralise les règles de développement et les connaissances techniques extraites de l'analyse du projet. Il doit être alimenté régulièrement pour faciliter la création de nouveaux projets.

## 0. Maintenance & Report du Workflow
- **IMPORTANCE CRITIQUE** : Ce fichier doit rester **GÉNÉRAL**. Ne consignez pas ici de détails spécifiques à un projet client (ex: couleurs d'un logo particulier), mais uniquement des règles, mixins ou structures valables pour **tous** les projets basés sur Contao 5 / Oneo.
- **REPORT AUTOMATIQUE** : Toute mise à jour de ce guide dans un projet local doit être reportée immédiatement dans le projet modèle : `/home/pouet/contao5/.agent/workflows/contao5.md`.

## 1. Structure SCSS & Design System

### Fichiers Éditables
- **Thème Client (Spécifique)** : 
    - `files/client/scss/client.scss` : Toutes les surcharges spécifiques au projet.
    - `files/client/scss/_variables_client.scss` : Tokens de couleurs et variables spécifiques.
    - `files/client/scss/_fonts.scss` : Imports de polices (ex: Google Fonts).
- **Thème Global (Commun)** :
    - `files/client/scss/_custom.scss` : Modifications impactant la structure globale ou les éléments partagés entre projets.

### Gestion du Responsive
- **Breakpoints** : Définis dans `_variables.scss` :
    - `tablet` : 1000px
    - `mobile` : 700px
    - `mobile-portrait` : 600px
- **Mixins de Media Queries** : Utiliser impérativement les mixins de `_mixins.scss` :
    - `@include mediaquery(tablet) { ... }` (max-width)
    - `@include mediaquery-min(tablet) { ... }` (min-width)
    - `@include container(tablet) { ... }` (pour les Container Queries CSS)

### Bonnes Pratiques Variables
- **_variables_client.scss** : **NE JAMAIS UTILISER `!default`**. Ce fichier est destiné à écraser les valeurs par défaut du thème. L'utilisation de `!default` empêcherait la prise en compte de vos variables personnalisées si elles sont déjà définies par ailleurs.

### Interdictions
- **NE JAMAIS MODIFIER** : `_main.scss`, `_mixins.scss`, `_normalize.scss`.

## 2. Javascript (Architecture)

- **script.js** (`files/client/js/script.js`) : **INTERDICTION DE MODIFIER**. Ce fichier contient la logique core du thème Oneo (gestion du scroll, injection de padding sur le header, menu mobile, etc.).
- **shared.js** (`files/client/js/shared.js`) : **SEUL FICHIER AUTORISÉ**. Utilisez-le pour vos scripts personnalisés ou hooks spécifiques au projet.

### 2.1 Gestion du Scroll
- Le fichier `shared.js` injecte automatiquement la classe `.scroll` sur la balise `<body>` dès que l'utilisateur scrolle de plus de **200px**.
- **Usage CSS** : Utilisez `body.scroll .votre-element` pour appliquer des styles spécifiques (ex: réduire la taille du header, changer la couleur de fond).

## 3. Templates & Custom Elements (RSCE)

- **Templates** :
    - Surcharges dans `templates/client/`.
    - **INTERDICTION** : Ne touchez jamais à `templates/oneo/`.
- **RockSolid Custom Elements** :
    - Les configs (`rsce_*_config.php`) et templates (`rsce_*.html5`) se trouvent dans `templates/client/`.
    - Pour ajouter des options de hauteur (ex: Viewport), modifiez la config PHP et assurez-vous que les classes CSS correspondantes sont dans `_custom.scss`.

## 4. Configuration & Déploiement

- **Migrations de Base de Données** :
    - Contao 5 utilise `tl_page.domain`. Pour que les migrations fonctionnent en local (ex: `.test`), assurez-vous que `DNS_MAPPING` est correctement rempli dans le `.env`.
    - Format : `DNS_MAPPING="domain.com=domain.test,other.com=other.test"`.
- **Compass** : Utilisez `compass watch files/client/scss` pour compiler les styles en temps réel.

## 5. Notes d'Observation (Analyse)

- **Header Fixed** : Le JS de Oneo injecte souvent un padding-top inline sur `.page-header`. Pour un header transparent au-dessus du contenu, il faut forcer `padding-top: 0 !important` en CSS.
- **Logo Responsive** : Par défaut, Oneo peut réduire drastiquement la taille du logo sur tablette. Toujours vérifier la lisibilité en dessous de 1000px dans `client.scss`.

## 6. Système d'Animation (is-animated)
- Le thème Oneo intègre un moteur d'animation léger dans `files/client/js/script.js`.
- **Fonctionnement** :
    - Ajoutez la classe `.is-animated` à un élément (via RSCE ou template).
    - Le script surveille le scroll et injecte la classe `.in-view` dès que l'élément est à **80% de la hauteur du viewport**.
    - La classe `.has-shown` est également ajoutée pour indiquer que l'élément a été vu au moins une fois.
    - Pour que l'animation se relance à chaque passage, ajoutez la classe `.does-repeat`.
- **Implémentation CSS recommandée** :
    ```scss
    .votre-element.is-animated {
        opacity: 0;
        transform: translateY(20px);
        transition: all 1s ease;
        &.in-view {
            opacity: 1;
            transform: translateY(0);
        }
    }
    ```
