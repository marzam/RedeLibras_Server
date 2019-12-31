function user_update(){
  var str = document.getElementById("id_txtName").value;
  document.getElementById("id_txtName").value = str.toUpperCase();
  var flag = document.getElementById("id_user_update").value;
  if (flag == "0"){
      document.getElementById("id_user_update").value = "U";
  }

}

function post_script(path, params, method='post') {

  // The rest of this code assumes you are not using a library.
  // It can be made less wordy if you use one.
  const form = document.createElement('form');
  form.method = method;
  form.action = path;

  for (const key in params) {
    if (params.hasOwnProperty(key)) {
      const hiddenField = document.createElement('input');
      hiddenField.type = 'hidden';
      hiddenField.name = key;
      hiddenField.value = params[key];

      form.appendChild(hiddenField);
    }
  }

  document.body.appendChild(form);
  form.submit();
}

function setCookie(cname, cvalue, exdays) {
  var d = new Date();
  d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
  var expires = "expires="+d.toUTCString();
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
  var name = cname + "=";
  var ca = document.cookie.split(';');
  for(var i = 0; i < ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}

function delCookie( cname ) {
  document.cookie = cname + '=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
}

function getStateValue(){
  var object = document.getElementById("id_selState");
  var len = object.options.length;
  var opt;
  for ( var i = 0; i < len; i++ ) {
          opt = object.options[i];
          if ( opt.selected === true ) {
              i = len;
          }
  }

//  alert(opt.value + " " + opt.text);
  var ret = opt.value;
  return ret;

//

}

function setStateValue(element){
    var object = document.getElementById("id_selState");
    object.value = element;
}

function login(){
  alert("login");
}

function logout(){
  alert("logout");
}

function record(){
  alert("cadastro");
}

function services(){
  alert("Serviços");
}
/*
function connect(){
  var xmlHttp = new XMLHttpRequest();
  var params = "lorem=ipsum&name=binny";

  xmlHttp.open("POST", "https://192.168.1.11/demo.php", true); // true for asynchronous
  //xmlHttp.setRequestHeader('Content-type', 'text/xml');
  xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

  xmlHttp.onreadystatechange = function() {
     var ret = xmlHttp.readyState;
     alert("http state: " + ret.toString(10));

 }
 xmlHttp.send(params);
// xmlHttp.send(null);

}
*/

function getASCII(msg){
  var nMsg = "";
  for (var i = 0; i < msg.length; i++){
    var sright = "00" + msg.charCodeAt(i);
//    str.substring(str.length - 3, str.length);
    nMsg += sright.substring(sright.length - 3, sright.length);

  }

  return nMsg;
}
function destroyClickedElement(event) { document.body.removeChild(event.target); }
function sendXML(){
  var doc = document.implementation.createDocument("", "", null);
  var record = doc.createElement("record");
  var name   = getASCII(document.getElementById('id_txtName').value) ;
  var login  = getASCII(document.getElementById('id_txtLogin').value) ;
  var passwd = getASCII(document.getElementById('id_Txtpasswd').value) ;

  var userdata = doc.createElement("user-data");
  userdata.setAttribute("name", name);
  userdata.setAttribute("login", login);
  userdata.setAttribute("passwd", passwd);
  record.appendChild(userdata);

  var size = parseInt(document.getElementById('id_numAddrs').value);
  var curr = parseInt(document.getElementById('id_curAddrs').value);
  for (var i = 1 ; i <= size; i++){
    document.getElementById('id_curAddrs').value = i.toString();
    loadCurrentAddr();
    var userAddr     = doc.createElement("user-Addr");
    var addr         = getASCII(document.getElementById('id_txtAddr').value) ;
    var addrMore     = getASCII(document.getElementById('id_txtAddrAdd').value) ;
    var neighborhood = getASCII(document.getElementById('id_txtNeighborhood').value) ;
    var state        = getASCII(getStateValue());
    var city         = getASCII(document.getElementById('id_txtAddr').value) ;
    userAddr.setAttribute("addr", addr);
    userAddr.setAttribute("addrMore", addrMore);
    userAddr.setAttribute("neighborhood", neighborhood);
    userAddr.setAttribute("state", state);
    userAddr.setAttribute("city", city);
    record.appendChild(userAddr);



  }

  document.getElementById('id_curAddrs').value = curr.toString();
  loadCurrentAddr();

  var phone = document.getElementById('id_userphonelist');
  for (var i = 0; i <  phone.rows.length; i++){
    var index = "";
    if (i > 0)
      index = i.toString();

    var id       = getASCII(document.getElementById('idPhone'+index).value) ;
    var number   = getASCII(document.getElementById('txtPhone'+index).value) ;
    var xmlPhone = doc.createElement("user-phone");
    xmlPhone.setAttribute("id", id);
    xmlPhone.setAttribute("number", number);
    record.appendChild(xmlPhone);
  }

  var email = document.getElementById('id_useremaillist');
  for (var i = 0; i < email.rows.length; i++){
    var index = "";
    if (i > 0)
      index = i.toString();
    var id         = getASCII(document.getElementById('idEmail'+index).value) ;
    var txtEmail   = getASCII(document.getElementById('txtemail'+index).value) ;
    var xmlEmail = doc.createElement("user-email");
    xmlEmail.setAttribute("id", id);
    xmlEmail.setAttribute("email", txtEmail);
    record.appendChild(xmlEmail);
  }

  doc.appendChild(record);

  var xmlHttp = new XMLHttpRequest();
  xmlHttp.open("POST", "https://192.168.1.11/demo.php", true); // true for asynchronous
  //"application/x-www-form-urlencoded
  xmlHttp.setRequestHeader('Content-type', 'application/xml; charset=utf-8');

  var myXML = new XMLSerializer();
  var msg = myXML.serializeToString(doc);
  alert(msg);
  xmlHttp.send(msg);
/*
var textToSave =   new XMLSerializer().serializeToString(doc);
var textToSaveAsBlob = new Blob([textToSave], {type:"text/xml"});
var textToSaveAsURL = window.URL.createObjectURL(textToSaveAsBlob);
var fileNameToSaveAs = "def.xml";

var downloadLink = document.createElement("a");
downloadLink.download = fileNameToSaveAs;
downloadLink.innerHTML = "Download File";
downloadLink.href = textToSaveAsURL;
downloadLink.onclick = destroyClickedElement;
downloadLink.style.display = "none";
document.body.appendChild(downloadLink);

downloadLink.click();
*/
alert("fim");
}

function addAddr(){
  document.getElementById('id_txtAddr').value = "";
  document.getElementById('id_txtAddrAdd').value = "";
  document.getElementById('id_txtNeighborhood').value = "";
  document.getElementById('id_txtCity').value = "";
  document.getElementById('id_IDADDR').value = -1;

  document.getElementById('id_btnPrevAddr').disabled = true;
  document.getElementById('id_btnAddAddr').disabled = true;
  document.getElementById('id_btnDelAddr').disabled = true;
  document.getElementById('id_btnNextAddr').disabled = true;

  document.getElementById('id_btnOKAddr').disabled = false;
  document.getElementById('id_btnCancelAddr').disabled = false;

  document.getElementById('id_txtAddr').focus();
}

function addPhone(){
  document.getElementById('id_txtAddr').value = "";

  document.getElementById('id_txtAddr').focus();
}
//Remove addr
function delAddr(){
  var size = parseInt(document.getElementById('id_numAddrs').value);
  var curr = parseInt(document.getElementById('id_curAddrs').value);
  if (size == 0)
    return;

  for (var i = curr ; i < size; i++){

    var cookieNamei = "addr-" + i.toString(10);
    var cookieNamei1 = "addr-" + (i+1).toString(10);
    var values =  getCookie(cookieNamei1);
    setCookie(cookieNamei, values);


  }
  delCookie("addr-" + size.toString(10));
  size--;
  if (size < 0)
    size = 0;
  curr = size;

  document.getElementById('id_numAddrs').value = size.toString(10);
  document.getElementById('id_curAddrs').value = curr.toString(10);
  loadCurrentAddr();
}

//go to the next addr
function nextAddr(){
  var size = parseInt(document.getElementById('id_numAddrs').value);
  var curr = parseInt(document.getElementById('id_curAddrs').value);
  curr++;
  if (curr > size)
    return;

  document.getElementById('id_curAddrs').value =  curr.toString(10);
  loadCurrentAddr();
}

//go to back or previous addr
function prevAddr(){
  var size = parseInt(document.getElementById('id_numAddrs').value);
  var curr = parseInt(document.getElementById('id_curAddrs').value);
  curr--;
  if (curr < 1)
    return;

  document.getElementById('id_curAddrs').value =  curr.toString(10);
  loadCurrentAddr();
}

//load on form the current addr
function loadCurrentAddr(){
  var size = parseInt(document.getElementById('id_numAddrs').value);
  var curr = parseInt(document.getElementById('id_curAddrs').value);
  if (curr > size)
    return;
//  alert(curr);
  var cookieName = "addr-" + curr.toString(10);
  var values =  getCookie(cookieName);
  var fields =  values.split("|");
  document.getElementById('id_IDADDR').value          = fields[0].trim();
  document.getElementById('id_txtAddr').value         = fields[1].trim();
  document.getElementById('id_txtAddrAdd').value      = fields[2].trim();
  document.getElementById('id_txtNeighborhood').value = fields[3].trim();
  setStateValue(fields[4].trim());
  document.getElementById('id_txtCity').value         = fields[5].trim();

}



//confirm addr, saving on cookie. This is not saved inside the DB
function confirmAddr(){
  var myaddr = document.getElementById('id_IDADDR').value + " |";
  myaddr    += document.getElementById('id_txtAddr').value + " |";
  myaddr    += document.getElementById('id_txtAddrAdd').value + " |";
  myaddr    += document.getElementById('id_txtNeighborhood').value + " |";
  myaddr    += getStateValue() + " |";
  myaddr    += document.getElementById('id_txtCity').value + " |";

  //alert(myaddr);

  var lastAddr = parseInt(document.getElementById('id_numAddrs').value);
  lastAddr++;

//  alert("Quantidade de endereços: " + lastAddr.toString(10));

  document.getElementById('id_numAddrs').value =  lastAddr.toString(10);
  document.getElementById('id_curAddrs').value =  lastAddr.toString(10);

  var cookieName = "addr-" + lastAddr.toString(10);
  setCookie(cookieName, myaddr);


  document.getElementById('id_btnOKAddr').disabled = true;
  document.getElementById('id_btnCancelAddr').disabled = true;

  document.getElementById('id_btnPrevAddr').disabled = false;
  document.getElementById('id_btnAddAddr').disabled = false;
  document.getElementById('id_btnDelAddr').disabled = false;
  document.getElementById('id_btnNextAddr').disabled = false;
  loadCurrentAddr();
}

//cancel during the typing addr
function cancelAddr(){
  document.getElementById('id_IDADDR').value  = "";
  document.getElementById('id_txtAddr').value = "";
  document.getElementById('id_txtAddrAdd').value = "";
  document.getElementById('id_txtNeighborhood').value = "";
  document.getElementById('id_txtCity').value = "";

  document.getElementById('id_btnOKAddr').disabled = true;
  document.getElementById('id_btnCancelAddr').disabled = true;

  document.getElementById('id_btnPrevAddr').disabled = false;
  document.getElementById('id_btnAddAddr').disabled = false;
  document.getElementById('id_btnDelAddr').disabled = false;
  document.getElementById('id_btnNextAddr').disabled = false;

}
/*
<button id="id_hidebutton_userdata" type="button" onClick = "hideObject('id_userdata', 'id_hidebutton_userdata', 'id_showbutton_userdata');">-</button>
<button id="id_showbutton_userdata" type="button" onClick = "showObject('id_userdata', 'id_hidebutton_userdata', 'id_showbutton_userdata' );">+</button>
*/

function onload(){
    document.getElementById('id_showbutton_userdata').classList.add('hide');
    document.getElementById('id_showbutton_useraddr').classList.add('hide');
    document.getElementById('id_showbutton_userphone').classList.add('hide');
    document.getElementById('id_showbutton_useremail').classList.add('hide');

    document.getElementById('id_btnOKAddr').disabled = true;
    document.getElementById('id_btnCancelAddr').disabled = true;
    //document.getElementById('id_btnOKAddr').classList.add('hide');


}

function insAndSetRow(object_id, element_id, element_value){
//  document.getElementById('idPhone'+index).value =  id;
//  document.getElementById('txtPhone'+index).value = number;
  //alert(number + " - " + id + " - " + index);
  var x       = document.getElementById(object_id);
  var new_row = x.rows[0].cloneNode(true);
  var len     = x.rows.length;
  var inp1    = new_row.cells[0].getElementsByTagName('input')[0];
  inp1.id += len;
  inp1.value = element_id;
  var inp2    = new_row.cells[1].getElementsByTagName('input')[0];
  inp2.id += len;
  inp2.value = element_value;
  alert(inp2.id);

  x.appendChild( new_row );

}

/* Inserting new row on the table. Two fields: database record ID and its value */
function insRow(object_id){
    var x       = document.getElementById(object_id);
    var new_row = x.rows[0].cloneNode(true);
    var len     = x.rows.length;

    var inp1    = new_row.cells[0].getElementsByTagName('input')[0];
    inp1.id += len;
    inp1.value = "";

    var inp2    = new_row.cells[1].getElementsByTagName('input')[0];
    inp2.id += len;
    inp2.value = "";
    //alert(">> " + inp1.id);
    x.appendChild( new_row );

}

function delRow(row, object_id){
    var i=row.parentNode.parentNode.rowIndex;
    if (i == 0)
      return;
    document.getElementById(object_id).deleteRow(i);
}

function hideObject(object_id, hide_btn_id, show_btn_id){
  var object   = document.getElementById(object_id);
  var hide_btn = document.getElementById(hide_btn_id);
  var show_btn = document.getElementById(show_btn_id);
  object.classList.add('hide');
  hide_btn.classList.add('hide');
  show_btn.classList.remove('hide');



}

function showObject(object_id, hide_btn_id, show_btn_id){
  var object = document.getElementById(object_id);
  var hide_btn = document.getElementById(hide_btn_id);
  var show_btn = document.getElementById(show_btn_id);


  object.classList.remove('hide');
  hide_btn.classList.remove('hide');
  show_btn.classList.add('hide');

}

function createXML(){
    var doc = document.implementation.createDocument("", "", null);
    var peopleElem = doc.createElement("people");

    var personElem1 = doc.createElement("person");
    personElem1.setAttribute("first-name", "eric");
    personElem1.setAttribute("middle-initial", "h");
    personElem1.setAttribute("last-name", "jung");

    var addressElem1 = doc.createElement("address");
    addressElem1.setAttribute("street", "321 south st");
    addressElem1.setAttribute("city", "denver");
    addressElem1.setAttribute("state", "co");
    addressElem1.setAttribute("country", "usa");
    personElem1.appendChild(addressElem1);

    var addressElem2 = doc.createElement("address");
    addressElem2.setAttribute("street", "123 main st");
    addressElem2.setAttribute("city", "arlington");
    addressElem2.setAttribute("state", "ma");
    addressElem2.setAttribute("country", "usa");
    personElem1.appendChild(addressElem2);

    var personElem2 = doc.createElement("person");
    personElem2.setAttribute("first-name", "jed");
    personElem2.setAttribute("last-name", "brown");

    var addressElem3 = doc.createElement("address");
    addressElem3.setAttribute("street", "321 north st");
    addressElem3.setAttribute("city", "atlanta");
    addressElem3.setAttribute("state", "ga");
    addressElem3.setAttribute("country", "usa");
    personElem2.appendChild(addressElem3);

    var addressElem4 = doc.createElement("address");
    addressElem4.setAttribute("street", "123 west st");
    addressElem4.setAttribute("city", "seattle");
    addressElem4.setAttribute("state", "wa");
    addressElem4.setAttribute("country", "usa");
    personElem2.appendChild(addressElem4);

    var addressElem5 = doc.createElement("address");
    addressElem5.setAttribute("street", "321 south avenue");
    addressElem5.setAttribute("city", "denver");
    addressElem5.setAttribute("state", "co");
    addressElem5.setAttribute("country", "usa");
    personElem2.appendChild(addressElem5);

    peopleElem.appendChild(personElem1);
    peopleElem.appendChild(personElem2);
    doc.appendChild(peopleElem);

    var xmlHttp = new XMLHttpRequest();
    xmlHttp.open("POST", "https://192.168.1.11/demo.php", true); // true for asynchronous
    xmlHttp.setRequestHeader('Content-type', 'text/xml');
    xmlHttp.send(new XMLSerializer().serializeToString(doc));
/*
    var textToSave =   new XMLSerializer().serializeToString(doc);
  	var textToSaveAsBlob = new Blob([textToSave], {type:"text/xml"});
  	var textToSaveAsURL = window.URL.createObjectURL(textToSaveAsBlob);
  	var fileNameToSaveAs = "def.xml";

  	var downloadLink = document.createElement("a");
  	downloadLink.download = fileNameToSaveAs;
  	downloadLink.innerHTML = "Download File";
  	downloadLink.href = textToSaveAsURL;
  	downloadLink.onclick = destroyClickedElement;
  	downloadLink.style.display = "none";
  	document.body.appendChild(downloadLink);

  	downloadLink.click();
*/
    alert("fim");
}
