<?php
// dd($data);
// dd(Core::getEntites())
// dd($errors);
?>
<{{ $data['php'] }}
use Rras3k\SebconsoleRoot\facades\Core;
Core::setEntite();

// dd($data);
// dd(Core::getEntites());
// dd($errors);

?>

    {{ '@' }}extends('layouts.console')

    {{ '@' }}section('head-link')
    {{ '@' }}endsection

    {{ '@' }}section('content')
    <div class="§_main">
        <div class="§_header">
            <div class="§_titre">{!! '{' !!}{ Core::getTitre() }}</div>
        </div>
        <div class="§_panel_group">
            <div class="§_panel §_w_600">
                <div class="§_content">

                    {!! '@' !!}if (Core::form_isCreate())
                        <form id="role" method="POST"
                        action="{!! '{' !!}{ route(Core::getRouteName('store')) }}"
                        enctype="multipart/form-data" name="role">
                    {!! '@' !!}else
                        <form id="role" method="POST"
                            action="{!! '{' !!}{ route(Core::getRouteName('update'),Core::form_getData('id')) }}"
                            enctype="multipart/form-data" name="role">
                            {!! '<' !!}x-sebconsoleviews::forms.hidden
                            :liste="Core::form_getHiddenValues()" />
                            {!! '@' !!}method('PUT')
                    {!! '@' !!}endif
                            {!! '@' !!}csrf
                            <div class="row">
                                @foreach ($data['this']->champs as $key => $value)
                                    @if ($value['form']['visible'])
                                        @if ($value['link']['enable'])
                                            {!! '<' !!}x-sebconsoleviews::forms.select
                                            :value="Core::form_getData('{{ $key }}')"
                                            :liste="Core::data_getList('{{ $value['link']['table'] }}')"
                                            listeId="id" listeValue="label" nom="{{ $key }}"
                                            label="{{ $value['link']['label'] }}" placeholder=""/>
                                        @elseif ($value['type'] == 'boolean')
                                            {!! '<' !!}x-sebconsoleviews::forms.checkbox
                                            :value="Core::form_getData('{{ $key }}')"
                                            nom="{{ $key }}" label="{{ $value['form']['label'] }}"
                                            placeholder="" />
                                        @elseif ($value['type'] == 'text')

                                        @elseif ($value['type'] == 'numeric')
                                            {!! '<' !!}x-sebconsoleviews::forms.input type="text"
                                            :value="Core::form_getData('{{ $key }}')"
                                            nom="{{ $key }}" label="{{ $value['form']['label'] }}"
                                            placeholder=""/>
                                        @else
                                            {!! '<' !!}x-sebconsoleviews::forms.input type="text"
                                            :value="Core::form_getData('{{ $key }}')"
                                            nom="{{ $key }}" label="{{ $value['form']['label'] }}"
                                            placeholder=""/>
                                        @endif
                                    @endif
                                @endforeach
                            </div>
                        </form>
                </div>
                <div class="§_footer">
                    <div class="col-12">
                        {!! '@' !!}if (!Core::form_isCreate())
                        <a href="{!! '{' !!}{ route(Core::getRouteName('edit'),Core::form_getData('id')) }}"
                            class="btn btn-secondary">Rafraichir</a>
                        {!! '@' !!}endif
                        <button form="role" type="submit" class="btn btn-primary">Enregistrer</button>
                        <a role="button" onclick="history.back()" class="btn btn-secondary">Annuler</a>

                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <script></script>
    {{ '@' }}endsection
