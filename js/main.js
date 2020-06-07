function validate_st_login(){
	"use strict";
	//var name=document.getElementById("id").value;
	//var validname=/^[a-zA-Z][a-zA-Z ]*[a-zA-Z]$/;
	if(!/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(document.getElementById("mail").value)){
		alert("Invalid E-Mail.");
                return;
	} 
	
}

function st_reg_valid(){
	"use strict";
	var validname=/^[a-zA-Z][a-zA-Z ]*[a-zA-Z]$/;
	if(!(document.getElementById("fname").value).match(validname)){
		alert("Invalid fname");
                return;
	}
	else if(!(document.getElementById("lname").value).match(validname)){
		alert("Invalid lname");
                return;
	} 
	else if(!(document.getElementById("father_name").value).match(validname)){
		alert("Invalid Father's name");
                return;
	} 
	else if(!(document.getElementById("mother_name").value).match(validname)){
		alert("Invalid Mother's name");
                return;
	}
	else if(!/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(document.getElementById("email").value)){
		alert("Invalid E-Mail.");
                return;
	} 
	else if(!(document.getElementById("pin").value).match(/^\d+$/)){
		alert("Invalid Pin.");
                return;
	}
	else if(!(document.getElementById("mobile").value).match(/^0?[1-9]{10}/)){
		alert("Invalid mobile Number.");
                return;
	}
	else if(!document.getElementById("pass").value==document.getElementById("re_pass").value){
            alert("Password not match");
            return;
        }
        //register
	
}

function add_field(){
	"use strict";
	var el=document.createAttribute("TD");
	 var x = document.createTextNode("INPUT");
  x.setAttribute("type", "text");
  x.setAttribute("value", "Hello World!");
	
  document.body.appendChild(x);
}


function insertRow(x,y){
			"use strict";
	var parenttbl = document.getElementById(x);
var newel = document.createElement('td');
var elementid = document.getElementsByTagName("td").length;
newel.setAttribute('id',elementid);
newel.innerHTML = "<input type='text'></input>";
	var tr=document.createElement("INPUT");
	tr.setAttribute("type","text");
        tr.setAttribute("name",y+"[]");
	parenttbl.appendChild(tr);

}
function delrow(x){
	"use strict";
	var parenttbl = document.getElementById(x);
	parenttbl.removeChild(parenttbl.lastChild);
}

function confirm(){
	var otp=prompt("Enter OTP:","");
	if(top!=null){
		//validating OTP
		
	}
}