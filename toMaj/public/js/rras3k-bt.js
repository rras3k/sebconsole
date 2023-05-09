var btTables = {}

function btAddTable(tableHtmlId) {
    btTables[tableHtmlId] = {}
    btTables[tableHtmlId]['id'] = $('#' + tableHtmlId)
    btTables[tableHtmlId]['url'] = btTables[tableHtmlId]['id'].attr('data-url')
}

function btAddFiltreSelect(tableHtmlId, FiltreSelectHtmlId) {
    FiltreSelectHtmlId = 'filtre_' + FiltreSelectHtmlId
    if (typeof btTables[tableHtmlId]['filtre'] === 'undefined') btTables[tableHtmlId]['filtre'] = {}
    btTables[tableHtmlId]['filtre'][FiltreSelectHtmlId] = document.querySelector('#' + FiltreSelectHtmlId)
    btTables[tableHtmlId]['filtre'][FiltreSelectHtmlId].addEventListener("change", function () {
        // envoie de la requête
        btDataUrl(tableHtmlId);
    });
}

function btBuildUrl(tableHtmlId) {
    var para = ""
    // Pour les filtres avec select
    for (var filtre in btTables[tableHtmlId]['filtre']) {
        console.log('filtre', filtre)
        para = para ? para + "&" : para
        para += btTables[tableHtmlId]['filtre'][filtre].getAttribute('name') + '=' + btTables[tableHtmlId]['filtre'][filtre].value
    }
    // console.log(para)
    return para
}

function btDataUrl(tableHtmlId) {
    let para = btBuildUrl(tableHtmlId)
    let urlData = btTables[tableHtmlId]['url'] + '?' + para
    btTables[tableHtmlId]['id'].bootstrapTable('refresh', {
        url: btTables[tableHtmlId]['url'] + '?' + para
    })
}

// Formatter

function favoriFormatter(value, row) {
    return '<i class="' + getFavoriHtml(value) + '"></i> '
}

function getFavoriHtml(value) {
    return value == 1 ? "bi bi-star-fill" : "bi bi-star"
}

function dateFormatter(value, row) {
    var a = moment(value)
    return a.format('DD/MM/YYYY HH:mm:ss') + '  (' + moment().diff(a, 'days') + ')'

}
