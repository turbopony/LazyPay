<!DOCTYPE html>
<html>
  <head>
    <title><? echo $this->config->item('site_name'); ?> админ-панель</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="<? echo site_url('/assets/css/bootstrap.min.css'); ?>" rel="stylesheet" media="screen">
    <link href="<? echo site_url('/assets/css/bootstrap-datetimepicker.min.css'); ?>" rel="stylesheet" media="screen">
	   <link href="<? echo site_url('/assets/css/font-awesome.min.css'); ?>" rel="stylesheet" media="screen">
	<script src="http://code.jquery.com/jquery.js"></script>
	<script type="text/javascript" src="http://code.jquery.com/ui/1.10.0/jquery-ui.js"></script>
	<script src="<? echo site_url('/assets/js/bootstrap.min.js'); ?>"></script>
	<script type="text/javascript" src="<? echo site_url('/assets/js/tinymce/tinymce.min.js'); ?>"></script>
	<script type="text/javascript" src="<? echo site_url('/assets/js/custom.js'); ?>"></script>
	<script type="text/javascript" src="<? echo site_url('/assets/js/moment.js'); ?>"></script>
	<script type="text/javascript" src="<? echo site_url('/assets/js/bootstrap-datetimepicker.min.js'); ?>"></script>
	<script type="text/javascript" src="<? echo site_url('/assets/js/bootstrap-datetimepicker.rus.js'); ?>"></script>
    <script src="<? echo site_url('/assets/js/respond.js'); ?>"></script>
	<script type="text/javascript">
tinymce.init({
    selector: "textarea.tinymce",
    plugins: [
        "advlist autolink lists link image charmap print preview anchor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime media table contextmenu paste"

    ],
	language : "ru_RU",
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"

});
</script>
	<script type="text/javascript">
	$(document).ready(function() {
	var fixHelper = function(e, ui) {
		ui.children().each(function() {
			$(this).width($(this).width());
		});
		return ui;
	};
    $( ".tblsort tbody" ).sortable({
		helper: fixHelper,
        opacity: 0.8, 
        cursor: 'move', 
        tolerance: 'pointer',  
        items:'tr',
        placeholder: 'state', 
        forcePlaceholderSize: true,
        update: function(event, ui){
            $.ajax({
                url: "/admin/goods/chg_order_ajax",
                type: 'POST',
                data: $(this).sortable("serialize"), 
            });
//-------------------------------                                
            }
                
        });

		$( ".tblsort tbody" ).disableSelection();
	});  
	</script>
 </head>
