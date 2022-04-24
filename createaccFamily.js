  async function callBackend() {

      firstName = document.getElementById('FN').value;
      lastName = document.getElementById('LN').value;
      email = document.getElementById('email').value;
      address = document.getElementById('address').value;
      model = document.getElementById('model').value;
      username = document.getElementById('username').value;
      password = document.getElementById('password').value;
      
      var alphaRegEx = /^[A-Za-z]+$/;
      var alphaNRegEx = /^[0-9a-zA-Z]+$/;
      if (!firstName.match(alphaRegEx) || !lastName.match(alphaRegEx)) {
	  document.getElementById('output1').innerHTML = '<span style=color:red;>First and last name must consist of letters only!</span>';
	  return;
      }
	if (!username.match(alphaNRegEx)) {
	  document.getElementById('output1').innerHTML = '<span style=color:red;>Username must consist of letters only!</span>';
	  return;
      }
      if ((firstName.length < 2) || (lastName.length < 2)) {
	  document.getElementById('output1').innerHTML = '<span style=color:red;>First and last name must exceed one character!</span>';
	  return;
      }

      let myResponse = await fetch("familyinfo.php", {
	  method: 'POST',
	  headers: {'Accept': 'application/json', 'Content-Type': 'application/json'},
	  body: JSON.stringify({firstName: firstName, lastName: lastName, email: email, address: address, model: model, username: username, password: password, AF1: af1, AF2: af2})
	  });
      let result = await myResponse.json();
      let output = JSON.stringify(result);
      
	if (output == '{"status":false,"info":"Existing User"}'){
	    document.getElementById('output1').innerHTML = "Failed to create membership: EXISTING MEMBER";
      }
	else{
      	    var obj = JSON.parse(output)
	    var values = Object.keys(obj).map(function (key) { return obj[key]; });
	    nameString = values.join();
	    outputMessage = nameString.replace(/,/g, '') + " membership has been ACTIVATED"
	    document.getElementById('output1').innerHTML = outputMessage;
      }
    
  }