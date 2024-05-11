<script type="text/javascript" charset="utf-8">
"use strict";
function readUrl(input) {
 
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function (e) {
      var imgData = e.target.result;
      var imgName = input.files[0].name;
      input.setAttribute("data-title", imgName);
      console.log(e.target.result);
    };
    reader.readAsDataURL(input.files[0]);
  }
}
</script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"></script>
<script src="<?php echo base_url().'assets/js/bootstrap.min.js'; ?>"></script>
<script src="<?php echo base_url().'assets/js/anthon.js'; ?>"></script>