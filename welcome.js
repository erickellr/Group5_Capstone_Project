  async function queryDB() {

      query = document.getElementById('queryBox').value;
      var alphaRegEx = /^[A-Za-z]+$/;
            if (!query.match(alphaRegEx)) {
	  document.getElementById('output1').innerHTML = '<span style=color:red;>Member last name must consist of letters only</span>';
	  return;
      }

      if (query.length < 2) {
	  document.getElementById('output1').innerHTML = '<span style=color:red;>Member last name must exceed one letter</span>';
	  return;
      }

      let myResponse = await fetch("query.php", {
	  method: 'POST',
	  headers: {'Accept': 'application/json', 'Content-Type': 'application/json'},
	  body: JSON.stringify({query: query})
	  });
      let result = await myResponse.json();
      let output = JSON.stringify(result)
      if (output == '{"status":false,"info":"invalid last name"}'){
	document.getElementById('output1').innerHTML = "Invalid Last Name!";
      }
      else{
	document.getElementById('output1').innerHTML = "User Match";
      }
    
  }