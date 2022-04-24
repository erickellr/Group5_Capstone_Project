  async function siq() {

      username = document.getElementById('UN').value;
      password = document.getElementById('PW').value;
      var alphaNumericRegEx = /^[0-9a-zA-Z]+$/;
      if (!username.match(alphaNumericRegEx)) {
	  document.getElementById('output1').innerHTML = '<span style=color:red;>Login ID must consist of letters and numbers only</span>';
	  return;
      }
      if ((password.length < 1) || (!password.match(alphaNumericRegEx))) {
	  document.getElementById('output1').innerHTML = '<span style=color:red;>Password must not be empty and must consist of letters and numbers only</span>';
	  return;
      }

      let myResponse = await fetch("login.php", {
	  method: 'POST',
	  headers: {'Accept': 'application/json', 'Content-Type': 'application/json'},
	  body: JSON.stringify({username: username, password: password})
	  });
      let result = await myResponse.json();
      document.getElementById('output1').innerHTML = JSON.stringify(result);
    
  }