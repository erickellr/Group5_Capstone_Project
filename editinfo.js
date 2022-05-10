  async function editInfo() {

      username = document.getElementById('username').value;
      firstName = document.getElementById('FN').value;
      lastName = document.getElementById('LN').value;
      email = document.getElementById('email').value;
      street = document.getElementById('street').value;
	  city = document.getElementById('city').value;
	  state = document.getElementById('state').value;
	  zip = document.getElementById('zip').value;
      
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

      let myResponse = await fetch("editinfo.php", {
	  method: 'POST',
	  headers: {'Accept': 'application/json', 'Content-Type': 'application/json'},
	  body: JSON.stringify({username: username, firstName: firstName, lastName: lastName, email: email, street: street, city: city, state: state, zip: zip})
	  });
      let result = await myResponse.json();
      let output = JSON.stringify(result);
	document.getElementById('output1').innerHTML = output;
    
  }