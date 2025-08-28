<x-app-layout>
    <x-slot name="title">Détail d'un utilisateur</x-slot>

    <div class="py-6">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if(session('error'))
                    <div class="alert alert-danger text-red-600">
                        {{ session('error') }}
                    </div>
                    @endif
                    @if(session('success'))
                    <div class="alert alert-success text-green-600">
                        {{ session('success') }}
                    </div>
                    @endif

                    <div class="flex justify-between items-center mb-6 border-b-2 border-slate-100 pb-4">

                        <h2 class="font-semibold text-uppercase text-gray-800 leading-tight border-b-2 border-slate-100 pb-4">
                            <i class="bi bi-eye"></i> &nbsp; {{ $user->name }}
                        </h2>

                        <!-- Retour sur liste -->
                        <div class="flex justify-content-center">
                            <a href="{{route('users.index')}}" class="text-center ml-2 px-4 py-2 bg-light btn-hover shadow rounded-md font-semibold text-xs text-dark rounded uppercase">
                                <i class="bi bi-arrow-left-circle"></i> &nbsp; {{ __('Retour') }}
                            </a>
                        </div>

                        <div class="flex items-center">
                            <!-- <a href="{{ route('package-change', $user->id) }}" class="ml-2 inline-flex items-center px-4 py-2 bg-sky-500 text-white dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs rounded uppercase">
                                {{ __('Change package') }}
                            </a> -->

                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-hover btn-primary p-1">
                                <i class="bi bi-pencil"></i> &nbsp; {{ __('Modifier') }}
                            </a>

                            @if($user->detail->status == 'active')
                            <form method="post" action="{{ route('user.disable', $user->id) }}">
                                @csrf
                                @method('patch')
                                <div class="flex items-center gap-4 ml-2">
                                    <div class="flex items-center gap-4 ml-2">
                                        <button class="btn btn-sm btn-hover btn-primary"><i class="bi bi-shield-lock"></i> &nbsp;{{ __('Désactiver') }}</button>
                                    </div>
                                </div>
                            </form>
                            @endif
                            @if($user->detail?->status == 'inactive')
                            <form method="post" action="{{ route('user.enable', $user->id) }}">
                                @csrf
                                @method('patch')
                                <div class="flex items-center gap-4 ml-2">
                                    <div class="flex items-center gap-4 ml-2">
                                        <button class="btn btn-sm btn-hover btn-primary"><i class="bi bi-unlock2"></i> &nbsp;{{ __('Activer') }}</button>
                                    </div>
                                </div>
                            </form>
                            @endif
                        </div>
                    </div>
                    <div>

                        <div class="card">
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped table-sm">
                                    <thead class="text-white text-center bg-gradient-gray-dark">
                                        <tr>
                                            <th>N°</th>
                                            <th>Reference</th>
                                            <!-- <th>Nom tarif</th> -->
                                            <!-- <th>Prix tarif({{env("CURRENCY")}})</th> -->
                                            <th>Début tarif</th>
                                            <th>Method de paiement</th>
                                            <th>Date de paiement</th>
                                        </tr>
                                    </thead>

                                    <tbody class="table-body">
                                        @foreach($user->billing as $bill)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>REF_{{$bill->invoice}}</td>
                                            <!-- <td class="text-center">{{$user->detail?->package_name}}</td> -->
                                            <!-- <td class="text-center">{{$bill->package_price}}</td> -->
                                            <td class="text-center"><span class="badge bg-light border text-dark"> {{\Carbon\carbon::parse($bill->package_start)->locale('fr')->isoFormat('D MMMM YYYY')}}</span></td>
                                            <td class="text-center">
                                                @if($bill->payment)
                                                <span class="badge bg-light text-primary border">{{$bill->payment?->payment_method}}</span>
                                                @else
                                                <a href="{{route('payment.create',$bill->id)}}" class="btn btn-sm btn-primary text-dark border text-white"><i class="bi bi-wallet2"></i> &nbsp;Marquer comme payé</a>
                                                @endif
                                            </td>
                                            <td class="text-center"><span class="badge bg-light border text-dark"> {{$bill->payment?\Carbon\carbon::parse($bill->payment->created_at)->locale('fr')->isoFormat('D MMMM YYYY'):'---'}}</span></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
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