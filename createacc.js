  async function callBackend() {

      firstName = document.getElementById('FN').value;
      lastName = document.getElementById('LN').value;
      var alphaRegEx = /^[A-Za-z]+$/;
      if (!firstName.match(alphaRegEx) || !lastName.match(alphaRegEx)) {
	  document.getElementById('output1').innerHTML = '<span style=color:red;>First and last name must consist of letters only!</span>';
	  return;
      }
      if ((firstName.length < 2) || (lastName.length < 2)) {
	  document.getElementById('output1').innerHTML = '<span style=color:red;>First and last name must exceed one character!</span>';
	  return;
      }

      let myResponse = await fetch("userinfo.php", {
	  method: 'POST',
	  headers: {'Accept': 'application/json', 'Content-Type': 'application/json'},
	  body: JSON.stringify({firstName: firstName, lastName: lastName})
	  });
      let result = await myResponse.json();
      document.getElementById('output1').innerHTML = JSON.stringify(result);
    
  }