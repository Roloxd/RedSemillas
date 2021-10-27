document.addEventListener("DOMContentLoaded", function(event) {
	//console.log(Routing)
	
	console.log("DOM fully loaded and parsed");
	checkBox();
	
	// User New/Edit Tabs
	tabs('.rgcs__nav-link.link-user', '.rgcs__tab.tab-user.active');

	
	
	$('#menu-hamburger').click(function(){	
		$('.menu__popup').slideToggle(200);

		var searchBox = document.getElementById('rgcs__search');
		if(searchBox.className.includes('show')){
			searchBox.classList.remove("show");
		}
	});  
	
	$('.rgcs__srch-filtro').click(function(){
		$('.rgcs__srch-filtro-cont').slideToggle(200);
	});
	
	var searchbtn = document.getElementById('topsearch-outer');
	if(searchbtn !== null){
		searchbtn.addEventListener('click', function(){
			var searchBox = document.getElementById('rgcs__search')
				.classList.toggle('show');

				var menuPopup = document.getElementsByClassName('menu__popup');
				if(menuPopup[0].style.cssText == 'display: block;'){
					menuPopup[0].style.cssText = 'display: none;'
				}
		})
	}
	
	var button = document.getElementById('ajaxButton');
	if(button !== null){
		button.addEventListener('click', function(){
			console.log("try to load ajax");
			loadAjax("ajax");
		})
	}

	catalogueFilters();



});

function triggerAddBtn(){

	var triggerAdd = document.querySelector('.add_TestImage .field-collection-add-button');
	if(triggerAdd != null) {
		triggerAdd.addEventListener('click', function () {
			setTimeout(function () {
				console.log('Trigger Ok')
				loadjscssfile('https://www.tierra-fertil.es/rgcs-app/public/build/app.js', 'js');
			}, 1)
		})
	}
}

// Reload JS when ajax or add element collection
function loadjscssfile(filename, filetype){
	if (filetype=="js"){ //if filename is a external JavaScript file
		var script = document.getElementsByTagName('script');
		for(var i = 0; i < script.length; i++){
			var getAttr = script[i].getAttribute('src')
			if(getAttr == 'build/app.js'){
				script[i].remove();
			}
		}
		var fileref=document.createElement('script')
		console.log(fileref);
		fileref.setAttribute("type","text/javascript")
		fileref.setAttribute("src", filename)
	}
	else if (filetype=="css"){ //if filename is an external CSS file
		var fileref=document.createElement("link")
		fileref.setAttribute("rel", "stylesheet")
		fileref.setAttribute("type", "text/css")
		fileref.setAttribute("href", filename)
	}
	if (typeof fileref!="undefined")
		document.getElementsByTagName("head")[0].appendChild(fileref)
}

/***************************/


function loadAjax(url, setData){
	
	$.ajax({
		url:url,
		type:"POST",
		datatype: "json",
		async:true,
		data: setData,
		success:function(data) {
			console.log(data['instcode']);
			var id = document.getElementById('Passport_donante_codigoDonante');
			var append = document.querySelector('.choices__list--dropdown .cod__instituto-list');
					
			if(data !== null){
				if(data['instcode'].length > 0){
					append.innerHTML = '';
					for(var i = 0; i < data['instcode'].length; i++){
					 append.innerHTML += data['instcode'][i];
					}
				}else{
					append.innerHTML = data['instcode'];
				}
			}
		},
		error: function(jqxhr, status, exception) {
			 console.log('Exception:', exception + jqxhr +status);
		 }
	});
}



function checkBox(){
	
	var get     = document.getElementsByClassName('list_option'); 
	for(var i=0; i<get.length; i++){
		
		get[i].addEventListener('change', function (){
			var index = this.getAttribute('index');
			var getCol  = document.querySelectorAll('tr.list_col-data td.col-'+index);
			var getHead = document.querySelector('tr.list_col-head th.col-'+index);
			 if(this.checked){
				console.log(getCol);
				getHead.classList.add('hide-cell');
				 
				 for(var x =0; x<getCol.length; x++){
				   getCol[x].classList.add('hide-cell');
				 }
			  }else{
				   getHead.classList.remove('hide-cell');
				   
				  for(var x =0; x<getCol.length; x++){
					  getCol[x].classList.remove('hide-cell');
				 }
			  }
		})
	}
}

// CREATE TABS on ADMIN
function tabs(querySelector, active) {
	var getTab = document.querySelectorAll(querySelector);

	if(getTab !== null) {
		for (i = 0; i < getTab.length; i++) {

			getTab[i].addEventListener('click', function () {
				var activeTab = document.querySelector(active);
				var data = this.getAttribute('data');
				var get = document.getElementById('rgcs__tab-' + data);
				//console.log(getTab);
				if (activeTab !== undefined || active !== null) {
					activeTab.classList.remove('active');
				}
				get.classList.add('active');
			})
		}
	}
}

// library Choices.js -------------------------
function setChoices(clase, newClass){

	var get = document.querySelector(clase);
	if(get !== null) {
		var choice = new Choices(get, {
			silent: true,
			position: 'bottom',
			searchResultLimit: 1000,
			classNames: {
				//input: newClass,
				inputCloned: newClass,
				list: newClass + '-list',
			},
		});
	}
}

