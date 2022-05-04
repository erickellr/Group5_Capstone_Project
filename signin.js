  async function signin() {

      query = document.getElementById('PW').value;
      var alphaNRegEx = /^[0-9a-zA-Z]+$/;
            if (!query.match(alphaNRegEx)) {
	  document.getElementById('output1').innerHTML = '<span style=color:red;>Username must consist of letters & numbers only</span>';
	  return;
      }
	
      if (query.length < 2) {
	  document.getElementById('output1').innerHTML = '<span style=color:red;>Member last name must exceed one letter</span>';
	  return;
      }

      let myResponse = await fetch("signin.php", {
	  method: 'POST',
	  headers: {'Accept': 'application/json', 'Content-Type': 'application/json'},
	  body: JSON.stringify({PW: PW})
	  });
      
      let result = await myResponse.json();
      let output = JSON.stringify(result)
      console.log(output)
    }