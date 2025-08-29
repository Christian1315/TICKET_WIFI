<x-app-layout>
    <x-slot name="title">Tickets | Liste</x-slot>

    <div class="py-6">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6 border-b-2 border-slate-100 pb-4">
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                            <i class="bi bi-ticket-detailed"></i> &nbsp; {{ __('Tickets') }}
                        </h2>
                        <!-- if (!auth()->user()->isUser()) -->
                        <a href="{{ route('ticket.create') }}" class="ml-2 inline-flex items-center px-4 py-2 bg-blue btn-hover shadow rounded-md font-semibold text-xs text-white rounded uppercase">
                            <i class="bi bi-person-plus"></i> &nbsp; {{ __('Ajouter') }}
                        </a>
                        <!-- endif -->
                    </div>
                    <div>
                        <!-- livewire:ticket-table /> -->
                        <table id="example1" class="table table-bordered table-striped table-sm">
                            <thead class="text-white text-center bg-gradient-gray-dark">
                                <tr>
                                    <th>Numéro</th>
                                    <th>Sujet</th>
                                    <th>Facture</th>
                                    <th>Statut</th>
                                    <th>Vendu</th>
                                    <th>Payé %</th>
                                    <th>Tarif(package)</th>
                                    <th>Prix ({{env("CURRENCY")}}) </th>
                                    <!-- <th>Crée par</th> -->
                                    <th>Crée le</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody class="table-body">
                                @foreach($tickets as $ticket)
                                <tr>
                                    <td>{{$ticket->number}}</td>
                                    <td>{{$ticket->subject}}</td>
                                    <td class="text-center">@if($ticket->billing)REF_{{$ticket->billing?->invoice}} @else --- @endif</td>
                                    <td> <span class="badge text-white bg-{{$ticket->status=='Open'?'success':'danger'}} text-dark border">{{$ticket->status}}</span></td>
                                    <td> <span class="badge text-white bg-{{$ticket->downloaded?'success':'danger'}} text-dark border">{{$ticket->downloaded?'Oui':"Non"}}</span></td>
                                    <td> <span class="badge text-white bg-{{$ticket->percent_paid?'success':'danger'}} text-dark border">{{$ticket->percent_paid?'Oui':"Non"}}</span></td>
                                    <td class="text-center">{{$ticket->package?->name}}</td>
                                    <td class="text-center"><span class="badge bg-light border text-dark"> {{number_format($ticket->package?->price,2,","," ")}}</span></td>
                                    <!-- <td class="text-center"><span class="badge bg-light border text-dark"> {{$ticket->user?->name}}</span></td> -->
                                    <td class="text-center"><span class="badge bg-light border text-dark"> {{\Carbon\carbon::parse($ticket->created_at)->locale('fr')->isoFormat('D MMMM YYYY')}}</span></td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            @if($ticket->ticket_file)
                                            <a target="_blank" href="{{$ticket->ticket_file}}" title="Voir le ticket" class="btn btn-sm border text-white btn-hover bg-orange"><i class="bi bi-filetype-pdf"></i> Voir</a>
                                            @else
                                            --
                                            @endif
                                            <a href="{{route('ticket.show', $ticket->id)}}" title="Détail" class="btn btn-sm bg-light border text-dark btn-hover"><i class="bi bi-eye"></i> Détail</a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @push("scripts")
    <script type="text/javascript">
        $(function() {
            $("#example1").DataTable({
                // "paging": false,
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