@props(['width'=>'80%'])

<style>
    .§_info {
        background: #c7eaf1;
        border-radius: 10px;
        border-color: #25cff2;
        border-style: double;
        color: #147083;
        width: {{$width}};
        margin-left: auto;
        margin-right: auto;
        margin-top: 10px;
        margin-bottom: 10px;
        padding: 5px;
    }

    .§_info a {
        margin: 10px;
        color: #0f5b6a;
    }
</style>
<div class ="§_info">
    {{ $slot }}
</br>
    <a class="btn btn-info" style=""><i class="bi bi-question-circle"></i> Index de l'aide</a>
</div>
