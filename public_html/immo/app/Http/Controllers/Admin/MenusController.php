<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MenusController extends Controller
{
    static function getClientMenus()
    {
        $sidebar = [
            "principals" =>
            [
                [
                    "name" => __("menu.tableau_de_bord"),
                    "fa" => "fa-tachometer-alt",
                    "route" => "client.dashboard.home",
                ]
            ],
            "secondaires" =>
            [
                [
                    'name'=>__('Mes reservations'),
                    'fa'=>'fa-store',
                    'route'=>'client.biens.index',
                ],
                [
                    'name'=>__('Annonces'),
                    'fa'=>'fa-building',
                    'route'=>'client.annonces.index',
                ],
            ]
        ];
        return json_decode(json_encode($sidebar));
    }

    static function getFournisseurMenus()
    {
        $sidebar = [
            "principals" =>
            [
                [
                    "name" => __("menu.tableau_de_bord"),
                    "fa" => "fa-tachometer-alt",
                    "route" => "agent.dashboard.home",
                ]
            ],
            "secondaires" =>
            [
                [
                    "name" => __("Annonces"),
                    "open" => false,
                    // "variableCount" => "_epingles",
                    'refs'=>['commandes','commandes-brouillons','commandes-validees','commandes-en_attente','commandes-traitees','commandes-annulees','commandes-confirmees'],
                    'fa'=>'fa-store',
                    "items" => [

                        [
                            "name" => __("En attente"),
                            "fa" => "fa-tachometer-alt",
                            "route" => "agent.annonces.index",
                            "params" => 'var=2',
                            "is_sous_menu" => true,
                            // 'variableCount' => "nbre_affectations"
                        ],
  
                        [
                            "name" => __("Publiees"),
                            "fa" => "fa-tachometer-alt",
                            "route" => "agent.annonces.index",
                            "params" => 'var=1',
                            "is_sous_menu" => true,
                            // 'variableCount' => "nbre_affectations"
                        ],
                        [
                            "name" => __("Clotures"),
                            "fa" => "fa-tachometer-alt",
                            "route" => "agent.annonces.index",
                            "params" => 'var=4',
                            "is_sous_menu" => true,
                            // 'variableCount' => "nbre_affectations"
                        ],
                    ]
                    ],
                [
                    'name'=>__('menu.mes_agents'),
                    'fa'=>'fa-users',
                    'route'=>'agent.agents.index',
                ],
            ]
        ];
        return json_decode(json_encode($sidebar));
    }
    static function getAgentMenus()
    {
        $sidebar = [
            "principals" =>
            [
                [
                    "name" => __("menu.tableau_de_bord"),
                    "fa" => "fa-tachometer-alt",
                    "route" => "agent.dashboard.home",
                ]
            ],
            "secondaires" =>
            [
                [
                    'name'=>__('Réseau'),
                    'fa'=>'fa-link',
                    'route'=>'agent.reseaux.links',
                ],
                [
                    'name'=>__('menu.immos'),
                    'fa'=>'fa-building',
                    'route'=>'agent.immos.index',
                ]
            ]
        ];
        return json_decode(json_encode($sidebar));
    }

    static function getSuperviseurMenus()
    {
        $sidebar = [
            "principals" =>
            [
                [
                    "name" => "Tableau de bord",
                    "fa" => "fa-tachometer-alt",
                    "route" => "dashboard.home",
                ]
            ],
            "secondaires" =>
            [

            ]
        ];

        return json_decode(json_encode($sidebar));
    }

    static function getAdminMenus()
    {
        $sidebar = [
            "principals" =>
            [
                [
                    "name" => __("menu.tableau_de_bord"),
                    "fa" => "fa-tachometer-alt",
                    "route" => "dashboard.home",
                ]
            ],
            "secondaires" =>
            [
                [
                    "name" => __("menu.annonces"),
                    "open" => false,
                    // "variableCount" => "_epingles",
                    'refs'=>['annonces'],
                    'fa'=>'fa-bell',
                    "items" => [
                        [
                            "name" => __("annonce.liste"),
                            "fa" => "fa-tachometer-alt",
                            "route" => "admin.annonces.index",
                            "is_sous_menu" => true,
                        ],
                        [
                            "name" => __("annonce.locations"),
                            "fa" => "fa-tachometer-alt",
                            "route" => "admin.annonces.index",
                            "is_sous_menu" => true,
                            "params" => 'var=1',
                        ],
                        [
                            "name" => __("annonce.ventes"),
                            "fa" => "fa-tachometer-alt",
                            "route" => "admin.annonces.index",
                            "is_sous_menu" => true,
                            "params" => 'var=2',
                        ],
                    ]
                ],
                // [
                //     'name'=>__('menu.locations'),
                //     'fa'=>'fa-map-marker',
                //     'route'=>'admin.locations.index',
                // ],
                // [
                //     'name'=>__('menu.commandes_traites'),
                //     'fa'=>'fa-history',
                //     'route'=>'commandes.traitees',
                // ],
                [
                    'name'=>__('menu.biens'),
                    'fa'=>'fa-map-marker',
                    'route'=>'admin.biens.index',
                ],
                [
                    'name'=>__('menu.immos'),
                    'fa'=>'fa-building',
                    'route'=>'admin.immos.index',
                ],

                [
                    'name'=>__('menu.fournisseurs'),
                    'fa'=>'fa-universal-access',
                    'route'=>'admin.agents.index',
                ],
                [
                    "name" => __("Inscriptions"),
                    "open" => false,
                    // "variableCount" => "_epingles",
                    'refs'=>['royalties-fournisseur','royalties-periodique','royalties-station'],
                    'fa'=>'fa-solid fa-users',
                    "items" => [
                        [
                            'name'=>__('Agents'),
                            'route'=>'admin.inscriptions.agents',
                        ],
                        [
                            'name'=>__('Clients'),
                            'route'=>'admin.inscriptions.clients',
                        ],
                    ]
                    ],
                [
                    "name" => __("Approbation des annonces"),
                    "open" => false,
                    // "variableCount" => "_epingles",
                    'refs'=>['annonce','royalties-periodique','royalties-station'],
                    'fa'=>'fa-solid fa-check',
                    "items" => [
                        [
                            'name'=>__('En attente'),
                            'route'=>'admin.annonce.en_attente',
                        ],
                        [
                            'name'=>__('Rejetées'),
                            'route'=>'admin.annonce.supprimes',
                        ],
                    ]
                ]


                // [
                //     "name" => __("menu.configurations"),
                //     "open" => false,
                //     // "variableCount" => "_epingles",
                //     'refs'=>['familles','sous-familles','gammes','zones'],
                //     'fa'=>'fa-cogs',
                //     "items" => [
                //         [
                //             "name" => __("Familles"),
                //             "fa" => "fa-tachometer-alt",
                //             "route" => "admin.familles.index",
                //             // "params" => 'var=2',
                //             "is_sous_menu" => true,
                //             // 'variableCount' => "nbre_affectations"
                //         ],
                //         [
                //             "name" => __("Sous Familles"),
                //             "fa" => "fa-tachometer-alt",
                //             "route" => "admin.sous-familles.index",
                //             // "params" => 'var=3',
                //             "is_sous_menu" => true,
                //             // 'variableCount' => "nbre_affectations"
                //         ],
                //         [
                //             "name" => __("Gammes"),
                //             "fa" => "fa-tachometer-alt",
                //             "route" => "admin.gammes.index",
                //             // "params" => 'var=3',
                //             "is_sous_menu" => true,
                //             // 'variableCount' => "nbre_affectations"
                //         ],
                //         [
                //             "name" => __("Zones"),
                //             "fa" => "fa-tachometer-alt",
                //             "route" => "admin.zones.index",
                //             // "params" => 'var=4',
                //             "is_sous_menu" => true,
                //             // 'variableCount' => "nbre_affectations"
                //         ],
                //     ]
                // ],
            ]
        ];

        return json_decode(json_encode($sidebar));
    }
    static function getSuperAdminMenus()
    {
        $sidebar = [
            "principals" =>
            [
                [
                    "name" => __("menu.tableau_de_bord"),
                    "fa" => "fa-tachometer-alt",
                    "route" => "dashboard.home",
                ]
            ],
            "secondaires" =>
            [
                [
                    'name'=>__('menu.filiales'),
                    'fa'=>'fa-building',
                    'route'=>'admin.comptes.index',
                    'refs'=>['comptes']
                ],
                [
                    'name'=>__('menu.superviseurs'),
                    'fa'=>'fa-users',
                    'route'=>'admin.users.superviseurs',
                    'refs'=>['comptes']
                ]
            ]
        ];
        return json_decode(json_encode($sidebar));
    }
}