// CHOICES.JS Input Tags STYLE
function inputChoices(clase, newClass){

	var get = document.querySelector(clase);
	//console.log(get);
	if(get !== null) {
		var choice = new Choices(get,
			{
				delimiter: ',',
				editItems: true,
				removeItemButton: true,
			}
		);
	}
}

function formatDate(format, symbol)
{
	var result="";
	var d = new Date();

	if(format == 1){
		result +=
			d.getFullYear()
			+symbol
			+(d.getMonth()+1).toString().padStart(2,0)
			+symbol
			+d.getDate().toString().padStart(2,0);
		return result;

	}else{
		result += d.getDate().toString().padStart(2,0)
			+symbol
			+(d.getMonth()+1).toString().padStart(2,0)
			+symbol
			+d.getFullYear();
		return result;

	}

}

function catalogueFilters(){

 	var btnEnvase = document.getElementById('cat__filter-envases');
 	var btnVariedad = document.getElementById('cat__filter-variedad');
	var btnAdquisicion = document.getElementById('cat__filter-adquisicion');

	if(btnEnvase !== null) {
		btnEnvase.addEventListener('click', function () {
			console.log('ENVASE');

			var css = document.getElementsByClassName('cat__cols-envases');

			for (var i = 0; i < css.length; i++) {
				css[i].classList.add('hide');
			}


		})
	}
	if(btnVariedad !== null) {
		btnVariedad.addEventListener('click', function () {


		})
	}
	if(btnAdquisicion !== null) {
		btnAdquisicion.addEventListener('click', function () {


		})
	}

}

function addCheck(clase){

	var id = clase;
	var pass = document.getElementById(id);
	var check =  document.querySelectorAll('#'+id+' .form-check');
	var getName = document.querySelector('#'+id+' .form-check input');
	var get = document.getElementById('newCheck');
	var add = document.getElementById('addNewCheck');
	var length = check.length;

	var div = document.createElement('div');
		div.className = 'form-check fadeEffect';

	var checkbox = document.createElement('input');
		checkbox.type = 'checkbox';
		checkbox.id = id+'_'+length;
		checkbox.className = 'form-check-input';
		checkbox.name = getName.getAttribute('name');
		checkbox.value = get.value;
		checkbox.checked = true;

	var label = document.createElement('label');
		label.className = 'form-check-label';
		label.htmlFor = id+'_'+length;
		label.appendChild(document.createTextNode(get.value));

	var remove = document.createElement('span');
		remove.className = 'remove';
		remove.innerHTML = '<i class="far fa-times-circle"></i>';

		//this.addEventListener('click', function(){})

		div.appendChild(checkbox);
		div.appendChild(label);
		//div.appendChild(remove);

		if(get.value !== ''){

			pass.appendChild(div);
		}

	get.value = '';

}


$( document ).ready(function() {
  // ADD NEW COLLECTION
	/*
    $('.add-another-collection-widget').click(function (e) {
        var list = $($(this).attr('data-list-selector'));
        // Try to find the counter of the list or use the length of the list
        var counter = list.data('widget-counter') || list.children().length;

        // grab the prototype template
        var newWidget = list.attr('data-prototype');
        // replace the "__name__" used in the id and name of the prototype
        // with a number that's unique to your emails
        // end name attribute looks like name="contact[emails][2]"
        newWidget = newWidget.replace(/__name__/g, counter);
        // Increase the counter
        counter++;
        // And store it, the length cannot be used if deleting widgets is allowed
        list.data('widget-counter', counter);

        // create a new list element and add it to the list
        var newElem = $(list.attr('data-widget-tags')).html(newWidget);
        newElem.appendTo(list);
    });
	*/


});




/*
// Coordinates Format
function latDD2DMS(latitud){
	var lat = latitud;
	var latn = Math.abs(lat); /!* Devuelve el valor absoluto de un número, sea positivo o negativo *!/
	var latgr = Math.floor(latn * 1); /!* Redondea un número hacia abajo a su entero más cercano *!/
	var latmin = Math.floor((latn - latgr) * 60); /!* Vamos restando el número entero para transformarlo en minutos *!/
	var latseg = ((((latn - latgr) * 60) - latmin) * 60); /!* Restamos el entero  anterior ahora para segundos *!/
	var latc = (latgr + "º " + latmin + "\' " + latseg.toFixed(3) + '\"'); /!* Prolongamos a centésimas de segundo *!/

	if (lat > 0) {
		x = latc + ' N'; /!* Si el número original era positivo, es Norte *!/
	} else {
		x = latc + ' S'; /!* Si el número original era negativo, es Sur *!/
	} /!* Repetimos el proceso para la longitud (Este, -W-Oeste) *!/

	return x;
	console.log(x)
}

function lngDD2DMS(longitud){
	var lng = longitud;
	var lngn = Math.abs(lng);
	var lnggr = Math.floor(lngn * 1);
	var lngmin = Math.floor((lngn - lnggr) * 60);
	var lngseg = ((((lngn - lnggr) * 60) - lngmin) * 60);
	var lngc = (lnggr + "º " + lngmin + "\' " + lngseg.toFixed(3) + '\"');
	if (lng > 0) {
		y = lngc + ' E';
	} else {
		y = lngc + ' W';
	}
	return y;
	console.log(y)
}
*/
