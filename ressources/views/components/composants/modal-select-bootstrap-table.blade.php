{{--


--}}

@props([
    'titre' => '',
    'texte' => '',
    'dataSelected' => '',
    'route' => '',
    'colonnes' => '',
    'nbLignes' =>10,
    'dataRetour' => '',
    'boutons',
    'btnSelectOnclick' => '',
])

<!-- Modal pp-->
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">{{ $titre }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{ $texte }}

                <div class="§_panel">
                    <div class="§_content">
                        <table id="tableModal" data-toolbar="#toolbar" data-toolbar="#toolbar" class="table-striped"
                            data-page-size="{{$nbLignes}}" data-show-toggle="true" data-show-columns-toggle-all="true"
                            data-show-columns="true" data-buttons="buttons" data-side-pagination="server"
                            data-row-style="rowStyle" data-pagination="true" data-unique-id="id"
                            data-mobile-responsive="false" data-locale="fr-FR" data-toggle="table" data-search="true"
                            data-show-refresh="true" data-url="{{ route($route) }}">
                            <thead>
                                <tr>
                                    @foreach ($colonnes as $label => $info)
                                        <th data-halign="center" data-field="{{ $info['fieldName'] }}"
                                            data-width="{{ $info['width'] }}" data-align="{{ $info['align'] }}"
                                            data-sortable="true">{{ $info['label'] }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                {{-- <button type="button" class="btn btn-primary" onclick="{{ $modalSelectBootstrapTable_onClick }}"
                    data-bs-dismiss="modal">Choisir</button> --}}
            </div>
        </div>
    </div>
</div>
<script>
    $('#tableModal').on('click-cell.bs.table', function(event, field, value, row) {
        var dataRetour = {!! json_encode($dataRetour) !!}
        btnSelectOnclick = {{$btnSelectOnclick}}
        modal = new rras3k_modal('myModal')
        modal.dismiss()
        btnSelectOnclick(prepareToReturn(dataRetour,row))
    })
    function prepareToReturn(dataRetour,row){
        var ret = []
        dataRetour.forEach(element => {
            ret[element] = row[element]
        });
        return ret
    }


</script>
