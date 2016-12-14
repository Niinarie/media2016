// Validate email and check if passwords match
    
var form = document.querySelector("form");

function validate(e){
    
    var errorDiv = document.getElementById("errors");
    errorDiv.innerHTML= "";
    var inputs = document.querySelectorAll('input');
    for (var p = 0; p < inputs.length; p++){
         inputs[p].removeAttribute('style');
            console.log(inputs[p]);
    } 
    
    //Check if all required fields are filled 
    var req = document.querySelectorAll('input[required]');
    for (var i = 0; i < req.length; i++){
            if (req[i].value.length===0){
                req[i].setAttribute('style','border: 2px solid red;');
                e.preventDefault();
                if(errorDiv.length===0){
                    errorDiv.innerHTML= "Please fill all the fields.";
                }
            } 
    }
    //Check patterns
    var pat = document.querySelectorAll('input[pattern]');
    for (var j = 0; j < pat.length; j++){
        var patt = new RegExp(pat[j].pattern);
        
        if (!(pat[j].value.match(patt))){
            if (pat[j].value !== ''){
                pat[j].setAttribute('style','color:red');
                e.preventDefault();
            }}
    }    
    
    
    // Check if password fields match
    var n1 = document.getElementById("pw1");
    var n2 = document.getElementById("pw2");
        if(n1.value!=="" && n2.value!==""){
            if(n1.value !== n2.value){
                errorDiv.innerHTML=("Passwords don't match.");
                e.preventDefault();    
            }
        }

   
};

form.addEventListener('submit',validate);