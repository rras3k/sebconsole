
// -------------------------------- alerte

const alerte = (message, type = "success") => {
	console.log(type)
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


// XHR
/*
contentType = "text/plain",'application/json'
*/
function rras3k_xhr(type, url, data, contentType = "text/plain", fctCallback = null) {	
	para = {
		method: type,
		headers: {
			"Content-type": contentType
		}
		}
	if(type == "POST") {
		para['body'] = JSON.stringify(data)
	}
	
	fetch(url, {para})
		.then((response) => response.json())
		.then((data) => {
			if (fctCallback != null) {
				fctCallback(data)
			}
			else {
				alerte("réponse ok")
				alerte(JSON.stringify(data))
				
			}
			
		})
		.catch((erreur) => { 
			alerte(erreur)
		}
		);
	
	
}