
// -------------------------------- alerte

const alerte = (message, type) => {
	const wrapper = document.createElement('div')
	wrapper.innerHTML = [
		`<div class="alert alert-${type} alert-dismissible" role="alert">`,
		`   <div>${message}</div>`,
		'   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>',
		'</div>'
	].join('')
	document.getElementById('rras3k-alerte').append(wrapper)
}
function showAlertes(alertes = null) {
	if (alertes) {
		alertes.forEach(element => {
			console.log(element)
			alerte(element.texte, element.type)
		});
	}
}
