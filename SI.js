  async function signin() {

      PW = document.getElementById('PW').value;
      console.log(PW);
      var alphaRegEx = /^[A-Za-z]+$/;
      var alphaNRegEx = /^[0-9a-zA-Z]+$/;
      var alphaNRegEx = /^[0-9a-zA-Z]+$/;
            if (!PW.match(alphaNRegEx)) {
	  document.getElementById('output1').innerHTML = '<span style=color:red;>Username must consist of letters & numbers only</span>';
	  return;
      }
	
      if (PW.length < 2) {
	  document.getElementById('output1').innerHTML = '<span style=color:red;>Member last name must exceed one letter</span>';
	  return;
      }
      let myResponse = await fetch("signin.php", {
	  method: 'POST',
	  headers: {'Accept': 'application/json', 'Content-Type': 'application/json'},
	  body: JSON.stringify({PW: PW})
	  });
      let result = await myResponse.json();
      let output = JSON.stringify(result);
      window.globalOutput = output;
      console.log(output)
      
      if (output == '"invalid"'){
	document.getElementById('output1').innerHTML = "Invalid username or password!";
    }else{
	document.getElementById('output1').innerHTML = output;
	var x = document.getElementById("edit");
	x.style.display = "inline";
    }
}
    
async function redirect(siteName) {
   window.location.replace(siteName)
}

async function display(){
    document.getElementById('output1').innerHTML = "Invalid username or password!";
}
