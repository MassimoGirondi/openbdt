
function testpass(modulo){
  // Verifico che il campo password sia valorizzato in caso contrario
  // avverto dell'errore tramite un Alert
  if (modulo.password1.value == ""){
    alert("Errore: inserire una password!");
    modulo.password1.focus();
    return false;
  }
  // Verifico che le due password siano uguali, in caso contrario avverto
  // dell'errore con un Alert
  if (modulo.password1.value != modulo.password2.value) {
    alert("Le due password non coincidono!");
    modulo.password1.focus();
    modulo.password1.select();
    return false;
  }
  if(modulo.password1.value.length<6)
  {
    alert("Lunghezza minima 6 caratteri!!");
    modulo.password1.focus();
    modulo.password1.select();
    return false;
  }
  return true
}

function toggle(source) {
  checkboxes = document.getElementsByName('check[]');
  for(var i=0, n=checkboxes.length;i<n;i++) {
    checkboxes[i].checked = source.checked;
  }
}

/*
( function( $ ) {
$( document ).ready(function() {
$('#cssmenu').prepend('<div id="indicatorContainer"><div id="pIndicator"><div id="cIndicator"></div></div></div>');
    var activeElement = $('#cssmenu>ul>li:first');

    $('#cssmenu>ul>li').each(function() {
        if ($(this).hasClass('active')) {
            activeElement = $(this);
        }
    });


	var posLeft = activeElement.position().left;
	var elementWidth = activeElement.width();
	posLeft = posLeft + elementWidth/2 -6;
	if (activeElement.hasClass('has-sub')) {
		posLeft -= 6;
	}

	$('#cssmenu #pIndicator').css('left', posLeft);
	var element, leftPos, indicator = $('#cssmenu pIndicator');
	
	$("#cssmenu>ul>li").hover(function() {
        element = $(this);
        var w = element.width();
        if ($(this).hasClass('has-sub'))
        {
        	leftPos = element.position().left + w/2 - 12;
        }
        else {
        	leftPos = element.position().left + w/2 - 6;
        }

        $('#cssmenu #pIndicator').css('left', leftPos);
    }
    , function() {
    	$('#cssmenu #pIndicator').css('left', posLeft);
    });

	$('#cssmenu>ul').prepend('<li id="menu-button"><a>Menu</a></li>');
	$( "#menu-button" ).click(function(){
    		if ($(this).parent().hasClass('open')) {
    			$(this).parent().removeClass('open');
    		}
    		else {
    			$(this).parent().addClass('open');
    		}
    	});
});
} )( jQuery );

function checkDate(){
  if(!document.getElementById || !document.createTextNode){return;}
  var dateField=document.getElementById('date');
  if(!dateField){return;}
  var errorContainer=dateField.parentNode.getElementsByTagName('span')[0];
  if(!errorContainer){return;}
  var checkPattern=new RegExp("\\d{2}/\\d{2}/\\d{4}");
  var errorMessage='';
  errorContainer.firstChild.nodeValue=' ';
  var dateValue=dateField.value;
  if(dateValue==''){
    errorMessage='Inserire una data.';
  } else if(!checkPattern.test(dateValue)){
    errorMessage='Inserire una data nel formato definito.';
  }
  if(errorMessage!=''){
    errorContainer.firstChild.nodeValue=errorMessage;
    dateField.focus();
    return false;
  }else{
    return true;
  }
}*/
function check_data()
{
    var d=document.getElementById("data").value;
    var reg=new RegExp("^[0-9]{4}\-[0-9]{2}\-[0-9]{2}$");

    var a= reg.test(d);
    if(!a)
        alert("Formato data errato!,\nInserire la data nel formato corretto\n(giorno/mese/anno su Chrome,anno-mese-giorno su altri browser)");
    //alert(document.getElementById("data").value);
    return a;


}
function check_cf()
{
//    return true;
    
    var d=document.getElementById("cf").value;
    var reg=new RegExp("[a-zA-Z]{6}[0-9]{2}[a-zA-Z][0-9]{2}[a-zA-Z][0-9]{3}[a-zA-Z]");

    var a= reg.test(d);
    if(!a)
        alert("Formato Codice Fiscale errato!");
   // alert(document.getElementById("data").value);
    return a;
}
function cerca_abilita()
{
    var cerco=document.getElementById("testo").value.toUpperCase();
    var t=document.getElementById("abilita");
    for(var i=1,l=t.rows.length;i<l;i++)
    { var r= t.rows[i];
      if(r.innerHTML.toUpperCase().indexOf(cerco)==-1)
          r.style.display='none';
      else
          r.style.display="";
    }
    
}
function conferma(testo,url)
{
    if(confirm(testo))
        document.location=url;
}
function check_abilita_altro()
{
    var val=document.getElementById("cat").value;
    if(val[0]=='0')
    {
        document.getElementById("note").setAttribute("required","required"); 
    }
    else
    {
        document.getElementById("note").removeAttribute("required");  
    }
   // alert(val);
}
function check_abilita_altro2()
{
    var val=document.getElementById("cat").value;
    if(val[0]=='0')
    {
        document.getElementById("descrizione").setAttribute("required","required"); 
        //document.getElementById("descrizione").removeAttribute("readonly","false"); 
    }
    else
    {
        document.getElementById("descrizione").removeAttribute("required");  
        //document.getElementById("descrizione").setAttribute("readonly","true");
    }
}
//$("#cercaabilita").keyup(function() {
//	var rows = $("#abilitas_body").find("tr").hide();
//	var data = this.value.split(" ");
//	$.each(data, function(i, v) {
//		rows.filter(":contains('" + v + "')").show();
//	});
//});
//
//function cercaJquery(d) {
//var rows = $("#abilitas_body").find("tr").hide();
//var data = d.value.split(" ");
//$.each(data, function(i, v) {
//        rows.filter(":contains('" + v + "')").show();
//});
//}
//        
//        
//function cercaJQuery2(d)
//{
//var rows = $("#abilitas_body").find("tr");
//var data = d.value.split(" ");
//$.each(data, function(i, v) {
//        rows.css("display","none");
//        rows.filter(":contains('" + v + "')").css("display", "");
//});         
//}

