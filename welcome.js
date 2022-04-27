  async function queryDB() {

      query = document.getElementById('queryBox').value;
      var alphaNRegEx = /^[0-9a-zA-Z]+$/;
            if (!query.match(alphaNRegEx)) {
	  document.getElementById('output1').innerHTML = '<span style=color:red;>Username must consist of letters & numbers only</span>';
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
      console.log(output)
      if (output == '{"info":null}'){
	document.getElementById('output1').innerHTML = "Member does not exist!";
      }
      else{
			if (output == 1){
				var obj = JSON.parse(output)
				var values = Object.keys(obj).map(function (key) { return obj[key]; });
				nameString = values.join();
				outputMessage = nameString.replace(/,/g, '') + " membership is ACTIVE"
				document.getElementById('output1').innerHTML = outputMessage;
			} else {
				var obj = JSON.parse(output)
				var values = Object.keys(obj).map(function (key) { return obj[key]; });
				nameString = values.join();
				outputMessage = nameString.replace(/,/g, '') + " membership is NOT ACTIVE"
				document.getElementById('output1').innerHTML = outputMessage;
			}
    
      }
    
  }