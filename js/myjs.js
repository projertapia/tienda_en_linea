// JavaScript Document
var pathArray = window.location.pathname.split('/');
var secondLevelLocation = pathArray[1];
//console.log(secondLevelLocation);
switch (secondLevelLocation) {
    case 'entrar':
        $('#btn-cuenta').addClass('active');
        break;
	case 'mi-cuenta':
        $('#btn-cuenta').addClass('active');
        break;
	case 'mis-direcciones':
        $('#btn-cuenta').addClass('active');
        break;
	case 'mis-compras':
        $('#btn-cuenta').addClass('active');
        break;
    case 'carrito':
        $('#btn-carrito').addClass('active');
        break;
	case 'influencers':
        $('#btn-influencers').addClass('active');
        break;
    case 'empresas':
        $('#btn-empresas').addClass('active');
        break;
	case 'profesionales':
        $('#btn-profesionales').addClass('active');
        break;
	case 'favoritos':
        $('#btn-fav').addClass('active');
        break;
	case 'buscar':
        $('#buscar').addClass('active');
        break;
    default: 
        $('#btn-inicio').addClass('active');
}

//CLICK ADS

function adsclick(idpromo,tipopromo){
	var http=window.location.protocol;
	var host=window.location.hostname;
	//event.preventDefault()
	//console.log(http+'//'+host+"/elpais/functions/clicks-ads.php?idpublicidad="+idpromo+"&tipopublicidad="+tipopromo);
	$.ajax({
		//url: http+'//'+host+"/elpais/functions/clicks-ads.php?idpublicidad="+idpromo+"&tipopublicidad="+tipopromo,
		//url: http+'//'+host+"/avances/functions/clicks-ads.php?idpublicidad="+idpromo+"&tipopublicidad="+tipopromo,
		url: http+'//'+host+"/functions/clicks-ads.php?idpublicidad="+idpromo+"&tipopublicidad="+tipopromo,
		success: function(click) {
			//var link = $("#promo"+tipopromo+idpromo).attr("href");
			//console.log(click);
			//window.location.href = link;
		},
		error: function(click) {
			console.log(click);
		}
	});
}
//document.oncontextmenu = function(){return false}
	
//'use strict';

/*document.addEventListener('keydown', (event) => {
  const keyName = event.key;
  if(keyName == '123'){
	  //
  };
});*/