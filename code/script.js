
// var para = document.createElement("p");
// var node = document.createTextNode("This is new.");
// para.appendChild(node);

// var element = document.getElementById("div1");
// element.appendChild(para);


function addAdult() {
    var append_list = document.createElement('ul');
    
    var list = document.createElement('li');
    var input = document.createElement('input');
    input.name = "first_name[]";
    input.type = "text";
    input.placeholder = "First Name";
    list.appendChild(input);
    append_list.appendChild(list);
    
    list = document.createElement('li');
    input = document.createElement('input');
    input.name = "last_name[]";
    input.type = "text";
    input.placeholder = "Last Name";
    list.appendChild(input);
    append_list.appendChild(list);
    
    list = document.createElement('li');
    input = document.createElement('input');
    input.name = "email[]";
    input.type = "text";
    input.placeholder = "Email";
    list.appendChild(input);
    append_list.appendChild(list);
    
    list = document.createElement('li');
    input = document.createElement('input');
    input.name = "address[]";
    input.type = "text";
    input.placeholder = "Address";
    list.appendChild(input);
    append_list.appendChild(list);
    
    list = document.createElement('li');
    input = document.createElement('input');
    input.name = "phone[]";
    input.type = "text";
    input.placeholder = "Phone";
    list.appendChild(input);
    append_list.appendChild(list);
    
    addItem("adultList", append_list);
}

function addChild(){
     var append_list = document.createElement('ul');
    
    var list = document.createElement('li');
    var input = document.createElement('input');
    input.name = "child_first_name[]";
    input.type = "text";
    input.placeholder = "First Name";
    list.appendChild(input);
    append_list.appendChild(list);
    
    list = document.createElement('li');
    input = document.createElement('input');
    input.name = "child_last_name[]";
    input.type = "text";
    input.placeholder = "Last Name";
    list.appendChild(input);
    append_list.appendChild(list);
    
    list = document.createElement('li');
    input = document.createElement('input');
    input.name = "child_email[]";
    input.type = "text";
    input.placeholder = "Email";
    list.appendChild(input);
    append_list.appendChild(list);
    
    list = document.createElement('li');
    input = document.createElement('input');
    input.name = "child_address[]";
    input.type = "text";
    input.placeholder = "Address";
    list.appendChild(input);
    append_list.appendChild(list);
    
    list = document.createElement('li');
    input = document.createElement('input');
    input.name = "child_phone[]";
    input.type = "text";
    input.placeholder = "Phone";
    list.appendChild(input);
    append_list.appendChild(list);
    
    addItem("childList", append_list);  
}

function addItem(element_id, append_item){
    var element = document.getElementById(element_id);    
    element.appendChild(append_item);
}