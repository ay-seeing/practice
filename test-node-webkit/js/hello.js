var i = 0;
exports.callback = function(){
  console.log(i + ": " + window.location);
  window.alert ("i = " + i);
  i = i + 1;
}

