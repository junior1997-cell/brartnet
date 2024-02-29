<!-- Custom-Switcher JS -->
<script src="../assets/js/custom-switcher.min.js"></script>

<!-- Custom JS -->
<script src="../assets/js/custom.js"></script>

<script>

  // $(".btn-modal-effect").each(function() {
  //   $(this).click(function(e) { e.preventDefault(); let effect = $(this).data('bs-effect'); $(".modal-effect").addClass(effect); });
  // });

  // $('.modal-effect').on('hidden.bs.modal', function(e) {
  //   let removeClass = $(this).attr('class').match(/(^|\s)effect-\S+/g); removeClass = removeClass[0].trim(); $(this).removeClass(removeClass);
  // });

  // Foco en el buscador de Select2
  $(document).on('select2:open', () => {  document.querySelector('.select2-search__field').focus(); });
  
</script>