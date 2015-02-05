(function() {

  var button = document.querySelector('#submit-button');
  var input = document.querySelector('input');
  var action = button.dataset.action;

    $(button).click(function() {
      $.ajax({
        method: 'GET',
        url: 'api/'+action,
        data: {'value': input.value} 
      }).done(function(response) {
        console.log("Finished: " + response);
      });
    });

})();
