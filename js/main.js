(function ($) {
  "use strict";

  /* ============================ FUNCTIONS ============================== */

  function removeScript(input){
      input = input.replace(/script/g, "THISISNOTASCRIPTREALLY");
      return input;
    }
  
  /* ============================ FORMS ============================== */

  /* ============================ SMALL FORM ============================== */

  var numOfInsurants = 0;
  var insurantID = 0;

  $("#insurant-form").submit(function(e){
    e.preventDefault();

    var firstname = $("#firstname-insurant").val();
    var lastname = $("#lastname-insurant").val();
    var email = $("#email-insurant").val();
    var date = $("#date-insurant").val();

    firstname = removeScript(firstname);
    lastname = removeScript(lastname);

    if(numOfInsurants < 4){
      numOfInsurants++;
      insurantID++;
      $(".insurant-message").append("<div class='delete-insurant-div' id='insurantID" + insurantID + "'>" + firstname + " " + lastname + " " + email + " " + date + " <i class='fa fa-times delete-insurant'></i></div>");
      $('#exampleModal').modal('hide');

    
      $(".hidden-inputs").append('<input type="hidden" name="insurantfirstname' + insurantID + '" value="' + firstname + '">');
      $(".hidden-inputs").append('<input type="hidden" name="insurantlastname' + insurantID + '" value="' + lastname + '">');
      $(".hidden-inputs").append('<input type="hidden" name="insurantemail' + insurantID + '" value="' + email + '">');
      $(".hidden-inputs").append('<input type="hidden" name="insurantdate' + insurantID + '" value="' + date + '">');
      
    
      $("#firstname-insurant").val("");
      $("#lastname-insurant").val("");
      $("#email-insurant").val("");
      $("#date-insurant").val("");
    }else{
      alert("Maximum is four insurants.");
      $('#exampleModal').modal('hide');
      return;
    }     
  });

  $(document).on('click', '.delete-insurant', function(e) {
    var id = $(this).parent('div').attr("id");
    id = id.substring(10, 11);
    // alert("'" + id + "'");

    $("input[name='insurantfirstname" + id + "']").remove();
    $("input[name='insurantlastname" + id + "']").remove();
    $("input[name='insurantemail" + id + "']").remove();
    $("input[name='insurantdate" + id + "']").remove();

    insurantID = id - 1;
    numOfInsurants--;
    $(this).parent('div').remove();
  }); 

 /* ============================ BIG FORM ============================== */

  $(".validate-form").submit(function(e){
    var name = $("#nameC").val();

    name = name.replace(/script/g, "THISISNOTASCRIPTREALLY");

    $("#name").val(name);

    if($("#insuranceC").val() == "group-insurance"){
      if(numOfInsurants < 1){
        alert("Please add at least one insurant or choose 'Individual Insurance'");
        return false;
      }
    }

    return true;
  });

 /* ============================ DATES ============================== */

// SOURCE: https://stackoverflow.com/questions/2627473/how-to-calculate-the-number-of-days-between-two-dates

  var date = new Date();
  var year = date.getFullYear();
  var month = date.getMonth() + 1;
  var day = date.getDate();
  $("#dateFrom").attr("min", year + "-" + month + "-" + day);  
  $("#dateTo").attr("min", year + "-" + month + "-" + day);  

  // SUGGESTED DAYS !!!!

  $("#dateFrom").change(function(){
    if($("#dateTo").val() == ""){
      $(".numberofdays").html("Number of days: 0");
    }else{
      var dateFrom = $("#dateFrom").val();
      var dateTo = $("#dateTo").val();

      dateFrom = new Date(dateFrom);
      dateTo = new Date(dateTo);

      var oneDay = 24 * 60 * 60 * 1000; // hours*minutes*seconds*milliseconds    
      var diffDays = Math.round((dateTo.getTime() - dateFrom.getTime()) / (oneDay));

      if(diffDays <= 0){
        alert("Please choose correct date.");
        $("#dateFrom").val('');
        $("#dateTo").val('');
        $(".numberofdays").html("Number of days: 0");
      }else{
        $(".numberofdays").html("Number of days: " + diffDays);
      }
    }
  });

  $("#dateTo").change(function(){
    if($("#dateFrom").val() == ""){
      $(".numberofdays").html("Number of days: 0");
    }else{
      var dateFrom = $("#dateFrom").val();
      var dateTo = $("#dateTo").val();

      dateFrom = new Date(dateFrom);
      dateTo = new Date(dateTo);

      var oneDay = 24 * 60 * 60 * 1000; // hours*minutes*seconds*milliseconds    
      var diffDays = Math.round((dateTo.getTime() - dateFrom.getTime()) / (oneDay));

      if(diffDays <= 0){
        alert("Please choose correct date.");
        $("#dateFrom").val('');
        $("#dateTo").val('');
        $(".numberofdays").html("Number of days: 0");
      }else{
        $(".numberofdays").html("Number of days: " + diffDays);
      }
    }
  });


})(jQuery);
