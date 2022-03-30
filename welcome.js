  async function callBackend() {

      loginID = document.getElementById('loginID').value;
      password = document.getElementById('password').value;
      var alphaNumericRegEx = /^[0-9a-zA-Z]+$/;
      if (!loginID.match(alphaNumericRegEx)) {
	  document.getElementById('output1').innerHTML = '<span style=color:red;>Login ID must consist of letters and numbers only</span>';
	  return;
      }
      if ((password.length < 1) || (!password.match(alphaNumericRegEx))) {
	  document.getElementById('output1').innerHTML = '<span style=color:red;>Password must not be empty and must consist of letters and numbers only</span>';
	  return;
      }

      let myResponse = await fetch("userinfo.php", {
	  method: 'POST',
	  headers: {'Accept': 'application/json', 'Content-Type': 'application/json'},
	  body: JSON.stringify({loginID: loginID, password: password})
	  });
      let result = await myResponse.json();
      document.getElementById('output1').innerHTML = JSON.stringify(result);
    
  }