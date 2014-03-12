<!DOCTYPE html>
<html>
    <head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta name="robots" content="noindex,nofollow">
        <?php echo $this->Html->charset(); ?>
        <title>
            <?php
                echo (Configure::read("Siteinfo.sitename")) ? Configure::read("Siteinfo.sitename") : "Mahoney";
                echo " | ";
                echo $pageTitle;
            ?>
        </title>
        <?php
        echo $this->Html->meta('icon');
        
        echo $this->Html->css("System.../com/css/filemanager/bootstrap.min.css");
        echo $this->Html->css("System.../com/css/filemanager/bootstrap-responsive.min.css");
        echo $this->Html->css("System.../com/css/filemanager/bootstrap-lightbox.min.css");
        echo $this->Html->css('../com/css/font-awesome/font-awesome.min');
        echo $this->Html->css("System.../com/css/filemanager/style.css");
	echo $this->Html->css("System.../com/css/filemanager/dropzone.css");
	echo $this->Html->css("System.../com/css/filemanager/jquery.contextMenu.min.css");
	echo $this->Html->css("System.../com/css/filemanager/bootstrap-modal.min.css");
	echo $this->Html->css("System.../com/css/filemanager/jPlayer/skin/blue.monday/jplayer.blue.monday.css");
        
        echo $this->fetch('meta');
        echo $this->fetch('css');
        ?>
	<!--[if lt IE 8]><style>
	.img-container span, .img-container-mini span {
	    display: inline-block;
	    height: 100%;
	}
	</style><![endif]-->
	<?php
        echo $this->Html->script("../com/js/jquery/jquery-1.11.0.min");
        echo $this->Html->script("System.../com/js/filemanager/bootstrap.min.js");
        echo $this->Html->script("System.../com/js/filemanager/bootstrap-lightbox.min.js");
	echo $this->Html->script("System.../com/js/filemanager/dropzone.min.js");
	echo $this->Html->script("System.../com/js/filemanager/jquery.touchSwipe.min.js");
	echo $this->Html->script("System.../com/js/filemanager/modernizr.custom.js");
	echo $this->Html->script("System.../com/js/filemanager/bootbox.min.js");
	echo $this->Html->script("System.../com/js/filemanager/bootstrap-modal.min.js");
	echo $this->Html->script("System.../com/js/filemanager/bootstrap-modalmanager.min.js");
	echo $this->Html->script("System.../com/js/filemanager/jPlayer/jquery.jplayer.min.js");
	echo $this->Html->script("System.../com/js/filemanager/imagesloaded.pkgd.min.js");
	echo $this->Html->script("System.../com/js/filemanager/jquery.queryloader2.min.js");
        ?>
        
	<?php
	if($aviary_active):
            if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443):
                echo $this->Html->script("https://dme0ih8comzn4.cloudfront.net/js/feather.js");
            else:
                echo $this->Html->script("http://feather.aviary.com/js/feather.js");
            endif;
        endif;

	echo $this->Html->script("System.../com/js/filemanager/jquery.ui.position.min.js");
	echo $this->Html->script("System.../com/js/filemanager/jquery.contextMenu.min.js");
        ?>
	<script>
	    var ext_img=new Array('<?php echo implode("','", $ext_img)?>');
	    var allowed_ext=new Array('<?php echo implode("','", $ext)?>');
	    var loading_bar=<?php echo $loading_bar?"true":"false"; ?>;
	    var image_editor=<?php echo $aviary_active?"true":"false"; ?>;
	    //dropzone config
	    Dropzone.options.myAwesomeDropzone = {
		    dictInvalidFileType: "<?php echo lang_Error_extension;?>",
		    dictFileTooBig: "<?php echo lang_Error_Upload; ?>",
		    dictResponseError: "SERVER ERROR",
		    paramName: "file", // The name that will be used to transfer the file
		    maxFilesize: <?php echo $MaxSizeUpload; ?>, // MB
		    url: "upload",
		    accept: function(file, done) {
		    var extension=file.name.split('.').pop();
		    extension=extension.toLowerCase();
		      if ($.inArray(extension, allowed_ext) > -1) {
			done();
		      }
		      else { done("<?php echo lang_Error_extension;?>"); }
		    }
	    };
	    if (image_editor) {
	    var featherEditor = new Aviary.Feather({
		apiKey: "<?php echo $aviary_key; ?>",
		apiVersion: <?php echo $aviary_version; ?>,
		language: "<?php echo $aviary_language; ?>",
	       theme: 'light',
	       tools: 'all',
	       onSave: function(imageID, newURL) {
		    show_animation();
		    var img = document.getElementById(imageID);
		    img.src = newURL;
		    $.ajax({
			type: "POST",
			url: "ajaxcalls?action=save_img",
			data: { url: newURL, path:$('#sub_folder').val()+$('#fldr_value').val(), name:$('#aviary_img').data('name') }
		    }).done(function( msg ) {			
			featherEditor.close();
			d = new Date();
			$("figure[data-name='"+$('#aviary_img').data('name')+"']").find('img').each(function(){
			    $(this).attr('src',$(this).attr('src')+"?"+d.getTime());
			    });
			$("figure[data-name='"+$('#aviary_img').data('name')+"']").find('figcaption a.preview').each(function(){
			    $(this).data('url',$(this).data('url')+"?"+d.getTime());
			    });
			hide_animation();
		    });
		    return false;
	       },
	       onError: function(errorObj) {
		   bootbox.alert(errorObj.message);
	       }
	    
	   });
	    }
	</script>
        <?php
	echo $this->Html->script("System.../com/js/filemanager/include.js");
        ?>
    </head>
    <body>
        <?php echo $this->fetch('content'); ?>
    </body>
</html>