 function highlightEdit(editableObj) {
     $(editableObj).css("background", "#FFF");
 }

 function saveInlineEdit(editableObj, column, student, ct) { // no change change made then return false
     if ($(editableObj).attr('data-old_value') === $.trim(editableObj.innerHTML)) return false; // send ajax to update value
     $(editableObj).css("background", "#FFF url(loader.gif) no-repeat right");

     $.ajax({
         url: "saveInlineEdit.php",
         cache: false,
         data: 'column=' + column + '&marks=' + $.trim(editableObj.innerHTML) + '&student=' + student + '&ct=' + ct,
         success: function(response) {

             //  console.log(response);
             // set updated value as old value
             $(editableObj).attr('data-old_value', $.trim(editableObj.innerHTML));
             //  $(editableObj).attr('value', "Hello");
             $(editableObj).css("background", "");
         }
     });
 }