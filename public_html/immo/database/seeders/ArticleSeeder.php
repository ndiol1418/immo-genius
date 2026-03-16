<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ArticleSeeder extends Seeder
{
    public function run()
    {
        $articles = [
            [
                'titre'     => 'Guide d\'achat immobilier au Sénégal en 2026',
                'categorie' => 'guide',
                'statut'    => 'publie',
                'extrait'   => 'Tout ce que vous devez savoir pour acheter un bien immobilier au Sénégal en 2026 : démarches, documents, pièges à éviter et conseils d\'experts.',
                'contenu'   => "L'achat immobilier au Sénégal est une étape importante qui nécessite une bonne préparation. Que vous soyez résident ou membre de la diaspora, ce guide complet vous accompagne à chaque étape.\n\n**1. Définir son budget**\n\nAvant toute recherche, établissez votre budget total en incluant : le prix d'achat, les frais de notaire (7-10%), les frais d'agence (3-5%), et une réserve pour les travaux éventuels.\n\n**2. Le titre foncier**\n\nC'est le document le plus important. Assurez-vous que le bien dispose d'un titre foncier en règle, libre de toute hypothèque. Vérifiez au cadastre avant tout engagement.\n\n**3. Choisir le bon quartier**\n\nDakar offre des opportunités variées : le Plateau pour le prestige, les Almadies pour le standing, la Cité Keur Gorgui pour les familles, et des quartiers émergents comme Diamniadio pour l'investissement.\n\n**4. Faire appel à un agent certifié**\n\nUn agent Teranga vous protège des arnaques et vous fait gagner du temps. Notre outil de matching vous recommande l'agent le plus adapté à votre projet.\n\n**5. La signature chez le notaire**\n\nToute transaction immobilière au Sénégal doit être formalisée par un acte notarié. Le notaire vérifie la légalité de la transaction et assure le transfert du titre foncier.",
            ],
            [
                'titre'     => 'Les quartiers les plus prisés de Dakar en 2026',
                'categorie' => 'quartier',
                'statut'    => 'publie',
                'extrait'   => 'Découvrez les quartiers les plus recherchés de Dakar : prix, ambiance, services disponibles et perspectives d\'investissement.',
                'contenu'   => "Dakar est une ville aux multiples visages, où chaque quartier a sa propre identité et ses propres opportunités immobilières.\n\n**Le Plateau — Le cœur historique**\n\nCentre des affaires et de l'administration, le Plateau abrite les immeubles de standing et les bureaux. Les prix sont parmi les plus élevés de la capitale : 800 000 à 1 500 000 CFA/m².\n\n**Les Almadies — La Côte d'Azur dakaroise**\n\nQuartier résidentiel haut de gamme avec vue sur l'océan Atlantique. Apprécié des expatriés et des cadres supérieurs. Prix moyens : 600 000 à 1 200 000 CFA/m².\n\n**Mermoz / Sacré-Cœur — L'équilibre parfait**\n\nQuartier résidentiel calme et bien desservi, à proximité des ambassades et des grandes surfaces. Idéal pour les familles. Prix : 400 000 à 800 000 CFA/m².\n\n**Ouakam / Ngor — Bord de mer accessible**\n\nEntre la mer et le calme, ces quartiers offrent un excellent rapport qualité-prix avec des vues océan. Prix : 350 000 à 700 000 CFA/m².\n\n**Diamniadio — L'avenir de Dakar**\n\nNouvelle ville en développement avec des prix encore abordables et un potentiel de plus-value élevé. Idéal pour les investisseurs à long terme. Prix : 80 000 à 250 000 CFA/m².",
            ],
            [
                'titre'     => 'Comment bien estimer son bien immobilier au Sénégal',
                'categorie' => 'conseil',
                'statut'    => 'publie',
                'extrait'   => 'L\'estimation immobilière est une étape cruciale. Découvrez les méthodes utilisées par les experts pour évaluer correctement votre bien.',
                'contenu'   => "Une bonne estimation est la clé d'une vente réussie. Trop haut, votre bien ne se vend pas ; trop bas, vous perdez de l'argent.\n\n**Les facteurs qui influencent le prix**\n\n1. La localisation : c'est le critère numéro un. Un même appartement peut valoir 3 fois plus selon le quartier.\n\n2. La superficie : calculée en m² habitables, hors terrasse et dépendances.\n\n3. L'état général : neuf, bon état, à rénover. Une rénovation complète peut ajouter 20-30% de valeur.\n\n4. L'étage et l'orientation : une terrasse avec vue mer peut ajouter 15-25% de valeur.\n\n5. Les équipements : climatisation, groupe électrogène, gardiennage.\n\n**Les méthodes d'estimation**\n\n**Méthode comparative** : analyse des ventes récentes de biens similaires dans le même quartier. C'est la méthode la plus fiable.\n\n**Méthode par capitalisation** : pour les biens locatifs, on divise le loyer annuel par le taux de rendement moyen du marché (généralement 5-8%).\n\n**Notre Zestimate Teranga** : notre algorithme analyse des centaines de transactions pour vous donner une estimation précise en temps réel, avec un niveau de confiance et une fourchette de prix.",
            ],
            [
                'titre'     => 'Marché immobilier sénégalais : bilan 2025 et perspectives 2026',
                'categorie' => 'marche',
                'statut'    => 'publie',
                'extrait'   => 'Analyse complète du marché immobilier sénégalais en 2025 : tendances, prix, volumes de transactions et perspectives pour 2026.',
                'contenu'   => "Le marché immobilier sénégalais a connu une année 2025 dynamique, portée par plusieurs facteurs structurels.\n\n**Les tendances majeures de 2025**\n\n**Hausse des prix à Dakar** : les prix ont progressé de 8 à 12% dans les quartiers prisés, notamment aux Almadies, au Plateau et à Mermoz. Cette hausse est tirée par la demande croissante de la diaspora et l'insuffisance de l'offre premium.\n\n**Émergence de Diamniadio** : la nouvelle ville a enregistré une forte augmentation des transactions (+35% vs 2024), attirant les primo-accédants et les investisseurs institutionnels.\n\n**Boom de la location courte durée** : l'essor du tourisme et des conférences internationales a boosté la demande de locations meublées haut de gamme, avec des rendements attractifs de 8-12%.\n\n**Perspectives 2026**\n\n- Stabilisation des prix à Dakar intra-muros\n- Poursuite de la hausse dans les zones périphériques bien desservies\n- Développement du marché des bureaux post-covid\n- Accès facilité au crédit immobilier avec les nouvelles politiques bancaires\n- Croissance attendue de 15-20% à Diamniadio\n\n**Notre conseil** : 2026 reste une année favorable pour investir, notamment dans les zones en développement autour de Dakar.",
            ],
            [
                'titre'     => 'Conseils pour louer en toute sécurité au Sénégal',
                'categorie' => 'conseil',
                'statut'    => 'publie',
                'extrait'   => 'Location immobilière au Sénégal : comment trouver un logement fiable, rédiger un bail solide et éviter les arnaques fréquentes.',
                'contenu'   => "La location immobilière au Sénégal peut présenter des pièges pour les non-avertis. Voici nos conseils pour louer en toute sécurité.\n\n**Avant de signer**\n\n1. **Vérifiez l'identité du propriétaire** : demandez la pièce d'identité et le titre de propriété. Un propriétaire légitime n'aura aucun problème à vous les montrer.\n\n2. **Visitez le bien en personne** : ne versez jamais d'argent pour un bien que vous n'avez pas visité. Les arnaques par photos sont fréquentes.\n\n3. **Comparez les prix** : renseignez-vous sur les loyers pratiqués dans le quartier pour éviter les surfacturations.\n\n**Le contrat de bail**\n\nExigez toujours un contrat de bail écrit mentionnant :\n- Le montant exact du loyer et des charges\n- La durée de la location\n- Le montant du dépôt de garantie\n- Les obligations de chaque partie\n- Les conditions de résiliation\n\n**L'état des lieux**\n\nFaites un état des lieux contradictoire à l'entrée, avec photos à l'appui. Ce document vous protège lors de votre départ pour récupérer votre caution.\n\n**Les arnaques courantes à éviter**\n\n- Les demandes de caution élevée avant visite\n- Les biens proposés à des prix anormalement bas\n- Les propriétaires qui ne peuvent pas vous recevoir en personne\n- Les demandes de paiement par Western Union ou transfert rapide\n\n**Notre conseil** : passez par un agent Teranga certifié qui vérifie tous les documents et sécurise la transaction.",
            ],
        ];

        foreach ($articles as $data) {
            $data['slug']      = Str::slug($data['titre']);
            $data['auteur_id'] = \App\Models\User::first()?->id;
            Article::create($data);
        }
    }
}
