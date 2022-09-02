
$( document ).ready(function() {
  let deviceBrande = $('#Vetement_categorie');
  // console.log(deviceBrande)
  deviceBrande.change(function() {
      // ... retrieve the corresponding form.
      var form = $(this).closest('form');
      
      // Simulate form data, but only include the selected sport value.
      var data = {};
      
      data[deviceBrande.attr('name')] = deviceBrande.val();
   
      // Submit data via AJAX to the form's action path.
      $.ajax({
          url : form.attr('action'),
          type: form.attr('method'),
          data : data,
          complete: function(html) {
          // Replace current position field ...
          $('#Vetement_sousCategorie').replaceWith(
              // ... with the returned one from the AJAX response.
              $(html.responseText).find('#Vetement_sousCategorie')
          );

          // Position field now displays the appropriate positions.
          }
      });
      
  });

});

