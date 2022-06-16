
var CSX_hooks = {};

var CSX_Columns_Count=0;

function CSX_add_action(name, func) {
  if(!CSX_hooks[name]) CSX_hooks[name] = [];
  CSX_hooks[name].push(func);
}

function CSX_do_action(name, ...params){
  if(CSX_hooks[name]) 
     CSX_hooks[name].forEach(func => func(...params));
}