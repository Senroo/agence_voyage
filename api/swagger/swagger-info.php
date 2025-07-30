<?php

namespace Api\Swagger;
use OpenApi\Attributes as OA;

#[OA\Info(
        title: 'API voyage. Documentation',
        version: '1.0.0',
        description: 'Cette API permet aux tours-opérateurs de gérer les avis de leurs clients sur les voyages qu\'ils proposent.

    ',
        contact: new OA\Contact(
            name: 'the developer',
            email: 'sengerromain75@gmail.com'
        ),
        license: new OA\License(
            name: 'Apache 2.0',
            url: 'https://www.apache.org/licenses/LICENSE-2.0.html'
        )
    )]

#[OA\Server(
        url: 'http://127.0.0.1/php/agence_voyage/api/',
        description: 'Serveur local de développement'
    )]

#[OA\Tag(name: 'Client', description: 'Ajouter, modifier, supprimer, lire un client.')]
#[OA\Tag(name: 'Avis', description: 'Ajouter, modifier, supprimer, lire un avis.')]
#[OA\Tag(name: 'Voyage', description: 'Ajouter, modifier, supprimer, lire un avis voyage.')]

class SwaggerInfo {} 
