class rras3k_modal {
    modalHtmlId = null
    mode = null

    constructor(modalHtmlId, mode = null) {
        this.modalHtmlId = modalHtmlId
        this.mode = mode
        this.clean()
    }

    clean() {
        document.querySelector('#' + this.modalHtmlId + ' .modal-title').innerHTML = ''     // efface le titre
        document.querySelector('#' + this.modalHtmlId + ' .modal-body').innerHTML = ''      // efface le corps
        document.querySelector('#' + this.modalHtmlId + ' .modal-footer').innerHTML = ''    // efface le footer
    }

    corps(text) {
        document.querySelector('#' + this.modalHtmlId + ' .modal-body').innerHTML = text
    }

    footer_button_add(btns) {
        var eltFooter = document.querySelector('#' + this.modalHtmlId + ' .modal-footer')
        var tmp = ''
        btns.forEach(element => {
            element.onclick = element.onclick ? ' onclick=' + element.onclick + '() ' : ''
            console.log(element.label)
            tmp += '<button type="button" ' + element.onclick + ' class="btn ' + element.class + '" data-bs-dismiss="modal">' + element.label + '</button>'
        });
        eltFooter.innerHTML = tmp
    }
    header(titre) {
        document.querySelector('#' + this.modalHtmlId + ' .modal-title').innerHTML = titre

    }


    show() {
        var mModal = new bootstrap.Modal(document.getElementById('myModal'), {})
        mModal.show()
    }

}
