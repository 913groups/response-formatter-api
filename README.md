# Response-formatter-api

Un utilitaire PHP léger pour le **Framework Slim** permettant de standardiser les réponses API au format JSON et XML.

## Présentation

Par défaut, Slim Framework laisse au développeur la gestion manuelle du corps de la réponse et des en-têtes (headers). **ResponseFormatterAPI** simplifie ce processus en offrant une structure de réponse constante, garantissant que vos champs `success`, `message` et `data` sont toujours formatés de la même manière.

## Fonctionnalités

* **Format Standardisé** : Une structure identique pour tous vos points de terminaison (endpoints).
* **Support Multi-format** : Basculez facilement entre le `JSON` et le `XML`.
* **Compatible PSR-7** : Fonctionne nativement avec l'objet Response de Slim.
* **Fluidité** : Retourne l'objet `Response` pour respecter le flux de contrôle de Slim.

---

## Installation

Ajoutez simplement la classe à votre projet ou installez-la via Composer :

```bash
composer require 913groups/response-formatter-api

```

---

## Utilisation

### Réponse JSON Standard

```php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$app->get('/utilisateur/{id}', function (Request $request, Response $response, $args) {
    $user = ['id' => 1, 'nom' => 'Jean Dupont'];
    
    return ResponseFormatterAPI::JSON(
        true,                // Succès (booléen)
        "Utilisateur trouvé", // Message
        200,                 // Code de statut HTTP
        $user,               // Données
        $response            // Objet Response de Slim
    );
});

```

### Réponse XML

```php
$app->get('/stats', function (Request $request, Response $response) {
    $data = ['visites' => 1500, 'statut' => 'online'];
    
    return ResponseFormatterAPI::XML(true, "Statistiques récupérées", 200, $data, $response);
});

```

---

## Structure des Réponses

### Exemple JSON

```json
{
  "success": true,
  "message": "Utilisateur trouvé",
  "data": {
    "id": 1,
    "nom": "Jean Dupont"
  }
}

```

### Exemple XML

```xml
<?xml version="1.0" encoding="UTF-8"?>
<response>
    <success>true</success>
    <message>Utilisateur trouvé</message>
    <data>{"id":1,"nom":"Jean Dupont"}</data>
</response>

```

---

## ⚙️ Détails techniques

La classe gère automatiquement :

1. L'encodage du corps de la réponse.
2. La définition de l'en-tête `Content-Type` (`application/json` ou `application/xml`).
3. L'application du code de statut HTTP correct.