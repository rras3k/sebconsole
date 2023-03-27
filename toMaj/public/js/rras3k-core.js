
// -------------------------------- alerte
var alerte_delai = 2000
const alerte = (message, type = "success", delai = 2000) => {
	// console.log(type)
	const wrapper = document.createElement('div')
	wrapper.innerHTML = [
		`<div class="alert alert-${type} alert-dismissible" role="alert">`,
		`   <div>${message}</div>`,
		'   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>',
		'</div>'
	].join('')
	sucessElt = document.querySelector('#rras3k-alerte')
	sucessElt.append(wrapper)

	if (delai != 0) {
		alerte_delai = delai
		setTimeout(function () {
			document.querySelector('#rras3k-alerte').lastChild.remove()
		}, alerte_delai)
	}
}
function showAlertes(alertes = null) {
	if (alertes) {
		alertes.forEach(element => {
			// console.log(element)
			alerte(element.texte, element.type)
		});
	}
}


// ------------------------------- XHR
function spin(pthis) {
	a = pthis.querySelector('.spinOff')
	alerte(a)
	a.classList.remove('spinOff')
}


// ------------------------------- XHR
/*
contentType = "text/plain",'application/json'
*/
function rras3k_xhr(method, url, data, contentType = "text/plain", fctCallback = null, token = null) {

	if (method == "POST" || method == "PUT") {

		console.log(data)
		fetch(url, {
			method: method,
			headers: {
				"Content-type": contentType,
				'X-CSRF-TOKEN': token
			},
			body: JSON.stringify(data)
		})
			.then((response) => response.json())
			.then((data) => {
				if (fctCallback != null) {
					alerte("réponse ok !!!")

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

	if (method == "GET") {
		// console.log(data)
		fetch(url + arrayToPara(data), {
			method: method,
			headers: {
				"Content-type": contentType,
				'X-CSRF-TOKEN': token
			},
		})
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
}

function arrayToPara(data) {
	var ret = ''
	for (var element in data) {
		if (ret == "") {
			ret += '?' + element + "=" + data[element]
		}
		else {
			ret += '&' + element + "=" + data[element]
		}
	}
	return ret
}
function route(routeStr, values) {
	var routeRet = ''
	var indice = 0
	var posit
	var PARA_ROUTE = '999'
	var indcideValues = 0
	while ((posit = routeStr.indexOf(PARA_ROUTE, indice)) > -1) {
		routeRet += routeStr.substring(indice, posit) + values[indcideValues]
		indice = posit + PARA_ROUTE.length
		indcideValues++
	}
	routeRet += routeStr.substring(indice)
	return routeRet
}
