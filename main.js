(function() {

  var button = document.querySelector('#submit-button');
  var action = button.dataset.action;

    $(document).ready(function() {
      $.ajax({
        method: 'GET',
        url: 'api/'+action,
        done: function(response) {
          console.log("Finished: " + response);
        }
      });
    });

})();
