<x-app-layout>
    <x-slot name="title">Facturation | Créer</x-slot>

    <div class="py-6">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if(session('error'))
                    <div class="alert alert-danger text-red-600">
                        {{ session('error') }}
                    </div>
                    @endif

                    <div class="flex justify-between items-center mb-6 border-b-2 border-slate-100 pb-4">
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                            <i class="bi bi-node-plus"></i> &nbsp; {{ __('Génération de facture') }}
                        </h2>

                    </div>
                    <div>
                        <form method="post" action="{{ route('billing.store') }}" class="mt-6 space-y-6">
                            @csrf

                            <!-- Info -->
                            <div class="alert alert-warning border-left border-bold">
                                <i class="bi bi-info-circle"></i> Les champs portant le signe (<span class="text-danger">*</span>) sont réquis!
                            </div>

                            <!-- Retour sur liste -->
                            <div class="flex justify-content-center">
                                <a href="{{route('billing.index')}}" class="text-center ml-2 px-4 py-2 bg-light btn-hover shadow rounded-md font-semibold text-xs text-dark rounded uppercase">
                                    <i class="bi bi-arrow-left-circle"></i> &nbsp; {{ __('Retour') }}
                                </a>
                            </div>

                            <table id="example1" class="border-separate border border-spacing-2 border-slate-400 w-full">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="border border-slate-300 text-left">{{ __('Selectionner') }}</th>
                                        <th class="border border-slate-300 text-left">{{ __('Utilisateur') }}</th>
                                        <!-- <th class="border border-slate-300 text-left">{{ __('Tarif(package)') }}</th> -->
                                        <th class="border border-slate-300 text-left">{{ __('Prix') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                    <tr>
                                        <td class="border border-slate-300 p-2">
                                            <input type="checkbox" class="rounded" name="users[$user->id][checked]" value="{{ $user->id }}">
                                        </td>
                                        <td class="border border-slate-300 p-2">{{ $user->name }}</td>
                                        <!-- <td class="border border-slate-300 p-2">{{ $user->detail->package_name }}</td> -->
                                        <td class="border border-slate-300 p-2">
                                            <input type="number" name="users[$user->id][price]" class="form-control" placeholder="Ex: 75000">
                                        </td>
                                        <input type="hidden" name="users_id[]" value="{{ $user->id }}">
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="flex justify-content-center items-center gap-4 mt-4">
                                <button type="submit" class="w-50 text-center ml-2 px-4 py-2 bg-blue btn-hover shadow rounded-md font-semibold text-xs text-white rounded uppercase">
                                    <i class="bi bi-check-circle"></i> &nbsp; {{ __('Enregistrer') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push("scripts")
    <script type="text/javascript">
        $(function() {
            $("#example1").DataTable({
                "paging": false,
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ['excel', 'pdf', 'print'],
                "order": [
                    [0, 'desc']
                ],
                "pageLength": 15,
                language: {
                    "emptyTable": "Aucune donnée disponible dans le tableau",
                    "lengthMenu": "Afficher _MENU_ éléments",
                    "loadingRecords": "Chargement...",
                    "processing": "Traitement...",
                    "zeroRecords": "Aucun élément correspondant trouvé",
                    "paginate": {
                        "first": "Premier",
                        "last": "Dernier",
                        "previous": "Précédent",
                        "next": "Suiv"
                    },
                    "aria": {
                        "sortAscending": ": activer pour trier la colonne par ordre croissant",
                        "sortDescending": ": activer pour trier la colonne par ordre décroissant"
                    },
                    "select": {
                        "rows": {
                            "_": "%d lignes sélectionnées",
                            "1": "1 ligne sélectionnée"
                        },
                        "cells": {
                            "1": "1 cellule sélectionnée",
                            "_": "%d cellules sélectionnées"
                        },
                        "columns": {
                            "1": "1 colonne sélectionnée",
                            "_": "%d colonnes sélectionnées"
                        }
                    },
                    "autoFill": {
                        "cancel": "Annuler",
                        "fill": "Remplir toutes les cellules avec <i>%d<\/i>",
                        "fillHorizontal": "Remplir les cellules horizontalement",
                        "fillVertical": "Remplir les cellules verticalement"
                    },
                    "searchBuilder": {
                        "conditions": {
                            "date": {
                                "after": "Après le",
                                "before": "Avant le",
                                "between": "Entre",
                                "empty": "Vide",
                                "equals": "Egal à",
                                "not": "Différent de",
                                "notBetween": "Pas entre",
                                "notEmpty": "Non vide"
                            },
                            "number": {
                                "between": "Entre",
                                "empty": "Vide",
                                "equals": "Egal à",
                                "gt": "Supérieur à",
                                "gte": "Supérieur ou égal à",
                                "lt": "Inférieur à",
                                "lte": "Inférieur ou égal à",
                                "not": "Différent de",
                                "notBetween": "Pas entre",
                                "notEmpty": "Non vide"
                            },
                            "string": {
                                "contains": "Contient",
                                "empty": "Vide",
                                "endsWith": "Se termine par",
                                "equals": "Egal à",
                                "not": "Différent de",
                                "notEmpty": "Non vide",
                                "startsWith": "Commence par"
                            },
                            "array": {
                                "equals": "Egal à",
                                "empty": "Vide",
                                "contains": "Contient",
                                "not": "Différent de",
                                "notEmpty": "Non vide",
                                "without": "Sans"
                            }
                        },
                        "add": "Ajouter une condition",
                        "button": {
                            "0": "Recherche avancée",
                            "_": "Recherche avancée (%d)"
                        },
                        "clearAll": "Effacer tout",
                        "condition": "Condition",
                        "data": "Donnée",
                        "deleteTitle": "Supprimer la règle de filtrage",
                        "logicAnd": "Et",
                        "logicOr": "Ou",
                        "title": {
                            "0": "Recherche avancée",
                            "_": "Recherche avancée (%d)"
                        },
                        "value": "Valeur"
                    },
                    "searchPanes": {
                        "clearMessage": "Effacer tout",
                        "count": "{total}",
                        "title": "Filtres actifs - %d",
                        "collapse": {
                            "0": "Volet de recherche",
                            "_": "Volet de recherche (%d)"
                        },
                        "countFiltered": "{shown} ({total})",
                        "emptyPanes": "Pas de volet de recherche",
                        "loadMessage": "Chargement du volet de recherche..."
                    },
                    "buttons": {
                        "copyKeys": "Appuyer sur ctrl ou u2318 + C pour copier les données du tableau dans votre presse-papier.",
                        "collection": "Collection",
                        "colvis": "Visibilité colonnes",
                        "colvisRestore": "Rétablir visibilité",
                        "copy": "Copier",
                        "copySuccess": {
                            "1": "1 ligne copiée dans le presse-papier",
                            "_": "%ds lignes copiées dans le presse-papier"
                        },
                        "copyTitle": "Copier dans le presse-papier",
                        "csv": "CSV",
                        "excel": "Excel",
                        "pageLength": {
                            "-1": "Afficher toutes les lignes",
                            "_": "Afficher %d lignes"
                        },
                        "pdf": "PDF",
                        "print": "Imprimer"
                    },
                    "decimal": ",",
                    "info": "Affichage de _START_ à _END_ sur _TOTAL_ éléments",
                    "infoEmpty": "Affichage de 0 à 0 sur 0 éléments",
                    "infoThousands": ".",
                    "search": "Rechercher:",
                    "thousands": ".",
                    "infoFiltered": "(filtrés depuis un total de _MAX_ éléments)",
                    "datetime": {
                        "previous": "Précédent",
                        "next": "Suivant",
                        "hours": "Heures",
                        "minutes": "Minutes",
                        "seconds": "Secondes",
                        "unknown": "-",
                        "amPm": [
                            "am",
                            "pm"
                        ],
                        "months": [
                            "Janvier",
                            "Fevrier",
                            "Mars",
                            "Avril",
                            "Mai",
                            "Juin",
                            "Juillet",
                            "Aout",
                            "Septembre",
                            "Octobre",
                            "Novembre",
                            "Decembre"
                        ],
                        "weekdays": [
                            "Dim",
                            "Lun",
                            "Mar",
                            "Mer",
                            "Jeu",
                            "Ven",
                            "Sam"
                        ]
                    },
                    "editor": {
                        "close": "Fermer",
                        "create": {
                            "button": "Nouveaux",
                            "title": "Créer une nouvelle entrée",
                            "submit": "Envoyer"
                        },
                        "edit": {
                            "button": "Editer",
                            "title": "Editer Entrée",
                            "submit": "Modifier"
                        },
                        "remove": {
                            "button": "Supprimer",
                            "title": "Supprimer",
                            "submit": "Supprimer",
                            "confirm": {
                                "1": "etes-vous sure de vouloir supprimer 1 ligne?",
                                "_": "etes-vous sure de vouloir supprimer %d lignes?"
                            }
                        },
                        "error": {
                            "system": "Une erreur système s'est produite"
                        },
                        "multi": {
                            "title": "Valeurs Multiples",
                            "restore": "Rétablir Modification",
                            "noMulti": "Ce champ peut être édité individuellement, mais ne fait pas partie d'un groupe. ",
                            "info": "Les éléments sélectionnés contiennent différentes valeurs pour ce champ. Pour  modifier et "
                        }
                    }
                },
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

        });
    </script>
    @endpush
</x-app-layout>