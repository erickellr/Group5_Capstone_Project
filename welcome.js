
async function storeUserInfo(){
  console.log("inside function")
    let myResponse = await fetch("userInfo.php", {
	  method: 'POST',
	  headers: {'Accept': 'application/json', 'Content-Type': 'application/json'},
	  body: JSON.stringify({loginID: loginID, password: password})
	  });
  console.log("waiting")
  let result = await myResponse.json();
  console.log(result)
  document.getElementById('output1').innerHTML = JSON.stringify(result);
}