function cerca2()
{
    var cerco=document.getElementById("cercaabilita").value.toUpperCase();
    //alert(cerco);    
    
    var t=document.getElementById("abilitas_body");
    for(var i=0,l=t.rows.length;i<l;i++)
    { var r= t.rows[i];
      var h="";
      
        for (var c = 0; c < 4; c++) {
                h+=r.cells[c].innerHTML+" ";
      }        
      h=h.toUpperCase();
      //alert(h);
      if(h.indexOf(cerco)==-1)
         r.style.display='none';
           //  killrow(i);
      else
         r.style.display="";
         //   recoverrow(i);
    }
    
    
}



//var cache = {};
//var t=document.getElementById("abilitas_body");
//var rows = t.rows;
//function killrow(i) {
//  cache[i] = rows[i]; 
//  rows[i].remove();
//}
//function recoverrow(i) {
//  var addto = i+1;
//  if (i === 0) {
//    t.insertBefore(cache[i],t.firstChild);
//  }
//  if (i === rows.length) {
//    t.appendChild(cache[i]);
//  }
//  while (cache[addto]) {
//    addto++;
//  }
//  t.insertBefore(cache[i],rows[addto]);
//  delete cache[i];
//}
function dettagli_abilita(id)
{
    var xhr = new XMLHttpRequest();
xhr.onreadystatechange = function() {
    if (xhr.readyState == 4) {
        alert(xhr.responseText);
    }
}
xhr.open('GET', './dettagli_abilita.php?id='+id, true);
xhr.send(null);
}